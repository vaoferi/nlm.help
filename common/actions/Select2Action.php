<?php
/**
 * Created by PhpStorm.
 * User: rex
 * Date: 16.01.19
 * Time: 15:45
 */

namespace common\actions;


use yii\base\Action;
use yii\base\InvalidConfigException;
use yii\data\Pagination;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use yii\web\Response;

class Select2Action extends Action
{
    public $query;

    public $limit = 20;

    public $searchParam = 'q';

    public $idParam = 'id';

    public $pageParam = 'page';

    public $textField;

    public $idField;

    public $searchField;

    /**
     * @throws InvalidConfigException
     */
    public function init()
    {
        if (!$this->query instanceof ActiveQuery) {
            throw new InvalidConfigException(get_class($this) . '::$query must be instance of Query.');
        }

        if (empty($this->textField)) {
            throw new InvalidConfigException(get_class($this) . '::textField must be set.');
        }

        if (empty($this->idField)) {
            throw new InvalidConfigException(get_class($this) . '::idField must be set.');
        }
    }

    /**
     * @return array
     */
    public function run()
    {
        \Yii::$app->getResponse()->format = Response::FORMAT_JSON;
        return $this->getData();
    }

    /**
     * @return array
     */
    protected function getData()
    {
        $query = $this->getQuery();
        $search = trim((string)$this->getSearchRequest());
        $column = $this->searchField ?: $this->textField;
        if ($search !== '') {
            $query->andWhere(['like', $column, $search]);
        }
        $count = $query->count();
        $pagination = new Pagination([
            'totalCount' => $count,
            'pageParam' => $this->pageParam,
            'defaultPageSize' => $this->limit
        ]);

        $data = $query
            ->limit($pagination->getLimit())
            ->offset($pagination->getOffset())
            ->all();
        $results = ArrayHelper::getColumn($data, function (ActiveRecord $model) {
            if (method_exists($model, 'canGetProperty')) {
                if (!$model->canGetProperty($this->textField)) {
                    throw new InvalidConfigException(get_class($this) . '::textField must be set correctly.');
                }
                if (!$model->canGetProperty($this->idField)) {
                    throw new InvalidConfigException(get_class($this) . '::idField must be set correctly.');
                }
            }
            return [
                'id' => $model->{$this->idField},
                'text' => $model->{$this->textField},
            ];
        });
        return [
            'results' => $results,
            'pagination' => [
                'more' => ($pagination->getPage() + 1) < $pagination->getPageCount()
            ]
        ];
    }

    /**
     * @return string|null
     */
    public function getId()
    {
        return \Yii::$app->getRequest()->get($this->idParam);
    }

    /**
     * @return string|null
     */
    public function getSearchRequest()
    {
        return \Yii::$app->getRequest()->get($this->searchParam);
    }

    /**
     * @return Query
     */
    public function getQuery()
    {
        return $this->query;
    }
}
