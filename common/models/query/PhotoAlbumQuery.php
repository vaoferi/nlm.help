<?php

namespace common\models\query;

use common\models\PhotoAlbum;
use omgdef\multilingual\MultilingualTrait;

/**
 * This is the ActiveQuery class for [[\common\models\PhotoAlbum]].
 *
 * @see \common\models\PhotoAlbum
 */
class PhotoAlbumQuery extends \yii\db\ActiveQuery
{
    use MultilingualTrait;

    /**
     * @return PhotoAlbumQuery
     */
    public function active()
    {
        return $this->andWhere(['status' => PhotoAlbum::STATUS_ACTIVE]);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\PhotoAlbum[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\PhotoAlbum|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
