<?php

namespace App\Internal;

use App\Exceptions\Config\UndefinedAttributeException;
use App\Exceptions\Config\UndefinedFilenameException;

class Config
{
    protected readonly string $configsDirectory;
    protected readonly string $configFiles;

    /**
     * @param array $config 
     * 
     * @return void 
     */
    public function __construct(protected array $config = []) 
    {
        $this->configsDirectory = path()->to('/config');
        $this->configFiles = path()->to('/config/*.php');

        foreach (glob($this->configFiles) as $_config) {
            $this->config[$this->getConfigName($_config)] = require $_config;
        }
    }
    
    /**
     * Usage:
     * 
     * ```php
     * $config = new Config();
     * $db_dsn = $config->get('db.dsn');
     * ```
     * 
     * @param string $key 
     * 
     * @return mixed 
     * 
     * @throws UndefinedAttribute
     */
    public function get(string $key): mixed
    {
        $direction = $this->config;
        $haystack = explode('.', $key);

        if (count($haystack) === 1) return $this->config[mb_strtolower($key)];

        foreach (glob($this->configFiles) as $config) {
            if (! isset($this->config[$cn = $this->getConfigName($config)])) {
                throw new UndefinedFilenameException(message: "
                    The configuration file is undefined by the name: [$cn].
                ");
            }
        }

        foreach ($haystack as $index => $value) {
            if (! isset($direction[$value])) {
                throw new UndefinedAttributeException(message: "
                    Cannot receive a value of undefined config attribute: 
                    [$direction[$value]] from the [{$haystack[0]}] configuration.
                ", code: 500);
            }
            
            $direction = $direction[$value];
        }

        return $direction;
    }

    /**
     * @param string $config 
     * 
     * @return string 
     */
    protected function getConfigName(string $config): string
    {
        return basename(pathinfo($config, PATHINFO_FILENAME));
    }
}
