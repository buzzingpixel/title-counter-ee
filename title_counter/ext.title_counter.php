<?php

/**
 * @author TJ Draper <tj@buzzingpixel.com>
 * @copyright 2018 BuzzingPixel, LLC
 * @license http://www.apache.org/licenses/LICENSE-2.0
 */

use EllisLab\ExpressionEngine\Service\Database\Query as QueryBuilder;

/**
 * Class Title_counter_ext
 */
class Title_counter_ext
{
    /** @var string $version */
    public $version = TITLE_COUNTER_VER;

    /**
     * Installs the extension
     */
    public function activate_extension()
    {
        /** @var QueryBuilder $queryBuilder */
        $queryBuilder = ee('db');

        $queryBuilder->insert('extensions', [
            'class' => __CLASS__,
            'method' => 'cp_js_end',
            'hook' => 'cp_js_end',
            'settings' => '',
            'priority' => 10,
            'version' => TITLE_COUNTER_VER,
            'enabled' => 'y',
        ]);

        $queryBuilder->insert('extensions', [
            'class' => __CLASS__,
            'method' => 'cp_css_end',
            'hook' => 'cp_css_end',
            'settings' => '',
            'priority' => 10,
            'version' => TITLE_COUNTER_VER,
            'enabled' => 'y',
        ]);
    }

    /**
     * Uninstalls the extension
     */
    public function disable_extension()
    {
        /** @var QueryBuilder $queryBuilder */
        $queryBuilder = ee('db');

        $queryBuilder->delete('extensions', [
            'class' => __CLASS__,
        ]);
    }

    /**
     * Updates the extension
     * @return bool
     */
    public function update_extension()
    {
        /** @var QueryBuilder $queryBuilder */
        $queryBuilder = ee('db');

        $queryBuilder->update(
            'extensions',
            [
                'version' => TITLE_COUNTER_VER,
            ],
            [
                'class' => __CLASS__,
            ]
        );

        return true;
    }

    /**
     * Adds the JavaScript to the control panel
     * @return string
     */
    public function cp_js_end()
    {
        // Get any hook data already on this extension
        $hookData = ee()->extensions->last_call ?: '';

        $filePath = realpath(__DIR__) . '/resources/script.js';

        if (! file_exists($filePath)) {
            return $hookData;
        }

        $fileContents = file_get_contents($filePath);

        $templatePath =  realpath(__DIR__) . '/resources/counterHtml.html';
        $templateContents = '';

        if (file_exists($templatePath)) {
            $templateContents = file_get_contents($templatePath);
        }

        $var = 'window.TITLE_COUNTER_TEMPLATE = ' .
            json_encode($templateContents) .
            ';';

        /** @var \EE_Config $eeConfig */
        $eeConfig = ee()->config;

        $limit = (int) $eeConfig->item('title_counter_limit');
        $limit = $limit ?: 200;

        $var2 = "window.TITLE_COUNTER_LIMIT = {$limit}";

        return "{$hookData}\n\n{$var}\n\n{$var2}\n\n{$fileContents}";
    }

    /**
     * Adds the CSS to the control panel
     * @return string
     */
    public function cp_css_end()
    {
        // Get any hook data already on this extension
        $hookData = ee()->extensions->last_call ?: '';

        $filePath = realpath(__DIR__) . '/resources/style.css';

        if (! file_exists($filePath)) {
            return $hookData;
        }

        $fileContents = file_get_contents($filePath);

        return "{$hookData}\n\n{$fileContents}";
    }
}
