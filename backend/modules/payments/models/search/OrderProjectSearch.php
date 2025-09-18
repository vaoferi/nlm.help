<?php

namespace backend\modules\payments\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\OrderProject;

/**
 * OrderProjectSearch represents the model behind the search form about `common\models\OrderProject`.
 */
class OrderProjectSearch extends OrderProject
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'amount', 'status', 'project_id', 'created_at', 'updated_at'], 'integer'],
            [['comment', 'full_name', 'email', 'payment_system', 'transaction_id'], 'safe'],
            [['amount_received'], 'number'],
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
        $query = OrderProject::find();
        $query->with('project');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'amount' => $this->amount,
            'status' => $this->status,
            'project_id' => $this->project_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'amount_received' => $this->amount_received,
        ]);

        $query->andFilterWhere(['like', 'comment', $this->comment])
            ->andFilterWhere(['like', 'full_name', $this->full_name])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'payment_system', $this->payment_system])
            ->andFilterWhere(['like', 'transaction_id', $this->transaction_id]);

        return $dataProvider;
    }
}
