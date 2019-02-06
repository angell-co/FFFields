<?php
/**
 * FFFields plugin for Craft CMS 3.x
 *
 * Fabulous front-end fields for Craft CMS.
 *
 * @link      https://angell.io
 * @copyright Copyright (c) 2019 Angell & Co
 */

namespace angellco\fffields\models;

use angellco\fffields\FFFields;

use Craft;
use craft\base\Model;
use craft\helpers\Json;

/**
 * @author    Angell & Co
 * @package   FFFields
 * @since     0.0.1
 */
class FieldConfig extends Model
{
    // Public Properties
    // =========================================================================

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $handle;

    /**
     * @var string
     */
    public $instructions;

    /**
     * @var string
     */
    public $type;

    /**
     * @var array
     */
    public $settings;

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['name', 'string'],
            ['handle', 'string'],
            ['instructions', 'string'],
            ['type', 'string'],
            ['settings', 'array'],
        ];
    }

    /**
     * @return string
     */
    public function toJson()
    {
        $arr = $this->toArray();
        return Json::encode($arr);
    }
}
