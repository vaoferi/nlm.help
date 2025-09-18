<?php
/**
 * Created by Rex IT
 * @author Konstantin Kharalampidi <kharalampidi@rexit.info>
 */

use common\models\Slider;
use yii\helpers\Html;

/** @var Slider[] $sliders */
?>

    <div class="hero__slider-wrap">
        <div class="hero__slider">
            <?php foreach ($sliders as $slider): ?>
                <div class="hero__slider-img" style="background-image: radial-gradient(700px 700px at 700px, rgba(36,36,36,0.58) 0%, rgba(36,36,36,0.04) 55%, rgba(51,51,51,0) 59%, rgba(87,87,87,0) 69%, rgba(204,204,204,0) 75%, rgba(36,36,36,0) 76%, rgba(87,87,87,0) 80%, rgba(143,143,143,0) 81%, rgba(179,179,179,0) 88%, rgba(0,0,0,0) 95%, rgba(138,138,138,0) 100%), url('<?php echo Yii::$app->glide->createSignedUrl(['glide/index', 'path' => $slider->image_path], true); ?>')">
                    <?php if (isset($slider['translation']) && ($slider['translation']->title || $slider['translation']->text)): ?>
                        <div class="hero-title">
                            <h2><?php echo Html::encode($slider['translation']->title) ?></h2>
                            <p><?php echo Html::encode($slider['translation']->text) ?></p>
                        </div>
                    <?php endif; ?>
                    <?php if ($slider->button_url && $slider['translation']->button_text): ?>
                        <a class="hero-title__btn hero-link--js" href="<?= \yii\helpers\Url::to(['site/donate']) ?>"><?php echo Html::encode($slider['translation']->button_text) ?></a>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="hero-quote__wrap hero-quote__wrap--desktop">
            <div class="hero-quote">
                <h3>Изменения начинаются с ответственности!</h3>
                <p>Мы не согласны оставаться в стороне, наша ответственность не заканчивается порогом нашего дома. Наш дом это каждая улица по которой мы ходим наш дом это каждый человек которого мы встречаем наш дом это наш город и наша страна. И мы хотим чтобы наш дом был чистым чтобы в нашем доме не было голодающих, больных, брошенных и несчастных. Никакие перемены в нашей стране не смогут повлиять на нашу человечность и отзывчивость, это можем сделать только мы.
                    <br>
                    Возьмите на себя ответственность за свой дом.
                </p>
            </div>
        </div>
    </div>

