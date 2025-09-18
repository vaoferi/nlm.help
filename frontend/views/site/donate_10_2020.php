<?php

use common\widgets\DbText;
use yii\web\View;

//use \yii\helpers\Url;

/* @var $this \yii\web\View */

//$this->registerJsFile("@web/js/libs.min.js");
//$this->registerCssFile("@web/css/style.min.css",
//    ['rel' => 'stylesheet',
//        'noscript' => true,
//        'condition' => 'lt IE 9']);
$this->registerJs(
    <<<JS
  $(document).on("click", ".js-tabs-payment div", function (event) {
    event.preventDefault();
    let nametab = $(this).data("link");
    $(".js-content-payment").find(".js-active").removeClass("js-active");
    $("." + nametab).addClass("js-active");
    $(this).siblings(".js-active").removeClass("js-active");
  });
JS
    , View::POS_READY);

?>
<div class="donate">
    <div class="payment">
        <div class="payment__wrapper">
            <div class="payment__tabs js-tabs-payment">
                <div class="payment__tab tab-payment tab1 js-active" data-link="tab1">
                    <span>$</span>
                    <div class="tab-payment__title"><?= Yii::t('frontend', 'dollar') ?></div>
                </div>
                <div class="payment__tab tab-payment tab2" data-link="tab2">
                    <span>€</span>
                    <div class="tab-payment__title"><?= Yii::t('frontend', 'euro') ?></div>
                </div>
                <div class="payment__tab tab-payment tab3" data-link="tab3">
                    <span>₴</span>
                    <div class="tab-payment__title"><?= Yii::t('frontend', 'hryvnia') ?></div>
                </div>
<?php /*
                <div class="payment__tab tab-payment tab4" data-link="tab4">
                    <div class="tab-payment__icon"><svg xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:cc="http://creativecommons.org/ns#" xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#" xmlns:svg="http://www.w3.org/2000/svg" xmlns="http://www.w3.org/2000/svg" version="1.1" width="5.4027801in" height="5.9583in" viewBox="0 0 7357 9500" id="svg2" xml:space="preserve" style="fill-rule: evenodd">
<g id="__x0023_Layer_x0020_1">
    <path d="m 5477,2477 c -81,-209 -199,-333 -324,-450 -125,-117 -347,-230 -531,-269 -133,-34 -328,-49 -578,-49 l -1944,0 0,2320 -318,0 0,520 318,0 0,211 -318,0 0,520 318,0 0,1437 557,0 0,-1437 1996,0 0,-520 -1996,0 0,-211 35,0 1396,0 c 537,0 922,-150 1162,-442 229,-279 369,-523 369,-951 0,-248 -69,-476 -143,-680 z m -732,1314 0,0 c -140,160 -325,238 -649,238 l -1403,0 0,0 -35,0 0,-1787 1427,0 c 228,0 386,15 467,44 134,85 239,151 317,296 81,151 121,330 121,534 0,291 -113,520 -246,675 z" id="path26" style="fill-rule: nonzero"/>
</g>
</svg>
                    </div>
                    <div class="tab-payment__title"><?= Yii::t('frontend', 'Rouble') ?></div>
                </div>  
*/ ?>
            </div>
            <div class="payment__content content-payment js-content-payment">
                <div class="payment__content-tab js-tab-content tab1 js-active">
                    <?= DbText::widget(['key' => 'donate_account_dol_'. Yii::$app->language ]); ?>
                    <div class="paypal-section">

                        <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
                            <input type="hidden" name="cmd" value="_donations" />
                            <input type="hidden" name="business" value="7Q4KPTAXLUREY" />
                            <input type="hidden" name="item_name" value="Donate for New life - International mission" />
                            <input type="hidden" name="currency_code" value="USD" />
                            <input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" title="PayPal - The safer, easier way to pay online!" alt="Donate with PayPal button" onClick="ga('send', 'event', 'knopka', 'donate');" />
                            <img alt="" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1" />
                        </form>
                    </div>
                </div>
                <div class="payment__content-tab js-tab-content tab2">
                    <?= DbText::widget(['key' => 'donate_account_evr_'. Yii::$app->language ]); ?>
                </div>
                <div class="payment__content-tab js-tab-content tab3">
                    <?= DbText::widget(['key' => 'donate_account_hrn_'. Yii::$app->language ]); ?>
                </div>
                <div class="payment__content-tab js-tab-content tab4">
                    <?= DbText::widget(['key' => 'donate_account_rub_'. Yii::$app->language ]); ?>
                </div>
            </div>
        </div>
    </div>
</div>