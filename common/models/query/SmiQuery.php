<?php

namespace common\models\query;

use omgdef\multilingual\MultilingualTrait;
/**
 * This is the ActiveQuery class for [[\common\models\Smi]].
 *
 * @see \common\models\Smi
 */
class SmiQuery extends \yii\db\ActiveQuery
{
    use MultilingualTrait;
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \common\models\Smi[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\Smi|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
