<?php

namespace backend\modules\content\models\search;

use common\models\Article;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class ArticleSearch extends Article
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'category_id', 'created_by', 'updated_by', 'status'], 'integer'],
            [['published_at', 'created_at', 'updated_at'], 'filter', 'filter' => 'strtotime', 'skipOnEmpty' => true],
            [['published_at', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['slug', 'title', 'body'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Article::find();
        $this->detachBehavior('slug');
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['title'] = [
            // The tables are the ones our relation are configured to
            // in my case they are prefixed with "tbl_"
            'asc' => ['{{%article_lang}}.title' => SORT_ASC],
            'desc' => ['{{%article_lang}}.title' => SORT_DESC],
        ];

        // Join all translations to avoid losing rows without current-language translation
        $query->joinWith('translations');
        $query->groupBy('{{%article}}.id');


        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'slug' => $this->slug,
            'created_by' => $this->created_by,
            'category_id' => $this->category_id,
            'updated_by' => $this->updated_by,
            'status' => $this->status,
        ]);

        if ($this->published_at !== null) {
            $query->andFilterWhere(['between', 'published_at', $this->published_at, $this->published_at + 3600 * 24]);
        }

        if ($this->created_at !== null) {
            $query->andFilterWhere(['between', 'created_at', $this->created_at, $this->created_at + 3600 * 24]);
        }

        if ($this->updated_at !== null) {
            $query->andFilterWhere(['between', 'updated_at', $this->updated_at, $this->updated_at + 3600 * 24]);
        }

        $query->andFilterWhere(['like', 'slug', $this->slug])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'body', $this->body]);

        return $dataProvider;
    }
}
