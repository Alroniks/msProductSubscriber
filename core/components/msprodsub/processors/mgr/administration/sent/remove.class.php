<?php

class msInformUserSentRemoveProcessor extends modObjectProcessor
{
    public $classKey = 'msInformUserArrival';

    public $languageTopics = ['msinformuser'];

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
            return $this->failure($this->modx->lexicon('msinformuser_err_subscription_ns'));
        }

        foreach ($ids as $id) {
            /** @var msInformUserArrival $object */
            if (!$object = $this->modx->getObject($this->classKey, $id)) {
                return $this->failure($this->modx->lexicon('msinformuser_err_subscription_nf'));
            }
            $object->remove();
        }
        return $this->success();
    }
}
return 'msInformUserSentRemoveProcessor';
