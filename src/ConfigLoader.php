<?php

namespace Wcoppens\Phalcon\ConfigLoader;

use Phalcon\Config\Adapter\ExtendedYaml;
use Phalcon\Config\Exception;


/**
 * Class ConfigLoader
 *
 * Default loader for Phalcon project inspired by the Yaml file loading system used in Symfony2.
 */
class ConfigLoader extends ExtendedYaml {

    /**
     * @var array
     */
    public $parameters = [];

    /**
     * @param string $configDir
     * @param string $appRoot
     * @param string $env
     * @throws Exception
     */
    public function __construct($configDir, $appRoot, $env = 'prod') {

        $parametersYaml = new ExtendedYaml($configDir . '/parameters.yml');
        $this->parameters = $parametersYaml->parameters;

        //Store app_root temporary in parameters
        $this->parameters['app_root'] = $appRoot;

        parent::__construct($configDir . '/config.yml', $this->subscribedCallbacks());
        parent::merge(new ExtendedYaml($configDir . '/config_' . $env . '.yml', $this->subscribedCallbacks()));
    }

    /**
     * Method which returns the callbacks for the ExtendedYaml instance.
     *
     * @return array
     */
    private function subscribedCallbacks() {

        return [
            '!parameter' => function($key) {
                return $this->parameter($key);
            },
            '!approot' => function($value) {
                return $this->appRoot($value);
            }
        ];
    }

    /**
     * Method returning the parameter value for the given key
     *
     * @param $key
     * @return mixed
     */
    private function parameter($key) {
        return $this->parameters->{$key};
    }

    /**
     * Method returning full path for given value
     *
     * @param $value
     * @return string
     */
    private function appRoot($value) {

        return $this->parameters->app_root . $value;
    }
}
