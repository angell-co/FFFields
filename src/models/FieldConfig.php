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
use craft\validators\ArrayValidator;

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
     * @var bool
     */
    public $required;

    /**
     * @var string
     */
    public $type;

    /**
     * @var string
     */
    public $gqlType;


    /**
     * @var string
     */
    public $vueFieldType;

    /**
     * @var array
     */
    public $settings;

    // Public Methods
    // =========================================================================

    /**
     * @return array
     */
    public function rules()
    {
        $rules = parent::rules();
        $rules[] = [['name', 'handle', 'type'], 'required'];
        $rules[] = [['name', 'handle', 'instructions', 'type', 'gqlType', 'vueFieldType'], 'string'];
        $rules[] = [['required'], 'boolean'];
        $rules[] = [['settings'], ArrayValidator::class];
        return $rules;
    }

    /**
     * Sets all of the types on the model needed for Vue and the GraphQL document
     */
    public function setTypes()
    {
        switch ($this->type) {
            case 'title':
            case 'craft\fields\PlainText':
                $this->gqlType = 'String';
                $this->vueFieldType = 'plainText';
                break;

            case 'craft\redactor\Field':
                $this->gqlType = 'String';
                $this->vueFieldType = 'redactor';
                break;
        }

        if ($this->required) {
            $this->gqlType .= "!";
        }
    }

    /**
     * @return string
     */
    public function toJson()
    {
        return Json::encode($this->toArray());
    }
}
