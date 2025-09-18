<?php

/**
 * Created by Rex IT
 * @author Konstantin Kharalampidi <kharalampidi@rexit.info>
 */
use common\widgets\DbText;
use rexit\liqpay\LiqPayWidget;
//use Yii;

//use \yii\helpers\Url;

/* @var $this \yii\web\View */
/* @var $project array|\common\models\Project|null */
/* @var $model \common\models\OrderProject */

?>
<section class="donation-page">
    <div class="container">
        <div class="donation-page__wrap">
            <div class="donation-page__left">
                <?= DbText::widget(['key' => 'banks_account' ]);  //. Yii::$app->language?>
            </div>
            <div class="donation-page__right">
                <h2><?= Yii::t('frontend', 'Thank You for willing to help') ?></h2>

                <?php // if (\Yii::$app->language == 'en') :?>
                <div class="paypal-section">

                    <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top"  onClick="ga('send', 'event', 'knopka', 'donate');">
                        <input type="hidden" name="cmd" value="_donations" />
                        <input type="hidden" name="business" value="7Q4KPTAXLUREY" />
                        <input type="hidden" name="item_name" value="Donate for New life - International mission" />
                        <input type="hidden" name="currency_code" value="USD" />
                        <input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" title="PayPal - The safer, easier way to pay online!" alt="Donate with PayPal button" />
                        <img alt="" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1" />
                    </form>


                </div>
                <?php /* else :?>
                <div class="liqpay-section">
                    <?php  echo LiqPayWidget::widget([
                        'model' => $liqpay
                    ]);
                       ?>
                </div>
                <?php endif; */?>

            </div>
        </div>
    </div>
</section>

