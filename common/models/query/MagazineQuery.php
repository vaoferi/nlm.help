<?php

namespace common\models\query;

use omgdef\multilingual\MultilingualTrait;

/**
 * This is the ActiveQuery class for [[\common\models\Magazine]].
 *
 * @see \common\models\Magazine
 */
class MagazineQuery extends \yii\db\ActiveQuery
{
    use MultilingualTrait;

    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \common\models\Magazine[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\Magazine|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
