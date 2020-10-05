<?php

declare(strict_types=1);

include_once dirname(__DIR__) . 'AbstractManagerController.php';

class msProdSubMgrHomeManagerController extends AbstractManagerController
{
    protected const STYLES = [
        'mgr/main.css'
    ];

    protected const SCRIPTS = [
        'mgr/msprodsub.js',
        'mgr/misc/utils.js',
        'mgr/misc/combo.js',
        'mgr/widgets/administration/receipt.grid.js',
        'mgr/widgets/administration/sent.grid.js',
        'mgr/widgets/administration/delayedmailing.grid.js',
        'mgr/widgets/administration/admin.panel.js',
        'mgr/pages/home.js'
    ];
}
