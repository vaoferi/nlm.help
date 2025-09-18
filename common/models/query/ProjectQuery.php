<?php

namespace common\models\query;

use common\models\Project;
use omgdef\multilingual\MultilingualTrait;
use yii\db\ActiveQuery;
use yii\db\Expression;

/**
 * This is the ActiveQuery class for [[\common\models\Project]].
 *
 * @see \common\models\Project
 */
class ProjectQuery extends \yii\db\ActiveQuery
{
    use MultilingualTrait;

    /**
     * @return ProjectQuery
     */
    public function active()
    {
        return $this->andWhere(['status' => Project::STATUS_ACTIVE]);
    }

    /**
     * @param array $idx
     * @return ProjectQuery
     */
    public function specOrder(array $idx)
    {
        if (!empty($idx)) {
            $idxString = implode(',', $idx);
            return $this->orderBy([new Expression("FIELD({{%project}}.`id`, {$idxString})")]);
        }
        return $this;
    }

    /**
     * @param int $partner_id
     * @return $this
     */
    public function byPartner(int $partner_id)
    {
        $this->joinWith(['partnerProjects' => function(ActiveQuery $query) use ($partner_id) {
            return $query->andOnCondition(['partner_id' => $partner_id]);
        }]);
        $this->andWhere(['IS NOT', '{{%partner_project}}.id', null]);
        return $this;
    }

    /**
     * {@inheritdoc}
     * @return \common\models\Project[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\Project|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
