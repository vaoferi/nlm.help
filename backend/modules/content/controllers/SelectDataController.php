<?php
/**
 * Created by PhpStorm.
 * User: rex
 * Date: 17.01.19
 * Time: 13:02
 */

namespace backend\modules\content\controllers;


use common\actions\Select2Action;
use common\models\Article;
use common\models\Partner;
use common\models\Project;
use yii\web\Controller;

class SelectDataController extends Controller
{
    /**
     * @return array
     */
    public function actions()
    {
        return [
            'select-partners' => [
                'class' => Select2Action::class,
                'query' => Partner::find()->joinWith('translation'),
                'idField' => 'id',
                'textField' => 'name',
                'searchField' => 'partner_lang.name',
                'limit' => 10
            ],
            'select-articles' => [
                'class' => Select2Action::class,
                'query' => Article::find()->joinWith('translation')->orderBy(['created_at' => SORT_DESC]),
                'idField' => 'id',
                'textField' => 'title',
                'searchField' => 'article_lang.title',
                'limit' => 10
            ],
            'select-projects' => [
                'class' => Select2Action::class,
                'query' => Project::find()->joinWith('translation'),
                'idField' => 'id',
                'textField' => 'title',
                'searchField' => 'project_lang.title',
                'limit' => 10
            ]
        ];
    }
}
