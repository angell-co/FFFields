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
use craft\helpers\Json;
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
     * @return \Twig_Markup
     */
    public function includeJs()
    {
        $data = [
            'gqlEndpoint' => Craft::parseEnv('$FFF_GQL_ENDPOINT'),
            'token' => Craft::parseEnv('$FFF_GQL_TOKEN')
        ];
        $js = "<script>window.fffields = ".Json::encode($data)."</script>";
        return TemplateHelper::raw($js);
    }

    /**
     * @param      $handle
     * @param null $value
     * @param bool $required
     *
     * @return \Twig_Markup
     */
    public function render($handle, $value = null, $required = false)
    {
        /** @var FieldConfigModel $configModel */
        $configModel = FFFields::$plugin->fieldConfig->get($handle, $value, $required);
        $html = "<fff-field :config='".$configModel->toJson()."'></fff-field>";
        return TemplateHelper::raw($html);
    }

    /**
     * @param $handle
     *
     * @return string
     */
    public function config($handle)
    {
        /** @var FieldConfigModel $configModel */
        $configModel = FFFields::$plugin->fieldConfig->get($handle);
        return $configModel->toJson();
    }
}
