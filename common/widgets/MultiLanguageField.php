<?php
/**
 * Created by PhpStorm.
 * User: rex
 * Date: 09.01.19
 * Time: 16:53
 */

namespace common\widgets;


use omgdef\multilingual\MultilingualBehavior;
use yii\base\InvalidConfigException;
use yii\base\Model;
use yii\base\Widget;
use yii\helpers\Html;
use yii\widgets\InputWidget;

class MultiLanguageField extends InputWidget
{
    public $widgetOptions;

    public $defaultLanguage;

    /**
     * @throws InvalidConfigException
     */
    public function init()
    {
        parent::init();
        if (empty($this->widgetOptions) || !$this->widgetOptions instanceof \Closure) {
            throw new InvalidConfigException("The 'widgetOptions' property must be set as Closure.");
        }
        if (!$this->defaultLanguage) {
            $this->defaultLanguage = $this->findDefaultLanguage();
        }
    }

    /**
     * @return string
     */
    public function run()
    {
        $widgetCallback = $this->widgetOptions;
        $languages = \Yii::$app->params['availableLocales'];
        $fields = '';

        $this->field->label(false);
        foreach ($languages as $lang => $name) {
            $field = clone $this->field;
            if ($lang != $this->defaultLanguage) {
                $field->attribute = $field->attribute . "_" . $lang;
            }
            $field->label(Html::activeLabel($field->model, $this->attribute, $field->options) . " (" . $name . ")");
            $fields .= $widgetCallback($field);
        }
        return $fields;
    }

    /**
     * @return mixed|string
     */
    protected function findDefaultLanguage()
    {
        if (!$this->defaultLanguage) {
            foreach ($this->field->model->getBehaviors() as $behavior) {
                if ($behavior instanceof MultilingualBehavior) {
                    $this->defaultLanguage = $behavior->defaultLanguage;
                    break;
                }
            }
        }
        return $this->defaultLanguage;
    }
}