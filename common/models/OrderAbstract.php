<?php
/**
 * Created by Rex IT
 * @author Konstantin Kharalampidi <kharalampidi@rexit.info>
 */

namespace common\models;


use yii\db\ActiveRecord;

/**
 * This is the abstract class for Orders
 *
 * @property int $id
 * @property int $amount
 * @property string $comment
 * @property string $email
 * @property string $full_name
 * @property string $payment_system
 * @property string $transaction_id
 * @property double $amount_received
 * @property int $status 0 => new, 1 => paid
 * @property int $created_at
 * @property int $updated_at
 */
abstract class OrderAbstract extends ActiveRecord
{
    const STATUS_NEW = 0;
    const STATUS_PAID = 1;

    public $order_type = '';

    /**
     * @return array
     */
    public static function paymentSystems()
    {
        return [
            'cash' => \Yii::t('common', 'Cash'),
            'paypal' => \Yii::t('common', 'PayPal'),
            'liqpay' => \Yii::t('common', 'LiqPay'),
            'bank' => \Yii::t('common', 'Bank details'),
        ];
    }

    /**
     * @param $amount
     * @return bool
     */
    public function updateCounter($amount)
    {
        return true;
    }
}