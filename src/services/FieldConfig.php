<?php
/**
 * FFFields plugin for Craft CMS 3.x
 *
 * Fabulous front-end fields for Craft.
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
use yii\base\Exception;

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
     * Returns the FieldConfigModel for a given field handle.
     *
     * @param      $handle
     * @param null $value
     * @param bool $required
     *
     * @return FieldConfigModel
     */
    public function get($handle, $value = null, $required = false)
    {
        // Sort out the basic model
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

    /**
     * Returns a FieldConfigModel for a given element attribute name.
     *
     * @param      $handle
     * @param null $value
     * @param bool $required
     *
     * @return FieldConfigModel
     */
    public function getSpecial($handle, $value = null, $required = false)
    {
        switch ($handle) {
            case 'title':
                $model = new FieldConfigModel([
                    'name' => 'Title',
                    'handle' => 'title',
                    'instructions' => '',
                    'required' => $required,
                    'type' => 'title',
                    'settings' => [
                        'charLimit' => 255
                    ]
                ]);
                break;
        }

        if (!$model) {
            throw new Exception('Invalid option: '.$handle);
        }

        // Set the types needed by Vue and GraphQL
        $model->setTypes();

        // Set the value
        $model->setValue($value);

        return $model;
    }

}
