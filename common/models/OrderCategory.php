<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%order_category}}".
 *
 * @property int $id
 * @property int $amount
 * @property string $comment
 * @property string $full_name
 * @property string $email
 * @property string $payment_system
 * @property int $status 0 => new, 1 => paid
 * @property int $category_id
 * @property int $created_at
 * @property int $updated_at
 * @property string $transaction_id
 * @property double $amount_received
 *
 * @property ArticleCategory $category
 */
class OrderCategory extends OrderAbstract
{
    public $order_type = 'category';

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::class
        ];
    }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%order_category}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['payment_system', 'in', 'range' => array_keys(self::paymentSystems())],
            [['amount', 'status', 'category_id', 'created_at', 'updated_at'], 'integer'],
            [['comment'], 'string'],
            [['full_name', 'email'], 'required'],
            [['amount_received'], 'number'],
            [['full_name', 'email', 'payment_system', 'transaction_id'], 'string', 'max' => 255],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => ArticleCategory::className(), 'targetAttribute' => ['category_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'amount' => Yii::t('common', 'Amount'),
            'comment' => Yii::t('common', 'Comment'),
            'full_name' => Yii::t('common', 'Full Name'),
            'email' => Yii::t('common', 'Email'),
            'payment_system' => Yii::t('common', 'Payment System'),
            'status' => Yii::t('common', 'Status'),
            'category_id' => Yii::t('common', 'Category ID'),
            'created_at' => Yii::t('common', 'Created At'),
            'updated_at' => Yii::t('common', 'Updated At'),
            'transaction_id' => Yii::t('common', 'Transaction ID'),
            'amount_received' => Yii::t('common', 'Amount Received'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(ArticleCategory::className(), ['id' => 'category_id']);
    }
}
