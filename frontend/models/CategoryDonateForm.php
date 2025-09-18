<?php
/**
 * Created by Rex IT
 * @author Konstantin Kharalampidi <kharalampidi@rexit.info>
 */

namespace frontend\models;


use common\commands\AddToTimelineCommand;
use common\models\OrderCategory;
use common\models\OrderProject;
use Yii;
use yii\base\Model;

class CategoryDonateForm extends Model
{
    public $amount;
    public $email;
    public $comment;
    public $full_name;
    public $payment_system;

    private $category_id;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['amount'], 'integer'],
            [['comment'], 'string'],
            [['full_name', 'email', 'payment_system', 'amount'], 'required'],
            [['full_name', 'email', 'payment_system'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'amount' => Yii::t('frontend', 'Amount'),
            'comment' => Yii::t('frontend', 'Comment'),
            'full_name' => Yii::t('frontend', 'Full Name'),
            'email' => Yii::t('frontend', 'Email'),
            'payment_system' => Yii::t('frontend', 'Payment System'),
        ];
    }

    /**
     * @return OrderProject
     */
    public function createOrder()
    {
        $model = new OrderCategory();
        $model->full_name = $this->full_name;
        $model->email = $this->email;
        $model->comment = $this->comment;
        $model->amount = $this->amount;
        $model->category_id = $this->category_id;
        if ($this->payment_system == 'cash') {
            $model->payment_system = 'cash';
        }elseif ($this->payment_system == 'bank') {
            $model->payment_system = 'bank';
        }
        $model->save(false);
        if ($model->payment_system == 'cash') {
            Yii::$app->commandBus->handle(new AddToTimelineCommand([
                'category' => 'payments',
                'event' => 'new-cash',
                'data' => [
                    'full_name' => $model->full_name,
                    'created_at' => time(),
                    'amount' => Yii::$app->formatter->asCurrency($model->amount),
                    'order_id' => implode("_",['category', $model->id])
                ]
            ]));
        }elseif ($model->payment_system == 'bank') {
            Yii::$app->commandBus->handle(new AddToTimelineCommand([
                'category' => 'payments',
                'event' => 'new-bank',
                'data' => [
                    'full_name' => $model->full_name,
                    'created_at' => time(),
                    'amount' => Yii::$app->formatter->asCurrency($model->amount),
                    'order_id' => implode("_",['category', $model->id])
                ]
            ]));
        }
        return $model;
    }

    /**
     * @param mixed $category_id
     */
    public function setCategory(int $category_id): void
    {
        $this->category_id = $category_id;
    }
}