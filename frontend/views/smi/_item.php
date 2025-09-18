<?php
/**
 * Created by PhpStorm.
 * User: Pavel
 * Date: 02.01.2022
 * Time: 11:23
 *
 * @var $this yii\web\View
 * @var  $model \common\models\Smi
 */

use yii\helpers\Html;

?>
<div class="preview <?= ($index > 1) ? 'hidden-index' : '' ?>" data-key="<?= $model -> id; ?>">
    <a href="<?= $model -> url ?>" target="_blank" rel="nofollow">
        <figure class="snip snip-<?= $model -> id ?>">
            <figcaption>
                <img src="<?= Yii ::$app -> glide -> createSignedUrl([
                    'glide/index',
                    'path' => $model -> catSmi -> image_path,
                    'fit' => 'fill',
                    'w' => 200,
                    'h' => 200,
                ], true) ?>" alt="<?= $model -> catSmi -> title ?>" class="profile"/>
                <blockquote><?= $model -> preview ?> </blockquote>
            </figcaption>
            <h3><?= $model -> catSmi -> title ?><span></span></h3>
        </figure>
    </a>
</div>