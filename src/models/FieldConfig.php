<?php
/**
 * FFFields plugin for Craft CMS 3.x
 *
 * Fabulous front-end fields for Craft.
 *
 * @link      https://angell.io
 * @copyright Copyright (c) 2019 Angell & Co
 */

namespace angellco\fffields\models;

use angellco\fffields\FFFields;

use Craft;
use craft\base\FieldInterface;
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
                $this->vueFieldType = 'fff-plain-text';
                break;

            case 'craft\fields\Url':
                $this->gqlType = 'String';
                $this->vueFieldType = 'fff-url';
                break;

            case 'craft\fields\Email':
                $this->gqlType = 'String';
                $this->vueFieldType = 'fff-email';
                break;

            case 'craft\fields\Lightswitch':
                $this->gqlType = 'Boolean';
                $this->vueFieldType = 'fff-lightswitch';
                break;

            case 'craft\fields\Dropdown':
                $this->gqlType = $this->_getGraphQlEnum($this->handle);
                $this->vueFieldType = 'fff-dropdown';
                break;

            case 'craft\fields\MultiSelect':
                $this->gqlType = "[".$this->_getGraphQlEnum($this->handle)."]";
                $this->vueFieldType = 'fff-multi-select';
                break;

            case 'craft\fields\RadioButtons':
                $this->gqlType = $this->_getGraphQlEnum($this->handle);
                $this->vueFieldType = 'fff-radio-buttons';
                break;

            case 'craft\fields\Checkboxes':
                $this->gqlType = "[".$this->_getGraphQlEnum($this->handle)."]";
                $this->vueFieldType = 'fff-checkboxes';
                break;

            case 'craft\fields\Number':
                if ($this->settings['decimals'] > 0) {
                    $this->gqlType = 'Float';
                } else {
                    $this->gqlType = 'Int';
                }
                $this->vueFieldType = 'fff-number';
                break;

            case 'craft\fields\Matrix':
                $this->gqlType = '[MatrixInput]';
                $this->vueFieldType = 'fff-matrix';
                break;

            case 'craft\redactor\Field':
                $this->gqlType = 'String';
                $this->vueFieldType = 'fff-redactor';
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

                } elseif (is_a($value, 'craft\fields\data\SingleOptionFieldData')) {
                    $this->value = $value->value;
                } else {
                    $this->value = $value;
                }
                break;

            case 'craft\fields\RadioButtons':
                if (is_null($value)) {

                    // Loop options and pick the first one marked as default
                    foreach ($this->settings['options'] as $option) {
                        if ($option['default']) {
                            $this->value = $option['value'];
                            break;
                        }
                    }

                } elseif (is_a($value, 'craft\fields\data\SingleOptionFieldData')) {
                    $this->value = $value->value;
                } else {
                    $this->value = $value;
                }
                break;

            case 'craft\fields\Checkboxes':
            case 'craft\fields\MultiSelect':
                if (is_null($value)) {

                    $this->value = [];

                    foreach ($this->settings['options'] as $option) {
                        if ($option['default']) {
                            $this->value[] = $option['value'];
                        }
                    }

                } elseif (is_a($value, 'craft\fields\data\MultiOptionsFieldData')) {
                    $this->value = [];

                    foreach ($value as $option) {
                        if ($option->selected) {
                            $this->value[] = $option->value;
                        }
                    }

                } else {
                    $this->value = $value;
                }
                break;

            case 'craft\fields\Number':
                if (is_null($value)) {
                    $this->value = $this->settings['defaultValue'];
                } else {
                    if ($this->settings['decimals'] > 0) {
                        $this->value = floatval($value);
                    } else {
                        $this->value = (int) $value;
                    }
                }
                break;


            default:
                $this->value = $value;
        }

    }

    public function prepSettings(FieldInterface $field)
    {

        if ($this->type === 'craft\fields\Matrix') {
            $this->settings['blockTypes'] = Craft::$app->matrix->getBlockTypesByFieldId($field->id);
        }

    }

    /**
     * @return string
     */
    public function toJson()
    {
        return Json::encode($this->toArray());
    }

    // Private Methods
    // =========================================================================

    /**
     * Formats the enum type string
     *
     * TODO: this is currently borrowed from the CraftQL helpers, we should
     *       refactor to include the helper directly and only use the `gqlType`
     *       prop if CraftQL is installed.
     *
     * @param $string
     *
     * @return string
     */
    private function _getGraphQlEnum($string)
    {
        $string = preg_replace('/[^a-z0-9_]+/i', ' ', $string);
        $string = preg_replace_callback('/\s+(.)/', function ($match) {
            return ucfirst($match[1]);
        }, $string);
        return ucfirst($string).'Enum';
    }
}
