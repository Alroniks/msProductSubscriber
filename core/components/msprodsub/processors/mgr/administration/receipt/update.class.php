<?php

class msInformUserReceiptUpdateProcessor extends modObjectUpdateProcessor
{
    public $classKey = 'msInformUserArrival';
    public $languageTopics = ['msinformuser'];
    //public $permission = 'save';


    /**
     * We doing special check of permission
     * because of our objects is not an instances of modAccessibleObject
     *
     * @return bool|string
     */
    public function beforeSave()
    {
        if (!$this->checkPermissions()) {
            return $this->modx->lexicon('access_denied');
        }
        return true;
    }

    /**
     * @return bool
     */
    public function beforeSet()
    {
        $id = (int)$this->getProperty('id');
        $email = trim($this->getProperty('email'));
        if (empty($id)) {
            return $this->modx->lexicon('msinformuser_err_subscription_ns');
        }

        if (empty($email)) {
            $this->modx->error->addField('email', $this->modx->lexicon('msinformuser_err_not_email'));
        }
        return parent::beforeSet();
    }
}
return 'msInformUserReceiptUpdateProcessor';
