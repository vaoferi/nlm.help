<?php

namespace common\models;

use common\components\social\TokenStorageInterface;
use Yii;
use yii\base\InvalidArgumentException;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%token_storage}}".
 *
 * @property int $id
 * @property string $client
 * @property string $token
 * @property int $expire_at
 * @property int $created_at
 * @property int $updated_at
 */
class TokenStorage extends \yii\db\ActiveRecord implements TokenStorageInterface
{
    const CLIENT_VK = 'vk';
    const CLIENT_FB = 'fb';
    const CLIENT_OK = 'ok';

    const OK_LONG_TOKEN_EXPIRES_IN = 2592000;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%token_storage}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['token'], 'string'],
            [['expire_at', 'created_at', 'updated_at'], 'integer'],
            [['client'], 'string', 'max' => 255],
        ];
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'client' => Yii::t('common', 'Client'),
            'token' => Yii::t('common', 'Token'),
            'expire_at' => Yii::t('common', 'Expire At'),
            'created_at' => Yii::t('common', 'Created At'),
            'updated_at' => Yii::t('common', 'Updated At'),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function getAccessToken(string $client)
    {
        $model = self::findOne(['client' => $client]);
        if ($model === null) {
            throw new InvalidArgumentException(sprintf('Cant find token for client %s', $client));
        }
        return $model->token;
    }
}
