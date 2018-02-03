<?php

/**
 * @author TJ Draper <tj@buzzingpixel.com>
 * @copyright 2018 BuzzingPixel, LLC
 * @license http://www.apache.org/licenses/LICENSE-2.0
 */

// Get addon json path
$addOnPath = realpath(__DIR__);

// Get vendor autoload
$vendorAutoloadFile = "{$addOnPath}/vendor/autoload.php";

// Require the autoload file if path exists
if (file_exists($vendorAutoloadFile)) {
    require $vendorAutoloadFile;
}

defined('TITLE_COUNTER_VER') || define('TITLE_COUNTER_VER', '1.0.1');

return [
    'author' => 'TJ Draper',
    'author_url' => 'https://buzzingpixel.com',
    'description' => 'Show the limit and character count on the title field in ExpressionEngine',
    'name' => 'Title Counter',
    'namespace' => 'buzzingpixel\titlecounter',
    'settings_exist' => false,
    'version' => TITLE_COUNTER_VER,
];
