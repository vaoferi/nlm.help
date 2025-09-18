<?php

namespace backend\modules\content\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\PhotoAlbum;

/**
 * PhotoAlbumSearch represents the model behind the search form about `common\models\PhotoAlbum`.
 */
class PhotoAlbumSearch extends PhotoAlbum
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status', 'created_by', 'updated_by'], 'integer'],
            [['slug', 'title'], 'safe'],
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
        $query = PhotoAlbum::find();
        $this->detachBehavior('slug');
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $query->joinWith('translation');

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'status' => $this->status,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
        ]);
        $query->andFilterWhere(['like', 'title', $this->title]);

        if ($this->created_at !== null) {
            $query->andFilterWhere(['between', 'created_at', $this->created_at, $this->created_at + 3600 * 24]);
        }

        if ($this->updated_at !== null) {
            $query->andFilterWhere(['between', 'updated_at', $this->updated_at, $this->updated_at + 3600 * 24]);
        }
        $query->andFilterWhere(['like', 'slug', $this->slug]);

        return $dataProvider;
    }
}
