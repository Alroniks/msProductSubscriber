<?php

class msInformUserArrival extends xPDOSimpleObject {

    public function save($cacheFlag = null) {
        if ($this->get('email') == '') {
            return false;
        }

        $hash = sha1(serialize(array(
            'email' => $this->email,
            'senddate' => $this->senddate,
            'mailing_index' => $this->mailing_index,
        )));
        $this->set('status', $this->status);
        $this->set('updatedon', $this->updatedon);
        $this->set('senddate', $this->senddate);

        if (!$this->xpdo->getCount('msInformUserArrival', array('hash' => $hash))) {
            $this->set('hash', $hash);
        }
        return parent::save($cacheFlag);
    }
}