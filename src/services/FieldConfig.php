<?php
/**
 * FFFields plugin for Craft CMS 3.x
 *
 * Fabulous front-end fields for Craft CMS.
 *
 * @link      https://angell.io
 * @copyright Copyright (c) 2019 Angell & Co
 */

namespace angellco\fffields\services;

use angellco\fffields\FFFields;
use angellco\fffields\models\FieldConfig as FieldConfigModel;

use Craft;
use craft\base\Component;
use craft\base\FieldInterface;

/**
 * @author    Angell & Co
 * @package   FFFields
 * @since     0.0.1
 */
class FieldConfig extends Component
{
    // Public Methods
    // =========================================================================

    /**
     * @param      $handle
     * @param null $value
     * @param bool $required
     *
     * @return FieldConfigModel
     */
    public function get($handle, $value = null, $required = false)
    {
        // Sort out the basic model
        if ($handle === 'title') {

            $model = new FieldConfigModel([
                'name' => 'Title',
                'handle' => 'title',
                'instructions' => '',
                'value' => null,
                'required' => true,
                'type' => 'title',
                'settings' => [
                    'charLimit' => 255
                ]
            ]);
        } else {

            /** @var FieldInterface $field */
            $field = Craft::$app->fields->getFieldByHandle($handle);

            if (!$field) {
                throw new Exception('Invalid field handle: '.$handle);
            }

            $model = new FieldConfigModel([
                'name' => $field->name,
                'handle' => $field->handle,
                'instructions' => $field->instructions,
                'required' => $required,
                'type' => get_class($field),
                'settings' => $field->getSettings()
            ]);
        }

        // Set the types needed by Vue and GraphQL
        $model->setTypes();

        // Set the value
        $model->setValue($value);

        // Validate
        if (!$model->validate()) {
            throw new Exception('Invalid field config model for handle: '.$handle);
        }

        return $model;
    }
}
