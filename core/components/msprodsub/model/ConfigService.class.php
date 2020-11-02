<?php

declare(strict_types=1);

class ConfigService
{
    public const NAMESPACE = 'msprodsub';

    public $config = [];

    protected $modx;

    public function __construct(modX $modx, array $config = [])
    {
        $this->modx &= $modx;
        $this->config = $config;

        foreach (['core_path', 'assets_path', 'assets_url'] as $option) {
            $options[$option] = $this->getOption($option);
        }

        $this->config = array_merge([
            'path.core' => $options['core_path'],
            'path.core.model' => $options['core_path'] . 'model/',
            'path.assets' => $options['assets_path'],
            'path.assets.js' => $options['assets_path'] . 'js/',
            'url.assets' => $options['assets_url'],
            'url.assets.css' => $options['assets_url'] . 'css/',
            'url.assets.js' => $options['assets_url'] . 'js/',
            'url.assets.connector' => $options['assets_url'] . 'connector.php'
        ], $this->config);

        $this->modx->addPackage(self::NAMESPACE, $this->config['path.core.model']);
        $this->modx->lexicon->load(self::NAMESPACE . ':default');
    }

    private function getOption(string $key)
    {
        $default = sprintf('%s/components/%s/', $this->modx->getOption($key), self::NAMESPACE);
        $genericKey = implode('.', [self::NAMESPACE, $key]);

        return $this->modx->getOption($genericKey, $this->config, $default);
    }
}
