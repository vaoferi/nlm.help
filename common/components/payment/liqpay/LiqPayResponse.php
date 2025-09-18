<?php
/**
 * Created by Rex IT
 * @author Konstantin Kharalampidi <kharalampidi@rexit.info>
 */

namespace common\components\payment\liqpay;


use common\commands\AddToTimelineCommand;
use common\commands\CategoryPaymentCommand;
use common\commands\PaymentCommand;
use rexit\liqpay\AbstractResponse;
use Yii;
use yii\db\Expression;
use yii\helpers\ArrayHelper;

class LiqPayResponse extends AbstractResponse
{
    private $successStatuses = [
        'success',
        'sandbox'
    ];

    public function run()
    {
        if ($this->validate()) {
            \Yii::$app->getDb()->createCommand()->insert('{{%payment_log}}', [
                'created_at' => new Expression('NOW()'),
                'payment_system' => 'liqpay',
                'body' => json_encode($this->getResponseBody()),
                'transaction_id' => $this->getValue('transaction_id')
            ])->execute();
            $this->storeResult();
        }
    }

    protected function storeResult()
    {
        if (($transaction_id = $this->getValue('transaction_id')) !== null) {
            if (($status = $this->getValue('status')) !== null) {
                if (in_array($status, $this->successStatuses)) {
                    \Yii::$app->commandBus->handle(new PaymentCommand([
                        'amount' => $this->calculateReceivedAmount(),
                        'payment_system' => 'liqpay',
                        'transaction_id' => $this->getValue('transaction_id'),
                        'order_id' => $this->getValue('order_id'),
                    ]));
                }
            }
        }
    }


    /**
     * @return mixed
     */
    protected function calculateReceivedAmount()
    {
        return $this->getValue('amount');
    }

    private function getValue($key)
    {
        return ArrayHelper::getValue($this->getResponseBody(), $key, null);
    }
}