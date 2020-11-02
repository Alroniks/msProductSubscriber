<?php

declare(strict_types=1);

include_once dirname(__DIR__) . 'AbstractManagerController.php';

class msProdSubMgrSettingsManagerController extends modExtraManagerController
{
    protected const STYLES = [
        'mgr/main.css'
    ];

    protected const SCRIPTS = [
        'mgr/msprodsub.js',
        'mgr/misc/utils.js',
        'mgr/misc/combo.js',
        'mgr/widgets/settings/mailing.js',
        'mgr/widgets/settings/mailinggroup.js',
        'mgr/widgets/settings/settings.panel.js',
        'mgr/pages/settings.js'
    ];
}
