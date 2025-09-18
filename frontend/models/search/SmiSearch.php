<?php

namespace frontend\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Smi;

/**
 * SmiSearch represents the model behind the search form of `common\models\Smi`.
 */
class SmiSearch extends Smi
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'cat_smi_id', 'created_at', 'updated_at'], 'integer'],
            [['created_at', 'updated_at'], 'default', 'value' => null],
            [['url'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
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
        $query = Smi::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $query->joinWith('translation');

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }


        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'cat_smi_id' => $this->cat_smi_id,
        ]);
        if ($this->created_at !== null) {
            $query->andFilterWhere(['between', 'created_at', $this->created_at, $this->created_at + 3600 * 24]);
        }

        if ($this->updated_at !== null) {
            $query->andFilterWhere(['between', 'updated_at', $this->updated_at, $this->updated_at + 3600 * 24]);
        }


//        $query->andFilterWhere(['like', 'url', $this->url]);
//        $query->andFilterWhere(['like', 'preview', $this->preview]);

        return $dataProvider;
    }
}
