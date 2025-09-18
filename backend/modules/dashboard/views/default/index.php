<?php
/* @var $this yii\web\View */
/* @var $stats array */
/* @var $latest common\models\Article[] */

$this->title = 'Панель управления';
?>

<div class="row">
    <div class="col-12">
        <h3 class="mt-2 mb-3">Быстрые статистики</h3>
    </div>

    <?php
    $cards = [
        ['label' => 'Статьи', 'key' => 'articles', 'url' => ['/content/article/index'], 'bg' => 'bg-primary'],
        ['label' => 'Видео', 'key' => 'videos', 'url' => ['/content/video/index'], 'bg' => 'bg-success'],
        ['label' => 'Отзывы', 'key' => 'testimonials', 'url' => ['/content/testimonial/index'], 'bg' => 'bg-info'],
        ['label' => 'Партнёры', 'key' => 'partners', 'url' => ['/content/partner/index'], 'bg' => 'bg-warning text-dark'],
    ];
    foreach ($cards as $card): ?>
        <div class="col-md-3">
            <div class="card text-white <?= $card['bg'] ?> shadow-sm">
                <div class="card-body">
                    <h6 class="card-title mb-1 fw-semibold"><?= $card['label'] ?></h6>
                    <h2 class="mb-0 fw-bold"><?= (int)$stats[$card['key']] ?></h2>
                    <a class="stretched-link" href="<?= \yii\helpers\Url::to($card['url']) ?>" aria-label="<?= $card['label'] ?>"></a>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<div class="row mt-4">
    <div class="col-12">
        <h3 class="mt-2 mb-3">Последние статьи</h3>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Слаг</th>
                        <th>Создано</th>
                        <th>Действия</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($latest as $article): ?>
                    <tr>
                        <td><?= $article->id ?></td>
                        <td><?= \yii\helpers\Html::encode($article->slug) ?></td>
                        <td><?= Yii::$app->formatter->asDatetime($article->created_at) ?></td>
                        <td><a href="<?= \yii\helpers\Url::to(['/content/article/update','id'=>$article->id]) ?>" class="btn btn-sm btn-outline-primary">Редактировать</a></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-12 mt-3">
        <a href="<?= \yii\helpers\Url::to(['/content/article/create']) ?>" class="btn btn-success">Создать статью</a>
        <a href="<?= \yii\helpers\Url::to(['/content/video/create']) ?>" class="btn btn-outline-success">Создать видео</a>
    </div>
    <div class="col-12 mt-3">
        <small class="text-muted">Виджеты только для чтения, без изменения данных.</small>
    </div>
</div>
