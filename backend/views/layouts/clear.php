<?php
/**
 * @var $this yii\web\View
 * @var $content string
 */
?>
<?php if (function_exists('env') && env('ADMIN_THEME') === 'hyper') {
    echo $this->renderFile('@backend/views/layouts/hyper.php', ['content' => $content]);
    return;
} ?>
<?php $this->beginContent('@backend/views/layouts/common.php'); ?>
    <?php echo $content ?>
<?php $this->endContent(); ?>
