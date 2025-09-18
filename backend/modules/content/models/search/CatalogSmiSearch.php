<?php

namespace backend\modules\content\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\CatalogSmi;

/**
 * CatalogSmiSearch represents the model behind the search form of `common\models\CatalogSmi`.
 */
class CatalogSmiSearch extends CatalogSmi
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'created_at', 'updated_at'], 'integer'],
            [['created_at', 'updated_at'], 'default', 'value' => null],
            [['title'], 'safe'],
//            [['image_path', 'image_base_url'], 'safe'],
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
        $query = CatalogSmi::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['title'] = [
            // The tables are the ones our relation are configured to
            // in my case they are prefixed with "tbl_"
            'asc' => ['{{%catalog_smi_lang}}.title' => SORT_ASC],
            'desc' => ['{{%catalog_smi_lang}}.title' => SORT_DESC],
        ];

        $query->joinWith('translation');

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
        ]);
        $query->andFilterWhere(['like', 'title', $this->title]);

        if ($this->created_at !== null) {
            $query->andFilterWhere(['between', 'created_at', $this->created_at, $this->created_at + 3600 * 24]);
        }

        if ($this->updated_at !== null) {
            $query->andFilterWhere(['between', 'updated_at', $this->updated_at, $this->updated_at + 3600 * 24]);
        }


        return $dataProvider;
    }
}
