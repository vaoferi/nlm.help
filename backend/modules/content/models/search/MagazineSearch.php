<?php

namespace backend\modules\content\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Magazine;

/**
 * MagazineSearch represents the model behind the search form about `common\models\Magazine`.
 */
class MagazineSearch extends Magazine
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'number', 'created_by', 'updated_by'], 'integer'],
            [['thumbnail_base_url', 'thumbnail_path', 'attachment_path', 'attachment_base_url', 'title'], 'safe'],
            [['created_at', 'updated_at'], 'filter', 'filter' => 'strtotime', 'skipOnEmpty' => true],
            [['created_at', 'updated_at'], 'default', 'value' => null],
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
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Magazine::find();
        $query->joinWith('translation');
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'number' => $this->number,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
        ]);

        if ($this->created_at !== null) {
            $query->andFilterWhere(['between', 'created_at', $this->created_at, $this->created_at + 3600 * 24]);
        }

        if ($this->updated_at !== null) {
            $query->andFilterWhere(['between', 'updated_at', $this->updated_at, $this->updated_at + 3600 * 24]);
        }
        $query->andFilterWhere(['like', 'title', $this->title]);

        $query->andFilterWhere(['like', 'thumbnail_base_url', $this->thumbnail_base_url])
            ->andFilterWhere(['like', 'thumbnail_path', $this->thumbnail_path])
            ->andFilterWhere(['like', 'attachment_path', $this->attachment_path])
            ->andFilterWhere(['like', 'attachment_base_url', $this->attachment_base_url]);

        return $dataProvider;
    }
}
