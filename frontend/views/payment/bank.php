<?php

/**
 * Created by Rex IT
 * @author Konstantin Kharalampidi <kharalampidi@rexit.info>
 */

/* @var $this \yii\web\View */
/* @var $order null|\common\models\OrderProject */
?>
<section class="payment-bank">
    <h3><?= Yii::t('frontend', 'Thank you, {full_name}!', [
            'full_name' => $order->full_name
        ]) ?></h3>

    <h2><?= Yii::t('frontend', 'Our requisites:');?></h2>

    <div class="payment-bank__desc">
<!--        <div class="payment-bank__desc-left">-->
<!--            <p>Bank of America</p>-->
<!--            <p>Account# 4660 0471 4321</p>-->
<!--            <p>ACH Routing# 011000138</p>-->
<!--        </div>-->
<!--        <div class="payment-bank__desc-right">-->
<!--            <p>р/с 26006463615701</p>-->
<!--            <p>Код ЄДРПОУ 38696486</p>-->
<!--            <p>МФО 351005 UAH</p>-->
<!--        </div>-->
        <h5>Гривна</h5>
        <div class="payment-bank__desc-row">
            <p>Наименование организации. Код получателя:</p>
            <p>ГО ХРИСТИАНСЬКА МIСIЯ НОВЕ ЖИТТЯ ГО 38696486</p>
        </div>
        <div class="payment-bank__desc-row">
            <p>Название Банка. Счет получателя:</p>
            <p>ЮЖНЕ ГРУ АТ КБ “ПРИВАТБАНК” 26006054210570</p>
        </div>
        <div class="payment-bank__desc-row">
            <p>Валюта. Код Банка (МФО):</p>
            <p>UAH 328704</p>
        </div>
        <br>
        <br>
        <br>
        <h5>Доллар</h5>
        <div class="payment-bank__desc-row">
            <p>The bank account of the company:</p>
            <p>26005054209902</p>
        </div>
        <div class="payment-bank__desc-row">
            <p>Name of the bank:</p>
            <p>JSC CB “PRIVATBANK”, 1D HRUSHEVSKOHO STR., KYIV, 01001, UKRAINE</p>
        </div>
        <div class="payment-bank__desc-row">
            <p>Company address:</p>
            <p>UA 67806 Odessa Ovidiopolsky Avangard street Zelena b.3</p>
        </div>
        <div class="payment-bank__desc-row">
            <p>Bank SWIFT Code:</p>
            <p>PBANUA2X</p>
        </div>
        <div class="payment-bank__desc-row">
            <p>IBAN Code:</p>
            <p>UA783287040000026005054209902</p>
        </div>
        <br>
        <br>
        <br>
        <h5>Евро</h5>
        <div class="payment-bank__desc-row">
            <p>The bank account of the company:</p>
            <p>26003054210625</p>
        </div>
        <div class="payment-bank__desc-row">
            <p>Name of the bank:</p>
            <p>JSC CB “PRIVATBANK”, 1D HRUSHEVSKOHO STR., KYIV, 01001, UKRAINE</p>
        </div>
        <div class="payment-bank__desc-row">
            <p>Company address:</p>
            <p>UA 67806 Odessa Ovidiopolsky Avangard street Zelena b.3</p>
        </div>
        <div class="payment-bank__desc-row">
            <p>Bank SWIFT Code:</p>
            <p>PBANUA2X</p>
        </div>
        <div class="payment-bank__desc-row">
            <p>IBAN Code:</p>
            <p>UA473287040000026003054210625</p>
        </div>
    </div>
</section>