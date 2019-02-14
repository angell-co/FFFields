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
     * @throws \yii\base\InvalidConfigException
     */
    public function includeAssets($includeCss = true)
    {
        Craft::$app->view->registerAssetBundle("angellco\\fffields\\assetbundles\\FffieldsJsAsset");
        if ($includeCss) {
            Craft::$app->view->registerAssetBundle("angellco\\fffields\\assetbundles\\FffieldsCssAsset");
        }

        return $this->outputState();
    }

    /**
     * @return \Twig_Markup|void
     */
    public function outputState()
    {
        $gqlEndpoint = Craft::parseEnv('$FFF_GQL_ENDPOINT');
        $token = Craft::parseEnv('$FFF_GQL_TOKEN');

        if ($gqlEndpoint !== '$FFF_GQL_ENDPOINT' && $token !== '$FFF_GQL_TOKEN') {
            $data = [
                'gqlEndpoint' => $gqlEndpoint,
                'token' => $token
            ];
            $js = "<script>window.fffields = ".Json::encode($data)."</script>";

            return TemplateHelper::raw($js);
        }

        return;
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
     * @param null $elementId
     *
     * @return \Twig_Markup
     */
    public function formStart($mutation, $enabled = true, $redirect = null, $elementId = null)
    {
        $html = "<fff-form :mutation=\"'${mutation}'\" :enabled=\"".($enabled ? 'true' : 'false')."\" :redirect=\"'${redirect}'\" :id=\"".($elementId ? $elementId : 'null')."\">";
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
