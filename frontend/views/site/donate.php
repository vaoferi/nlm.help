<?php

/**
 * Created by Rex IT
 * @author Konstantin Kharalampidi <kharalampidi@rexit.info>
 */

/* @var $this \yii\web\View */
/* @var $model \common\models\OrderService */
?>
<section class="donation-page">
    <div class="container">
        <div class="donation-page__wrap">
            <div class="donation-page__left"></div>
            <div class="donation-page__right">
                <h2><?= Yii::t('frontend', 'Thank You for willing to help') ?></h2>
                <?php $form = \yii\widgets\ActiveForm::begin(['options' => ['class' => 'donation-page__form']]); ?>
                <div class="donation-page__fio">
                    <div class="donation-page__amount">
                        <div class="input-wrap">
                            <?= \yii\helpers\Html::activeInput('number', $model, 'amount', [
                                'placeholder' => Yii::t('frontend', 'Donation amount')
                            ]) ?>
                        </div>
                    </div>
                    <div class="donation-page__email">
                        <div class="input-wrap">
                            <?= \yii\helpers\Html::activeTextInput($model, 'full_name', [
                                'placeholder' => Yii::t('frontend', 'Your full name'),
                                'required' => 'required'
                            ]) ?>
                        </div>
                    </div>
                    <div class="donation-page__full_name">
                        <div class="input-wrap">
                            <?= \yii\helpers\Html::activeInput('email', $model, 'email', [
                                'placeholder' => Yii::t('frontend', 'Email'),
                                'required' => 'required'
                            ]) ?>
                        </div>
                    </div>
                </div>
                <?= \yii\helpers\Html::activeRadioList($model, 'payment_system', \common\models\OrderProject::paymentSystems(), [
                    'item' => function ($index, $label, $name, $checked, $value) {
                        $return = '<div class="input-radio-wrap">';
                        $return .= '<input value="' . $value . '" id="' . $value . '" type="radio" name="' . $name . '" ' . ($checked ? 'checked' : '') . '>';
                        $return .= '<label for="' . $value . '">' . ucwords($label) . '</label>';
                        $return .= '</div>';
                        return $return;
                    },
                    'class' => 'donation-page__method'
                ]) ?>
                <div class="donation-page__comments">
                    <?= \yii\helpers\Html::activeTextarea($model, 'comment', ['placeholder' => Yii::t('frontend', 'Your comment:')]) ?>
                </div>
                <button class="donation-page__btn"><?= Yii::t('frontend', 'donate') ?></button>
                <?php \yii\widgets\ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</section>


