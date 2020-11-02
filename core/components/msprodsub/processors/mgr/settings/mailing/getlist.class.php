<?php

class msInformUserMailingGetListProcessor extends modObjectGetListProcessor
{
    public $classKey = 'msInformUserMailing';
    public $defaultSortField = 'id';
    public $defaultSortDirection = 'ASC';
    //public $permission = 'list';


    /**
     * We do a special check of permissions
     * because our objects is not an instances of modAccessibleObject
     *
     * @return boolean|string
     */
    public function beforeQuery()
    {
        if (!$this->checkPermissions()) {
            return $this->modx->lexicon('access_denied');
        }

        return true;
    }

    /**
     * @param xPDOQuery $c
     * @return xPDOQuery
     */
    public function prepareQueryBeforeCount(xPDOQuery $c)
    {
        $query = trim($this->getProperty('query'));
        if ($query) {
            $c->where([
                'name:LIKE' => "%{$query}%",
                'OR:description:LIKE' => "%{$query}%",
                'OR:subject:LIKE' => "%{$query}%",
            ]);
        }

        return $c;
    }

    /**
     * @param xPDOObject $object
     * @return array
     */
    public function prepareRow(xPDOObject $object)
    {
        $array = $object->toArray();
        $array['actions'] = [];

        if($array['template']) {
            if ($chunk = $this->modx->getObject('modChunk', ['id' => $array['template']])) {
                $array['template'] = $chunk->name;
            }
        }
        if ($array['group']) {
            if ($group = $this->modx->getObject('msInformUserMailingGroup', (int) $array['group'])) {
                $array['group'] = $group->name;
            }
        }

        // Edit
        $array['actions'][] = [
            'cls' => '',
            'icon' => 'icon icon-edit',
            'title' => $this->modx->lexicon('msinformuser_update'),
            'action' => 'updateMailing',
            'button' => true,
            'menu' => false,
        ];

        if (!$array['active']) {
            $array['actions'][] = [
                'cls' => '',
                'icon' => 'icon icon-power-off action-green',
                'title' => $this->modx->lexicon('msinformuser_enable'),
                'multiple' => $this->modx->lexicon('msinformuser_enable'),
                'action' => 'enableMailing',
                'button' => true,
                'menu' => false,
            ];
        } else {
            $array['actions'][] = [
                'cls' => '',
                'icon' => 'icon icon-power-off action-gray',
                'title' => $this->modx->lexicon('msinformuser_disable'),
                'multiple' => $this->modx->lexicon('msinformuser_disable'),
                'action' => 'disableMailing',
                'button' => true,
                'menu' => false,
            ];
        }

        // Queue
        $array['actions'][] = [
            'cls' => '',
            'icon' => 'icon icon-users',
            'title' => 'Добавить в очередь',
            'action' => 'addQueueMailingGroup',
            'button' => false,
            'menu' => true,
        ];

        if ($array['editable']) {
            // Remove
            $array['actions'][] = [
                'cls' => '',
                'icon' => 'icon icon-trash-o action-red',
                'title' => $this->modx->lexicon('msinformuser_remove'),
                'multiple' => $this->modx->lexicon('msinformuser_remove'),
                'action' => 'removeMailing',
                'button' => false,
                'menu' => true,
            ];

            // Menu
            $array['actions'][] = array(
                'cls' => '',
                'icon' => 'icon icon-cog actions-menu',
                'menu' => false,
                'button' => true,
                'action' => 'showMenu',
                'type' => 'menu',
            );
        }

        return $array;
    }

}
return 'msInformUserMailingGetListProcessor';