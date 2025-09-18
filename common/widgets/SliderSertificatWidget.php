<?php
/**
 * Created by PhpStorm.
 * User: rexit
 * Date: 28.03.19
 * Time: 15:29
 */

namespace common\widgets;

use common\models\SliderSertificat;
use yii\helpers\Html;
use yii\jui\Widget;
use yii;

class SliderSertificatWidget extends Widget
{

    public function init()
    {
        parent::init();

    }

    public function run()
    {
        $slider = $content = null;
        $query = SliderSertificat::Find()
            ->where(['status' => 1])
            ->orderBy('order DESC')
            ->all();
        if ($query ) {

            foreach ($query as $item) {

                $image = Html ::img(
                    Yii ::$app -> glide -> createSignedUrl([
                        'glide/index',
                        'path' => $item -> image_path,
                        'w' => 340,
                        'h' => 460,
                        'fit' => 'fill',
                        'dpr' =>2,
                    ], true)
                    , ['alt' => $item -> title]);
                $wrap = Html ::tag('div', $image, ['class' => 'swiper-zoom-container']);
                $slider[] = Html ::tag('div', $wrap, ['class' => 'swiper-slide']);
            }

            $swaper = Html ::tag('div', implode('', $slider), ['class' => 'swiper-wrapper']);
            $pagination = Html ::tag('div', null, ['class' => 'swiper-pagination']);
            $content = Html ::tag('div', $swaper . $pagination, ['class' => 'swiper Sertificat']);
        }
        echo $content;
    }
}