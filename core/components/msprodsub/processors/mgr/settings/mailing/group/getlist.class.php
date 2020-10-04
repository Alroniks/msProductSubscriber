<?php

class msInformUserMailingGroupGetListProcessor extends modObjectGetListProcessor
{
//    public $objectType = 'msInformUserItem';
    public $classKey = 'msInformUserMailingGroup';
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
     * @param xPDOObject $object
     * @return array
     */
    public function prepareRow(xPDOObject $object)
    {
        $array = $object->toArray();

        // Combo box
        if ($this->getProperty('combo')) {
            return $array;
        }

        $array['actions'] = [];
        // Edit
        $array['actions'][] = [
            'cls' => '',
            'icon' => 'icon icon-edit',
            'title' => $this->modx->lexicon('msinformuser_update'),
            'action' => 'updateMailingGroup',
            'button' => true,
            'menu' => true,
        ];

        // Remove
        $array['actions'][] = [
            'cls' => '',
            'icon' => 'icon icon-trash-o action-red',
            'title' => $this->modx->lexicon('msinformuser_remove'),
            'multiple' => $this->modx->lexicon('msinformuser_remove'),
            'action' => 'removeMailingGroup',
            'button' => true,
            'menu' => true,
        ];

        return $array;
    }

}
return 'msInformUserMailingGroupGetListProcessor';