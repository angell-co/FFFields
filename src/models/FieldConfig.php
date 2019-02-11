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
     * @var mixed
     */
    public $value;

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

            case 'craft\fields\Url':
                $this->gqlType = 'String';
                $this->vueFieldType = 'url';
                break;

            case 'craft\fields\Email':
                $this->gqlType = 'String';
                $this->vueFieldType = 'email';
                break;

            case 'craft\fields\Lightswitch':
                $this->gqlType = 'Boolean';
                $this->vueFieldType = 'lightswitch';
                break;

            case 'craft\fields\Dropdown':
                $this->gqlType = 'DropdownEnum';
                $this->vueFieldType = 'dropdown';
                break;

            case 'craft\fields\MultiSelect':
                $this->gqlType = '[MultiSelectEnum]';
                $this->vueFieldType = 'multiselect';
                break;

            case 'craft\fields\RadioButtons':
                $this->gqlType = 'RadioButtonsEnum';
                $this->vueFieldType = 'radiobuttons';
                break;

            case 'craft\fields\Checkboxes':
                $this->gqlType = '[CheckboxesEnum]';
                $this->vueFieldType = 'checkboxes';
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
     * Sets the value of the field with defaults if possible
     *
     * @param null $value
     */
    public function setValue($value = null)
    {

        switch ($this->type) {

            case 'craft\fields\Lightswitch':
                if (is_null($value)) {
                    $this->value = (bool) $this->settings['default'];
                } else {
                    $this->value = $value;
                }
                break;

            case 'craft\fields\Dropdown':
                if (is_null($value)) {

                    // Loop options and pick the first one marked as default
                    foreach ($this->settings['options'] as $option) {
                        if ($option['default']) {
                            $this->value = $option['value'];
                            break;
                        }
                    }

                    // If we got this far and its still null then there is no
                    // default so pick the first one
                    if (is_null($this->value)) {
                        $this->value = $this->settings['options'][0]['value'];
                    }

                } else {
                    $this->value = $value;
                }
                break;

            case 'craft\fields\Checkboxes':
                if (is_null($value)) {

                    $this->value = [];

                    foreach ($this->settings['options'] as $option) {
                        if ($option['default']) {
                            $this->value[] = $option['value'];
                        }
                    }

                } else {
                    $this->value = $value;
                }
                break;

            default:
                $this->value = $value;
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
