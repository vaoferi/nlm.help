<?php

namespace common\models\query;

use omgdef\multilingual\MultilingualTrait;
use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[\common\models\CatalogSmi]].
 *
 * @see \common\models\CatalogSmi
 */
class CatalogSmiQuery extends ActiveQuery
{
    use MultilingualTrait;

    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \common\models\CatalogSmi[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\CatalogSmi|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
