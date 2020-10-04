<?php
/** @var modX $modx */
/** @var array $scriptProperties */
/** @var msInformUser $msInformUser */
$msInformUser = $modx->getService('msInformUser');

$id = (int) $modx->getOption('id', $scriptProperties, '', true);
$tpl = $modx->getOption('tpl', $scriptProperties, 'msInformUserTpl', true);
$tplModal = $modx->getOption('tplModal', $scriptProperties, 'msInformUserModalTpl', true);
$iuCount = (int)$modx->getOption('iuCount', $scriptProperties, null);
$jsUrl = trim($modx->getOption('jsUrl', $scriptProperties, 'components/msinformuser/js/web/msinformuser.js'));
$cssUrl = trim($modx->getOption('cssUrl', $scriptProperties, 'components/msinformuser/css/web/msinformuser.css'));

if (empty($id)) {
    $id = $modx->resource->id;
}
if (empty($tpl)) {
    return $modx->lexicon('msinformuser_err_tpl');
}

$output = $msInformUser->parseChunkButton($tpl, $iuCount, $scriptProperties);
$chunks = [
    'tpl' => $tpl,
    'tplModal' => $tplModal,
];

//unset($_SESSION['msInformUser']);

$hash = spl_object_hash($modx);
if ($_SESSION['msInformUser']['tmp'] != $hash) {
    $_SESSION['msInformUser']['tmp'] = $hash;
    $_SESSION['msInformUser']['chunks'] = $chunks;
    $modx->regClientHTMLBlock('<script>msInformUserConfig =
        {"actionUrl":"' . $msInformUser->config['actionUrl'] . '",
        "tplModal":"' . $tplModal . '"};
    </script>');
    if (!empty($jsUrl)) {
        $modx->regClientScript(MODX_ASSETS_URL . $jsUrl);
    }
}
return $output;
