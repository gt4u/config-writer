# Config files writer
## Installing
 `composer require jamalosm/config-writer 1.*`
## Usage
```php
// config/app.php
return [
    "name" => 'B-ONE Application',
    "versions" => [
        "v1" => "19.02.2017",
        "v2" => "23.04.2018",
    ]
];
```
```php
<?php
// index.php
require 'vendor/autoload.php';

$configPath = __DIR__."/config";

$instance = \BONE\Config\Config::getInstance($configPath);

$configWriter = new \BONE\ConfigWriter\ConfigWriter($configPath, $instance);
```
###Methods

#### write($key, $default = null)
Write configuration value in config file.
```php  
    $configWriter->write('app.path', 'app/local'); //'app/local'
    
    $instance->get('app.path'); //'app/local'
    
    $instance->get('app');
    /*
    [
        "name" => 'B-ONE Application',
        "versions" => [
            "v1" => "19.02.2017",
            "v2" => "23.04.2018",
        ],
        "path" => "app/local"
    ]
    */
```
File before writing.
```php
// config/app.php
return [
    "name" => 'B-ONE Application',
    "versions" => [
        "v1" => "19.02.2017",
        "v2" => "23.04.2018",
    ],
    "path" => "app/local"
];
```