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

        return "{$hookData}console.log('title_counter')";
    }
}
