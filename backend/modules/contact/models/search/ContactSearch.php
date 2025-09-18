<?php

namespace backend\modules\contact\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\ContactForm;

/**
 * ContactSearch represents the model behind the search form about `common\models\ContactForm`.
 */
class ContactSearch extends ContactForm
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'help_center_id', 'is_new', 'created_at', 'updated_at'], 'integer'],
            [['full_name', 'phone', 'email', 'body'], 'safe'],
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
        $query = ContactForm::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'help_center_id' => $this->help_center_id,
            'is_new' => $this->is_new,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'full_name', $this->full_name])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'body', $this->body]);

        return $dataProvider;
    }
}
