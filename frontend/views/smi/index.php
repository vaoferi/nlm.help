<?php
/**
 * Created by PhpStorm.
 * User: Pavel
 * Date: 02.01.2022
 * Time: 11:19
 */
?>
<div class="container">
<?= \yii\widgets\ListView ::widget([
    'dataProvider' => $dataProvider,
    'pager' => [
        'hideOnSinglePage' => true,
//            'disabledPageCssClass' => 'hidden',
    ],
    'layout' => '{items}',
//    'itemView' => '_item',
    'itemView' => function ($model, $key, $index, $widget) {
        return $this->render('@frontend/views/smi/_item',['model' => $model, 'index' => $index ]);
    },
    'itemOptions' => [
//        'class' => 'preview'
        'tag' => false,
    ],
    'options' => [
        'id' => 'smi',
        'class' => 'preview-list'
    ]
]);
?>
<?= \common\widgets\PaginationSectionWidget::widget(['pagination' => $pages, 'options' => [
    'class' => 'pagination__list smi_pagination']]) ?>
</div>
