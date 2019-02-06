<?php
/**
 * FFFields plugin for Craft CMS 3.x
 *
 * Fantastical front-end fields for Craft CMS.
 *
 * @link      https://angell.io
 * @copyright Copyright (c) 2019 Angell & Co
 */

namespace angellco\fffields\services;

use angellco\fffields\FFFields;
use angellco\fffields\models\Config as ConfigModel;

use Craft;
use craft\base\Component;

/**
 * @author    Angell & Co
 * @package   FFFields
 * @since     0.0.1
 */
class Config extends Component
{
    // Public Methods
    // =========================================================================

    /**
     * @return ConfigModel
     */
    public function get()
    {
        $model = new ConfigModel([
            'handle' => 'someHandle'
        ]);

        return $model;
    }
}
