<?php
/**
 * FFFields plugin for Craft CMS 3.x
 *
 * Fantastical front-end fields for Craft CMS.
 *
 * @link      https://angell.io
 * @copyright Copyright (c) 2019 Angell & Co
 */

namespace angellco\fffields\models;

use angellco\fffields\FFFields;

use Craft;
use craft\base\Model;

/**
 * @author    Angell & Co
 * @package   FFFields
 * @since     0.0.1
 */
class Config extends Model
{
    // Public Properties
    // =========================================================================

    /**
     * @var string
     */
    public $handle;

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['handle', 'string'],
        ];
    }
}
