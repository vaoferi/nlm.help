<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%order_project}}".
 *
 * @property int $id
 * @property int $amount
 * @property string $comment
 * @property string $full_name
 * @property string $email
 * @property string $payment_system
 * @property string $transaction_id
 * @property double $amount_received
 * @property int $status 0 => new, 1 => paid
 * @property int $project_id
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Project $project
 */
class OrderProject extends OrderAbstract
{
    public $order_type = 'project';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%order_project}}';
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
            ['amount_received', 'double'],
            [['amount', 'status', 'project_id', 'created_at', 'updated_at'], 'integer'],
            [['comment'], 'string'],
            [['full_name', 'email'], 'required'],
            [['full_name', 'email', 'payment_system', 'transaction_id'], 'string', 'max' => 255],
            [['project_id'], 'exist', 'skipOnError' => true, 'targetClass' => Project::className(), 'targetAttribute' => ['project_id' => 'id']],
            ['payment_system', 'in', 'range' => array_keys(self::paymentSystems())]
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
            'status' => Yii::t('common', 'Paid'),
            'project_id' => Yii::t('common', 'Project ID'),
            'created_at' => Yii::t('common', 'Created At'),
            'updated_at' => Yii::t('common', 'Updated At'),
            'transaction_id' => Yii::t('common', 'Transaction ID'),
            'amount_received' => Yii::t('common', 'Amount Received'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProject()
    {
        return $this->hasOne(Project::className(), ['id' => 'project_id']);
    }

    /**
     * @param $amount
     * @return bool
     */
    public function updateCounter($amount)
    {
        $project = $this->project;
        return $project->updateCounters([
            'collected_amount' => (int)$amount
        ]);
    }
}
