<?php

class msInformUserSentGetListProcessor extends modObjectGetListProcessor
{
    public $classKey = 'msInformUserArrival';
    public $defaultSortField = 'senddate';
    public $defaultSortDirection = 'DESC';
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
     *
     * @return xPDOQuery
     */
    public function prepareQueryBeforeCount(xPDOQuery $c)
    {
        $query = trim($this->getProperty('query'));
        if ($query) {
            $c->where([
                'title:LIKE' => "%{$query}%",
                'OR:email:LIKE' => "%{$query}%",
            ]);
        }
        $c->where([
            'status' => 2,
        ]);
        return $c;
    }

    /**
     * @param xPDOObject $object
     *
     * @return array
     */
    public function prepareRow(xPDOObject $object)
    {
        $obj = $object->getOne('Mailing');
        $arr = $obj->toArray();
        $array = $object->toArray();
        $array = array_merge($arr, $array);
        $array['actions'] = [];

        // Send
//        if ($array['mailing_index'] != 2) {
//            $array['actions'][] = [
//                'cls' => '',
//                'icon' => 'icon icon-send',
//                'title' => $this->modx->lexicon('msinformuser_send'),
//                'action' => 'sendReceipt',
//                'button' => true,
//                'menu' => true,
//            ];
//        }
        // Edit
//        if ($array['status'] != 2) {
//            $array['actions'][] = [
//                'cls' => '',
//                'icon' => 'icon icon-edit',
//                'title' => $this->modx->lexicon('msinformuser_update'),
//                'action' => 'updateReceipt',
//                'button' => true,
//                'menu' => true,
//            ];
//        }
        // Remove
        $array['actions'][] = [
            'cls' => '',
            'icon' => 'icon icon-trash-o action-red',
            'title' => $this->modx->lexicon('msinformuser_remove'),
            'multiple' => $this->modx->lexicon('msinformuser_remove'),
            'action' => 'removeReceipt',
            'button' => true,
            'menu' => true,
        ];

        $statuses = [
            1 => $this->modx->lexicon('msinformuser_expect'),
            2 => '<span style="color: green">' . $this->modx->lexicon('msinformuser_informed') . '</span>',
            3 => '<span style="color: red">' . $this->modx->lexicon('msinformuser_err') . '</span>',
        ];
        if (!$array['senddate']) {
            $array['senddate'] = '';
        }
        if (!$array['user_id']) {
            $array['user_id'] = 'N/A';
        }
        $array['status'] = $statuses[$array['status']];
        return $array;
    }
}
return 'msInformUserSentGetListProcessor';