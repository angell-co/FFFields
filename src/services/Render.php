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
     * @param bool $includeCss
     *
     * @return \Twig_Markup
     * @throws \yii\base\InvalidConfigException
     */
    public function includeAssets($includeCss = true)
    {
        Craft::$app->view->registerAssetBundle("angellco\\fffields\\assetbundles\\FffieldsJsAsset");
        if ($includeCss) {
            Craft::$app->view->registerAssetBundle("angellco\\fffields\\assetbundles\\FffieldsCssAsset");
        }
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
    public function renderField($handle, $value = null, $required = false)
    {
        /** @var FieldConfigModel $configModel */
        $configModel = FFFields::$plugin->fieldConfig->get($handle, $value, $required);
        $html = "<fff-field :config='".$configModel->toJson()."'></fff-field>";
        return TemplateHelper::raw($html);
    }

    /**
     * @param      $handle
     * @param null $value
     * @param bool $required
     *
     * @return \Twig_Markup
     */
    public function renderSpecial($handle, $value = null, $required = false)
    {
        /** @var FieldConfigModel $configModel */
        $configModel = FFFields::$plugin->fieldConfig->getSpecial($handle, $value, $required);
        $html = "<fff-field :config='".$configModel->toJson()."'></fff-field>";
        return TemplateHelper::raw($html);
    }

    /**
     * @param      $mutation
     * @param bool $enabled
     * @param null $redirect
     *
     * @return \Twig_Markup
     */
    public function formStart($mutation, $enabled = true, $redirect = null)
    {
        $html = "<fff-form :mutation=\"'${mutation}'\" :enabled=\"".($enabled ? 'true' : 'false')."\" :redirect=\"'${redirect}'\">";
        return TemplateHelper::raw($html);
    }

    /**
     * @return \Twig_Markup
     */
    public function formEnd()
    {
        $html = "</fff-form>";
        return TemplateHelper::raw($html);
    }

    /**
     * @param      $handle
     * @param null $value
     * @param bool $required
     *
     * @return string
     */
    public function config($handle, $value = null, $required = false)
    {
        /** @var FieldConfigModel $configModel */
        $configModel = FFFields::$plugin->fieldConfig->get($handle);
        return $configModel->toJson();
    }
}
