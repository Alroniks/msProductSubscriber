<?php

class msInformUserMailingGroupRemoveProcessor extends modObjectProcessor
{
    public $classKey = 'msInformUserMailingGroup';
    public $languageTopics = ['msinformuser'];
    //public $permission = 'remove';


    /**
     * @return array|string
     */
    public function process()
    {
        if (!$this->checkPermissions()) {
            return $this->failure($this->modx->lexicon('access_denied'));
        }

        $ids = $this->modx->fromJSON($this->getProperty('ids'));
        if (empty($ids)) {
            return $this->failure($this->modx->lexicon('msinformuser_mailing_err_ns'));
        }

        foreach ($ids as $id) {
            /** @var msInformUserMailing $object */
            if (!$object = $this->modx->getObject($this->classKey, $id)) {
                return $this->failure($this->modx->lexicon('msinformuser_mailing_err_nf'));
            }
            $object->remove();
        }
        return $this->success();
    }

}
return 'msInformUserMailingGroupRemoveProcessor';