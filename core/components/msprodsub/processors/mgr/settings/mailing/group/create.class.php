<?php

class msInformUserMailingGroupCreateProcessor extends modObjectCreateProcessor
{
//    public $objectType = 'msInformUserItem';
    public $classKey = 'msInformUserMailingGroup';
    public $languageTopics = ['msinformuser'];
    //public $permission = 'create';


    /**
     * @return bool
     */
    public function beforeSet()
    {
        $name = trim($this->getProperty('name'));
        if (empty($name)) {
            $this->modx->error->addField('name', $this->modx->lexicon('msinformuser_mailing_err_name'));
        } elseif ($this->modx->getCount($this->classKey, ['name' => $name])) {
            $this->modx->error->addField('name', $this->modx->lexicon('msinformuser_mailing_err_ae'));
        }

        return parent::beforeSet();
    }

}

return 'msInformUserMailingGroupCreateProcessor';