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
     * @param $handle
     *
     * @return ConfigModel
     */
    public function get($handle)
    {
        /** @var FieldInterface $field */
        $field = Craft::$app->fields->getFieldByHandle($handle);

        if (!$field) {
            throw new Exception('Invalid field handle: ' . $handle);
        }

        return new FieldConfigModel([
            'name' => $field->name,
            'handle' => $field->handle,
            'instructions' => $field->instructions,
            'type' => get_class($field),
            'settings' => $field->getSettings()
        ]);
    }
}
