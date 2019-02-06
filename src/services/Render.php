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
use craft\helpers\Template as TemplateHelper;

/**
 * @author    Angell & Co
 * @package   FFFields
 * @since     0.0.1
 */
class Render extends Component
{
    // Public Methods
    // =========================================================================

    /**
     * @param $handle
     *
     * @return mixed
     */
    public function render($handle)
    {
        /** @var FieldConfigModel $configModel */
        $configModel = FFFields::$plugin->fieldConfig->get($handle);
        $html = "<fff-field :config='".$configModel->toJson()."'></fff-field>";
        return TemplateHelper::raw($html);
    }
}
