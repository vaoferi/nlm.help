<?php

namespace common\models;

use common\commands\AddToTimelineCommand;
use common\behaviors\ProfileSluggableBehavior;
use common\models\query\UserQuery;
use trntv\filekit\behaviors\UploadBehavior;
use Yii;
use yii\behaviors\AttributeBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\web\IdentityInterface;

/**
 * User model
 *
 * @property integer $id
 * @property string $slug
 * @property string $username
 * @property string $first_name
 * @property string $first_name_en
 * @property string $first_name_de
 * @property string $last_name
 * @property string $last_name_en
 * @property string $last_name_de
 * @property string $position
 * @property string $position_en
 * @property string $position_de
 * @property string $certificate
 * @property string $short_info
 * @property string $short_info_en
 * @property string $short_info_de
 * @property string $full_info
 * @property string $full_info_en
 * @property string $full_info_de
 * @property string $password_hash
 * @property string $email
 * @property string $auth_key
 * @property string $access_token
 * @property string $oauth_client
 * @property string $oauth_client_user_id
 * @property string $publicIdentity
 * @property string $photo_base_url
 * @property string $photo_path
 * @property integer $status
 * @property integer $display
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $logged_at
 * @property string $password write-only password
 *
 * @property \common\models\UserProfile $userProfile
 * @property \common\models\UserSocialNetwork[] $userSocialNetworks
 */
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_NOT_ACTIVE = 1;
    const STATUS_ACTIVE = 2;
    const STATUS_DELETED = 3;

    const ROLE_USER = 'user';
    const ROLE_MANAGER = 'manager';
    const ROLE_ADMINISTRATOR = 'administrator';
    const ROLE_EDITOR = 'editor';
    const ROLE_AUTHOR = 'author';
    const ROLE_TRANSLATOR = 'translator';

    const EVENT_AFTER_SIGNUP = 'afterSignup';
    const EVENT_AFTER_LOGIN = 'afterLogin';

    const DISPLAY_FALSE = 0;
    const DISPLAY_TRUE = 1;

    public $photo;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::find()
            ->active()
            ->andWhere(['id' => $id])
            ->one();
    }

    /**
     * @return UserQuery
     */
    public static function find()
    {
        return new UserQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::find()
            ->active()
            ->andWhere(['access_token' => $token])
            ->one();
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return User|array|null
     */
    public static function findByUsername($username)
    {
        return static::find()
            ->active()
            ->andWhere(['username' => $username])
            ->one();
    }

    /**
     * Finds user by username or email
     *
     * @param string $login
     * @return User|array|null
     */
    public static function findByLogin($login)
    {
        return static::find()
            ->active()
            ->andWhere(['or', ['username' => $login], ['email' => $login]])
            ->one();
    }


    /**
     * Finds user by username or email
     *
     * @param string $login
     * @return User|array|null
     */
    public static function findBySlug($slug)
    {
        return static::find()
            ->active()
            ->andWhere(['slug' => $slug])
            ->one();
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::class,
            'auth_key' => [
                'class' => AttributeBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => 'auth_key'
                ],
                'value' => Yii::$app->getSecurity()->generateRandomString()
            ],
            'access_token' => [
                'class' => AttributeBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => 'access_token'
                ],
                'value' => function () {
                    return Yii::$app->getSecurity()->generateRandomString(40);
                }
            ],
            [
                'class' => UploadBehavior::class,
                'attribute' => 'photo',
                'pathAttribute' => 'photo_path',
                'baseUrlAttribute' => 'photo_base_url',
            ],

           [
                'class' => ProfileSluggableBehavior::class,
                'attribute' => 'first_name',
                'attributes' => ['first_name', 'last_name'],
                'slugAttribute' => 'slug',
                'ensureUnique' => true,
            ],
        ];
    }

    /**
     * @return array
     */
    public function scenarios()
    {
        return ArrayHelper::merge(
            parent::scenarios(),
            [
                'oauth_create' => [
                    'oauth_client', 'oauth_client_user_id', 'email', 'username', '!status'
                ]
            ]
        );
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'email'], 'unique'],
            ['status', 'default', 'value' => self::STATUS_NOT_ACTIVE],
            ['display', 'default', 'value' => self::DISPLAY_FALSE],
            ['status', 'in', 'range' => array_keys(self::statuses())],
            ['display', 'in', 'range' => array_keys(self::displayStatuses())],
            [['username'], 'filter', 'filter' => '\yii\helpers\Html::encode'],
            [['photo_base_url', 'photo_path'], 'string', 'max' => 1024],
            [[
                'first_name', 'first_name_en', 'first_name_de',
                'last_name', 'last_name_en', 'last_name_de',
                'position', 'position_en', 'position_de',
                'certificate', 'slug'], 'string', 'max' => 255],
            [[
                'short_info', 'short_info_en', 'short_info_de',
                'full_info',  'full_info_en',  'full_info_de',

            ], 'string'],
            [['photo'], 'safe'],
        ];
    }

    /**
     * Returns user statuses list
     * @return array|mixed
     */
    public static function statuses()
    {
        return [
            self::STATUS_NOT_ACTIVE => Yii::t('common', 'Not Active'),
            self::STATUS_ACTIVE => Yii::t('common', 'Active'),
            self::STATUS_DELETED => Yii::t('common', 'Deleted')
        ];
    }

    public static function displayStatuses()
    {
        return [
            self::DISPLAY_FALSE => Yii::t('common', 'Don\'t display'),
            self::DISPLAY_TRUE => Yii::t('common', 'Display'),
        ];
    }

    public static function roles()
    {
        return [
            self::ROLE_ADMINISTRATOR => Yii::t('common', 'Administrator'),
            self::ROLE_AUTHOR => Yii::t('common', 'Author'),
            self::ROLE_EDITOR => Yii::t('common', 'Editor'),
            self::ROLE_TRANSLATOR => Yii::t('common', 'Translator'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'username' => Yii::t('common', 'Username'),
            'email' => Yii::t('common', 'E-mail'),
            'status' => Yii::t('common', 'Status'),
            'access_token' => Yii::t('common', 'API access token'),
            'created_at' => Yii::t('common', 'Created at'),
            'updated_at' => Yii::t('common', 'Updated at'),
            'logged_at' => Yii::t('common', 'Last login'),
            'photo_base_url' => Yii::t('common', 'Photo Base Url'),
            'photo_path' => Yii::t('common', 'Photo Path'),
            'first_name' => Yii::t('common', 'First Name'),
            'last_name' => Yii::t('common', 'Last Name'),
            'position' => Yii::t('common', 'Position'),
            'certificate' => Yii::t('common', 'Certificate'),
            'slug' => Yii::t('common', 'Slug'),
            'short_info' => Yii::t('common', 'Short Info'),
            'full_info' => Yii::t('common', 'Full Info'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserProfile()
    {
        return $this->hasOne(UserProfile::class, ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserSocialNetworks()
    {
        return $this->hasMany(UserSocialNetwork::className(), ['user_id' => 'id']);
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->getSecurity()->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->getSecurity()->generatePasswordHash($password);
    }

    /**
     * Creates user profile and application event
     * @param array $profileData
     */
    public function afterSignup(array $profileData = [])
    {
        $this->refresh();
        Yii::$app->commandBus->handle(new AddToTimelineCommand([
            'category' => 'user',
            'event' => 'signup',
            'data' => [
                'public_identity' => $this->getPublicIdentity(),
                'user_id' => $this->getId(),
                'created_at' => $this->created_at
            ]
        ]));
        $profile = new UserProfile();
        $profile->locale = Yii::$app->language;
        $profile->load($profileData, '');
        $this->link('userProfile', $profile);
        $this->trigger(self::EVENT_AFTER_SIGNUP);
        // Default role
       // $auth = Yii::$app->authManager;
       // $auth->assign($auth->getRole(User::ROLE_USER), $this->getId());
    }

    /**
     * @return string
     */
    public function getPublicIdentity()
    {
        if ($this->userProfile && $this->userProfile->getFullname()) {
            return $this->userProfile->getFullname();
        }
        if ($this->username) {
            return $this->username;
        }
        return $this->email;
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }


    /**
     * @inheritdoc
     */
    public function getFullName($lang = null)
    {
        if ($lang == 'en' || $lang == 'de') {
            $first_name = "first_name_{$lang}";
            $last_name = "last_name_{$lang}";
            return $this->{$first_name} . ' ' . $this->{$last_name};
        } else {
            return $this->first_name . ' ' . $this->last_name;
        }

    }

    public function getPosition($lang = null)
    {
        if ($lang == 'en' || $lang == 'de') {
            $position = "position_{$lang}";
            return $this->{$position};
        } else {
            return $this->position;
        }
    }

    public function getInfo($lang = null, $size = 'short')
    {
        $attr = "{$size}_info";
        if ($lang == 'en' || $lang == 'de') {
            $info = "{$attr}_{$lang}";
            return $this->{$info};
        } else {
            return $this->{$attr};
        }
    }

}
