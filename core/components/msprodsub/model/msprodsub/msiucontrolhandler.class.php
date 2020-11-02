<?php

interface msIuControlInterface
{
    /** @return array $control */
    public function get();
}


class msIuControlHandler implements msIuControlInterface
{
    /** @var modX $modx */
    public $modx;
    /** @var msInformUser $msInformUser */
    public $msInformUser;
    /** @var array $config */
    public $config;

    /** @var array $list */
    protected $list;


    /**
     * msIuCountHandler constructor.
     * @param msInformUser $msInformUser
     * @param array $config
     */
    function __construct(msInformUser &$msInformUser, array $config = [])
    {
        $this->msInformUser = &$msInformUser;
        $this->modx = &$msInformUser->modx;
    }

    /**
     * @return array|void
     */
    public function get()
    {
        $time = time();
        $list = [];

        $q = $this->modx->newQuery('modResource');
        $q->innerJoin('msInformUserArrival', 'Arrival',
            ["modResource.id = Arrival.res_id AND {$time} >= Arrival.senddate"]);
        $q->innerJoin('msInformUserMailing', 'Mailing', ['Arrival.mailing_index = Mailing.id']);
        $q->leftJoin('modUserProfile', 'UserProfile', ['Arrival.user_id = UserProfile.internalKey']);
        $q->select($this->modx->getSelectColumns('modResource', 'modResource', ''));
        $q->select($this->modx->getSelectColumns('msInformUserArrival', 'Arrival', 'arrival_'));
        $q->select($this->modx->getSelectColumns('msInformUserMailing', 'Mailing', 'mailing_'));
        $q->select($this->modx->getSelectColumns('modUserProfile', 'UserProfile', 'profile_'));
        $q->where([
            'deleted' => 0,
            'iu_control_date:>' => 0,
            'Arrival.status:IN' => [1, 3],
            'Arrival.mailing_index:NOT IN' => [1, 2],
            'Mailing.active' => 1,
        ]);
        $q->limit($this->config['limitSend']);

        if ($q->prepare() && $q->stmt->execute()) {
            while ($row = $q->stmt->fetch(PDO::FETCH_ASSOC)) {
                $list[] = $row;
            }
        }

        $this->list = $list;

        if (!empty($list)) {
            $this->msInformUser->prepareSending($list);
        }

        return;

    }
}
