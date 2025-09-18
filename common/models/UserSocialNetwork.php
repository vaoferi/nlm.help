<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%user_social_network}}".
 *
 * @property int $id
 * @property int $user_id
 * @property int $social_network
 * @property string $link
 * @property int $created_at
 * @property int $updated_at
 *
 * @property User $user
 */
class UserSocialNetwork extends \yii\db\ActiveRecord
{
    const SOCIAL_NETWORK_FB = 1;
    const SOCIAL_NETWORK_VK = 2;
    const SOCIAL_NETWORK_OK = 3;
    const SOCIAL_NETWORK_PT = 4;
    const SOCIAL_NETWORK_IG = 5;
    const SOCIAL_NETWORK_YT = 6;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%user_social_network}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'social_network'], 'required'],
            [['user_id', 'social_network', 'created_at', 'updated_at'], 'integer'],
            [['link'], 'string', 'max' => 400],
            [['link'], 'url', 'skipOnEmpty' => true],
            ['social_network', 'in', 'range' => array_keys(self::socialNetworks())],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }

    /**
     * Returns user statuses list
     * @return array|mixed
     */
    public static function socialNetworks()
    {
        return [
            self::SOCIAL_NETWORK_FB => Yii::t('common', 'Facebook'),
            self::SOCIAL_NETWORK_VK => Yii::t('common', 'Vkontakte'),
            self::SOCIAL_NETWORK_OK => Yii::t('common', 'Odnoklassniki'),
            self::SOCIAL_NETWORK_PT => Yii::t('common', 'Pinterest'),
            self::SOCIAL_NETWORK_IG => Yii::t('common', 'Instagram'),
            self::SOCIAL_NETWORK_YT => Yii::t('common', 'YouTube'),
        ];
    }

    public static function getSocialNetworkTitle($sc)
    {
        $socialNetworks = self::socialNetworks();
        return isset($socialNetworks[$sc]) ? $socialNetworks[$sc] : null;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'user_id' => Yii::t('common', 'User ID'),
            'social_network' => Yii::t('common', 'Social Network'),
            'link' => Yii::t('common', 'Link'),
            'created_at' => Yii::t('common', 'Created At'),
            'updated_at' => Yii::t('common', 'Updated At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
