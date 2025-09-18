<?php
/**
 * Created by Rex IT
 * @author Konstantin Kharalampidi <kharalampidi@rexit.info>
 */

namespace common\commands;


use common\models\OrderAbstract;
use common\models\OrderCategory;
use common\models\OrderProject;
use common\models\OrderService;
use trntv\bus\interfaces\SelfHandlingCommand;
use Yii;
use yii\base\BaseObject;
use yii\base\InvalidArgumentException;
use yii\db\ActiveQuery;
use yii\mutex\Mutex;
use yii\validators\NumberValidator;

class PaymentCommand extends BaseObject implements SelfHandlingCommand
{
    public $amount;

    public $payment_system;

    public $order_id;

    public $transaction_id;

    public $log_id;

    public $useMutex = true;

    public $mutexClass = 'yii\mutex\FileMutex';

    private $order;

    public function init()
    {
        parent::init();
        $this->validateProperties();
    }

    /**
     * @return void
     */
    private function validateProperties(): void
    {
        if (!$this->transaction_id || !$this->amount || !$this->order_id || !$this->payment_system) {
            throw new InvalidArgumentException(sprintf('Please use required args: %s', implode(", ", [
                'amount',
                'order_id',
                'payment_system'
            ])));
        }
        $numberValidator = new NumberValidator();
        if (!$numberValidator->validate($this->amount, $error)) {
            throw new InvalidArgumentException($error);
        }

        if (($this->order = $this->findOrder()) === null) {
            throw new InvalidArgumentException('Invalid ID for order_id');
        }

        if (!in_array($this->payment_system, $this->getAvailableSystems())) {
            throw new InvalidArgumentException(sprintf('Invalid payment_system. Please use one of: %s', implode(", ", $this->getAvailableSystems())));
        }
    }

    /**
     * @param $command
     * @return bool
     */
    public function handle($command): bool
    {
        /** @var OrderAbstract $order */
        $order = $this->order;
        $order->transaction_id = $this->transaction_id;
        $order->amount_received = $this->amount;
        $order->status = $order::STATUS_PAID;
        $order->payment_system = $this->payment_system;
        $result = true;
        if ($result = $result && $order->save(false)) {
            // todo implement mutex here
            $result = $result && $order->updateCounter($order->amount_received);
        }
        if ($result) {
            Yii::$app->commandBus->handle(new AddToTimelineCommand([
                'category' => 'payments',
                'event' => 'payment',
                'data' => [
                    'full_name' => $order->full_name,
                    'created_at' => time(),
                    'amount' => Yii::$app->formatter->asCurrency($order->amount_received),
                    'order_id' => $this->order_id
                ]
            ]));
        }
        return $result;
    }

    /**
     * @return null|\yii\db\ActiveRecord
     */
    protected function findOrder()
    {
        $order = explode("_", $this->order_id);
        if (count($order) === 2) {
            $orderType = array_shift($order);
            $orderId = array_shift($order);
            switch ($orderType) {
                case 'project':
                    $className = OrderProject::class;
                    break;
                case 'category':
                    $className = OrderCategory::class;
                    break;
                case 'service':
                    $className = OrderService::class;
                    break;
                default:
                    $className = false;
                    break;
            }
            if ($className !== false) {
                /** @var ActiveQuery $query */
                $query = $className::find();
                $result = $query->andWhere(['id' => $orderId])->one();
                return $result;
            }
        }
        return null;
    }

    /**
     * @return mixed
     */
    public function getOrder(): OrderProject
    {
        return $this->order;
    }

    /**
     * @return array
     */
    protected function getAvailableSystems(): array
    {
        return [
            'paypal',
            'liqpay'
        ];
    }
}