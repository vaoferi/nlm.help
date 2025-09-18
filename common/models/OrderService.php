<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%order_service}}".
 *
 * @property int $id
 * @property int $amount
 * @property string $comment
 * @property string $full_name
 * @property string $email
 * @property string $payment_system
 * @property int $status 0 => new, 1 => paid
 * @property int $created_at
 * @property int $updated_at
 * @property string $transaction_id
 * @property double $amount_received
 */
class OrderService extends OrderAbstract
{
    public $order_type = 'service';
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%order_service}}';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::class
        ];
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['amount', 'status', 'created_at', 'updated_at'], 'integer'],
            [['comment'], 'string'],
            [['full_name', 'email'], 'required'],
            [['amount_received'], 'number'],
            [['full_name', 'email', 'payment_system', 'transaction_id'], 'string', 'max' => 255],
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
            'created_at' => Yii::t('common', 'Created At'),
            'updated_at' => Yii::t('common', 'Updated At'),
            'transaction_id' => Yii::t('common', 'Transaction ID'),
            'amount_received' => Yii::t('common', 'Amount Received'),
        ];
    }
}
