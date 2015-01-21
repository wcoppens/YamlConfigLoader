# YamlConfigLoader
A symfony2 inspired Yaml config loader for Phalcon framework


## What does it do?

This configuration loader is a extremely simple addon build on top of the ExtendedYaml class provided by PhalconIncubator.
It loads always 3 Yaml configuration files having always the following naming convention:

- parameters.yml (your dynamic configuration variables)
- config.yml (the main configuration for the application)
- config_{environment}.yml (the configuration which overwrites or add certain configs for the specific environment)

## Setup

Use composer to install this bundle

```
composer require wcoppens/phalcon-config-loader-yaml
```

First create a config directory somewhere (i usually use app/config).
Second create the a config.yml, parameters.yml and (possibly multiple) config_{environment}.yml files.

You can use the following examples as your config files:

```yml
#config.yml

database:
    adapter: Postgresql
    host: !parameter database_host
    username: !parameter database_username
    password: !parameter database_password
    dbname: !parameter database_name
    port: !parameter database_port
    schema: !parameter database_schema

application:
    controllersDir: !approot app/controllers/

```

```yml
#parameters.yml

parameters:
    database_host: somehost.net
    database_username: demo
    database_password: your-db-password
    database_name: demo
    database_port: 5432
    database_schema: public
```

```yml
#config_prod.yml

environment: production

```

Now you can load your config files by creating a new ConfigLoader instance for example in your loader file.

```php

$config = new Wcoppens\Phalcon\ConfigLoader('Your config dir path', 'Your app-root path', 'environment');

/*
 * Now you can access all config variables just as with the original config system provided by Phalcon.
 *
 * Here some examples on how to access the variables.
 */
 
 echo $config->application->controllersDir;
 echo $config->parameters->database_name

```
