<?php

use common\models\User;
use trntv\filekit\widget\Upload;
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
use yii\web\JsExpression;
// use dosamigos\tinymce\TinyMce; // switched to Imperavi to avoid TinyMCE license prompt

/* @var $this yii\web\View */
/* @var $model backend\models\UserForm */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $roles yii\rbac\Role[] */
/* @var $permissions yii\rbac\Permission[] */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin() ?>
        <div class="row">
            <div class="col-md-6">
                <?php echo $form->field($model, 'username') ?>
            </div>
            <div class="col-md-6">
                <?php echo $form->field($model, 'email') ?>
            </div>
            <div class="col-md-12">
                <?php echo $form->field($model, 'slug') ?>
            </div>

            <div class="col-md-12">
                <ul class="nav nav-tabs" role="tablist">
                    <?php foreach (Yii::$app->params['availableLocales'] as $code => $lang) : ?>
                        <?php $isactive = ($code === \Yii::$app->language)?'active':''; ?>
                        <li class="nav-item">
                            <a class="nav-link <?= $isactive ?>" data-bs-toggle="tab" href="#<?= $code ?>" role="tab"><?= $lang ?></a>
                        </li>
                    <?php endforeach; ?>
                </ul>

                <div class="tab-content">
                    <?php $defaultLang = 'ru'; ?>
                    <?php foreach (Yii::$app->params['availableLocales'] as $code => $lang) : ?>
                        <?php $lng = ($code === $defaultLang)?'':'_'.$code; ?>
                        <div class="tab-pane <?= ($code === \Yii::$app->language)? 'active': '' ?>" id="<?= $code ?>" role="tabpanel">

                            <?php if ($code == $defaultLang) : ?>
                                <div class="col-md-4">
                                    <?php echo $form->field($model, 'first_name') ?>
                                </div>
                                <div class="col-md-4">
                                    <?php echo $form->field($model, 'last_name') ?>
                                </div>
                                <div class="col-md-4">
                                    <?php echo $form->field($model, 'position') ?>
                                </div>
                                <div class="col-md-12">
                                    <?php echo $form->field($model, 'short_info')->widget(\yii\imperavi\Widget::class, [
                                        'plugins' => ['fullscreen', 'fontcolor', 'video'],
                                        'options' => [
                                            'minHeight' => 220,
                                            'removeEmptyTags' => true,
                                            'imageUpload' => Yii::$app->urlManager->createUrl(['/file/storage/upload-imperavi']),
                                        ],
                                    ]);
                                    ?>
                                </div>
                                <div class="col-md-12">
                                    <?php echo $form->field($model, 'full_info')->widget(\yii\imperavi\Widget::class, [
                                        'plugins' => ['fullscreen', 'fontcolor', 'video'],
                                        'options' => [
                                            'minHeight' => 420,
                                            'removeEmptyTags' => true,
                                            'imageUpload' => Yii::$app->urlManager->createUrl(['/file/storage/upload-imperavi']),
                                        ],
                                    ]);
                                    ?>
                                </div>
                            <?php else : ?>
                                <div class="col-md-4">
                                    <?php echo $form->field($model, "first_name_{$code}") ?>
                                </div>
                                <div class="col-md-4">
                                    <?php echo $form->field($model, "last_name_{$code}") ?>
                                </div>
                                <div class="col-md-4">
                                    <?php echo $form->field($model, "position_{$code}") ?>
                                </div>
                                <div class="col-md-12">
                                    <?php echo $form->field($model, "short_info_{$code}")->widget(\yii\imperavi\Widget::class, [
                                        'plugins' => ['fullscreen', 'fontcolor', 'video'],
                                        'options' => [
                                            'minHeight' => 220,
                                            'removeEmptyTags' => true,
                                            'imageUpload' => Yii::$app->urlManager->createUrl(['/file/storage/upload-imperavi']),
                                        ],
                                    ]);
                                    ?>
                                </div>
                                <div class="col-md-12">
                                    <?php echo $form->field($model, "full_info_{$code}")->widget(\yii\imperavi\Widget::class, [
                                        'plugins' => ['fullscreen', 'fontcolor', 'video'],
                                        'options' => [
                                            'minHeight' => 420,
                                            'removeEmptyTags' => true,
                                            'imageUpload' => Yii::$app->urlManager->createUrl(['/file/storage/upload-imperavi']),
                                        ],
                                    ]);
                                    ?>
                                </div>
                            <?php endif ?>

                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="col-md-6">
                <?php echo $form->field($model, 'certificate') ?>
            </div>


            <div class="col-md-6">
                <?php echo $form->field($model, 'password')->passwordInput() ?>
            </div>

            <div class="col-md-12">
                <?php echo $form->field($model, 'photo')->widget(
                    Upload::class,
                    [
                        'url' => ['/file/storage/upload'],
                        'maxFileSize' => uploadMaxSize(),
                        'acceptFileTypes' => new JsExpression('/(\.|\/)(jpe?g|png)$/i'),
                    ]);
                ?>
            </div>

            <div class="col-md-6">
                <?php echo $form->field($model, 'status')->dropDownList(User::statuses()) ?>
            </div>
            <div class="col-md-6">
                <?php echo $form->field($model, 'display')->dropDownList(User::displayStatuses()) ?>
            </div>

            <div class="col-md-12">
                <?php echo $form->field($model, 'roles')->checkboxList($roles) ?>
            </div>
        </div>

        <div class="form-group">
            <?php echo Html::submitButton(Yii::t('backend', 'Save'), [
                    'class' => 'btn btn-primary btn-block',
                    'name' => 'signup-button'
            ]) ?>
        </div>
    <?php ActiveForm::end() ?>

</div>
