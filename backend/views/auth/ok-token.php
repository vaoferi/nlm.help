<?php
/**
 * Created by PhpStorm.
 * User: rexit
 * Date: 10.05.19
 * Time: 12:15
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<p><?php echo Yii::t('backend', 'Please paste access_token value from URL (between "#access_token=" and "&session_secret_key") to input and submit the form.') ?></p>
<div class="ok">
    <?php $form = ActiveForm::begin([
        'method' => 'POST',
        'action' => ['auth/ok-callback'],
    ]) ?>

    <?php echo $form->field($model, 'token')->textInput(['maxlength' => true]); ?>

    <div class="form-group">
       <div>
           <?= Html::submitButton(Yii::t('backend', 'Save'), ['class' => 'btn btn-primary']) ?>
       </div>
   </div>
    <?php ActiveForm::end() ?>
</div>
