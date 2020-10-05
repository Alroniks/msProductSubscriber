<?php

interface msIuCountInterface
{
    /** @return array $count */
    public function get();
}


class msIuCountHandler implements msIuCountInterface
{
    /** @var modX $modx */
    public $modx;
    /** @var msInformUser $msInformUser */
    public $msInformUser;
    /** @var array $config */
    public $config;


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
     * @return array|bool
     */
    public function get()
    {
        $list = [];

        $q = $this->modx->newQuery('modResource');
        $q->leftJoin('msProductData', 'Data', ['modResource.id = Data.id']);
        $q->leftJoin('msVendor', 'Vendor', ['Data.vendor = Vendor.id']);
        $q->innerJoin('msInformUserArrival', 'Arrival', ['modResource.id = Arrival.res_id']);
        $q->innerJoin('msInformUserMailing', 'Mailing', ['Arrival.mailing_index = Mailing.index']);
        $q->select($this->modx->getSelectColumns('modResource', 'modResource', ''));
        $q->select($this->modx->getSelectColumns('msProductData', 'Data', 'product_'));
        $q->select($this->modx->getSelectColumns('msVendor', 'Vendor', 'vendor_'));
        $q->select($this->modx->getSelectColumns('msInformUserArrival', 'Arrival', 'arrival_'));
        $q->select($this->modx->getSelectColumns('msInformUserMailing', 'Mailing', 'mailing_'));
        $q->where([
            'published' => 1,
            'deleted' => 0,
            'iu_count:>' => 0,
            'Arrival.status:IN' => [1, 3],
            'Mailing.active' => 1,
        ]);
        $q->limit($this->config['limitSend']);

        if ($q->prepare() && $q->stmt->execute()) {
            while ($row = $q->stmt->fetch(PDO::FETCH_ASSOC)) {
                $list[] = $row;
            }
        }

        if (!empty($list)) {
            $this->msInformUser->prepareSending($list);
        }

        return true;
    }
}
