<?php

abstract class AbstractManagerController extends modExtraManagerController
{
    protected const STYLES = [];

    protected const SCRIPTS = [];

    public $service;

    public function initialize(): void
    {
        $path = sprintf(MODX_CORE_PATH . 'components/%s/model/', ConfigService::NAMESPACE);

        $this->service = $this->modx->getService('ConfigService', 'ConfigService', $path);
    }

    public function getLanguageTopics(): array
    {
        return [ConfigService::NAMESPACE . ':default'];
    }

    public function getPageTitle(): string
    {
        return $this->modx->lexicon(sprintf('%s_%s_title', ConfigService::NAMESPACE, $this->getClassShortName()));
    }

    public function getTemplateFile(): string
    {
        $this->content .= sprintf(
            '<div id="%s-panel-%s"></div>',
            ConfigService::NAMESPACE,
            $this->getClassShortName()
        );

        return parent::getTemplateFile();
    }

    /**
     * @throws JsonException
     */
    public function loadCustomCssJs(): void
    {
        foreach (static::STYLES as $style) {
            $this->addCss($this->service->config['url.assets.css'] . $style);
        }

        foreach (static::SCRIPTS as $script) {
            $this->addJavascript($this->service->config['url.assets.js'] . $script);
        }

        $this->addHtml($this->getExtLoader([
            'config' => $this->service->config,
            'config.connector_url' => $this->service->config['connectorUrl']
        ]));
    }

    protected function getClassShortName(): string
    {
        return strtolower(str_replace([ConfigService::NAMESPACE, 'ManagerController'], '', strtolower(static::class)));
    }

    private function getExtLoader(array $params = []): string
    {
        foreach ($params as $key => &$value) {
            $value = sprintf(
                '    %s.%s = %s;',
                ConfigService::NAMESPACE,
                $key,
                is_array($value)
                    ? json_encode($value, JSON_THROW_ON_ERROR)
                    : sprintf('"%s"', $value)
            );
        }

        $xType = sprintf('%s-page-%s', ConfigService::NAMESPACE, $this->getClassShortName());

        $extInit = sprintf('\nExt.onReady(function() { MODx.load({ xtype: "%s" }); });', $xType);

        $js = implode(PHP_EOL, $params) . $extInit;

        return sprintf('<script type="text/javascript">%s</script>', $js);
    }
}
