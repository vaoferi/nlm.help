<?php

namespace common\models\query;

use common\models\Partner;
use omgdef\multilingual\MultilingualTrait;
use yii\db\Expression;

/**
 * This is the ActiveQuery class for [[\common\models\Partner]].
 *
 * @see \common\models\Partner
 */
class PartnerQuery extends \yii\db\ActiveQuery
{
    use MultilingualTrait;

    /**
     * @return PartnerQuery
     */
    public function active()
    {
        return $this->andWhere(['show_status' => true]);
    }

    /**
     * @return PartnerQuery
     */
    public function show()
    {
        return $this->andWhere(['show_status' => true]);
    }

    /**
     * @param array $idx
     * @return PartnerQuery
     */
    public function specOrder(array $idx)
    {
        if (!empty($idx)) {
            $idxString = implode(',', $idx);
            return $this->orderBy([new Expression("FIELD({{%partner}}.`id`, {$idxString})")]);
        }
        return $this;
    }

    /**
     * {@inheritdoc}
     * @return \common\models\Partner[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\Partner|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
