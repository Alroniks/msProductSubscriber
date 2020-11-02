<?php

/**
 * Class psArrival
 */
class psArrival extends xPDOSimpleObject
{
    public function save($cacheFlag = null)
    {
        if ($this->get('email') === '') {
            return false;
        }

        $hash = sha1(
            serialize(
                [
                    'email' => $this->email,
                    'senddate' => $this->senddate,
                    'mailing_index' => $this->mailing_index,
                ]
            )
        );
        $this->set('status', $this->status);
        $this->set('updatedon', $this->updatedon);
        $this->set('senddate', $this->senddate);

        if (!$this->xpdo->getCount('msInformUserArrival', ['hash' => $hash])) {
            $this->set('hash', $hash);
        }
        return parent::save($cacheFlag);
    }
}
