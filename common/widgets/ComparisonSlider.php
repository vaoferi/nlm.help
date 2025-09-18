<?php
/**
 * Created by PhpStorm.
 * User: rexit
 * Date: 28.03.19
 * Time: 15:29
 */

namespace common\widgets;

use yii\helpers\Html;
use yii\jui\Widget;

class ComparisonSlider extends Widget
{
    // before image src
    public $beforeImage;
    // text instead of the before picture
    public $beforeAlt = 'Before';
    // after image src
    public $afterImage;
    // text instead of the after picture
    public $afterAlt = 'After';
    // if true - horizontal comparison, false - vertical
    public $direction = false;

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        $content = null;

        if ($this->beforeImage && $this->afterImage) {
            $directionClass = $this->direction ? 'comparison horizontal' : 'comparison vertical';
            $imageBefore = Html::img($this->beforeImage, ['alt' => $this->beforeAlt]);
            $imageAfter = Html::img($this->afterImage, ['alt' => $this->afterAlt]);
            $liBefore = Html::tag('li', $imageBefore, ['class' => 'comparison__before']);
            $liAfter = Html::tag('li', $imageAfter, ['class' => 'comparison__after']);
            $items = $liBefore . $liAfter;
            $ul = Html::tag('ul', $items, ['class' => $directionClass]);
            $slider = Html::tag('div', null, ['id' => 'comparison__slider']);
            $content = Html::tag('div', $ul . $slider, ['class' => 'comparison__wrap']);
        }

        echo $content;
    }
}