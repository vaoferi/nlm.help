<?php

namespace common\models;

use Yii;
use yii\db\Query;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%partner_order}}".
 *
 * @property int $id
 * @property int $partner_id
 * @property int $order
 *
 * @property Partner $partner
 */
class PartnerOrder extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%partner_order}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['partner_id', 'order'], 'integer'],
            [['partner_id'], 'exist', 'skipOnError' => true, 'targetClass' => Partner::className(), 'targetAttribute' => ['partner_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'partner_id' => Yii::t('common', 'Partner ID'),
            'order' => Yii::t('common', 'Order'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPartner()
    {
        return $this->hasOne(Partner::className(), ['id' => 'partner_id']);
    }

    /**
     * @return array
     * @throws \yii\db\Exception
     */
    public static function getOrder()
    {
        $query = new Query();
        $command = $query->select('partner_id')
            ->from(self::tableName())
            ->orderBy(['order' => SORT_ASC])
            ->createCommand();
        $result = $command->queryAll();
        return ArrayHelper::getColumn($result, 'partner_id');
    }
}
