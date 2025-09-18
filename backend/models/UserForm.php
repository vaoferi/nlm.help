<?php

namespace backend\models;

use common\models\User;
use Yii;
use yii\base\Exception;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use common\behaviors\ProfileSluggableBehavior;

/**
 * Create user form
 */
class UserForm extends Model
{
    public $username;
    public $first_name;
    public $first_name_en;
    public $first_name_de;
    public $last_name;
    public $last_name_en;
    public $last_name_de;
    public $position;
    public $position_en;
    public $position_de;
    public $certificate;
    public $short_info;
    public $short_info_en;
    public $short_info_de;
    public $full_info;
    public $full_info_en;
    public $full_info_de;
    public $slug;


    public $email;
    public $password;
    public $status;
    public $display;
    public $photo_base_url;
    public $photo_path;
    public $photo;
    public $roles;

    private $model;


    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
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
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => User::class, 'filter' => function ($query) {
                if (!$this->getModel()->isNewRecord) {
                    $query->andWhere(['not', ['id' => $this->getModel()->id]]);
                }
            }],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'unique', 'targetClass' => User::class, 'filter' => function ($query) {
                if (!$this->getModel()->isNewRecord) {
                    $query->andWhere(['not', ['id' => $this->getModel()->id]]);
                }
            }],

            [['first_name', 'last_name'], 'filter', 'filter' => 'trim'],
            [[
                'first_name', 'first_name_en', 'first_name_de',
                'last_name', 'last_name_en', 'last_name_de',
                'position',  'position_en',  'position_de',
                'certificate', 'slug'], 'string', 'max' => 255],

            ['password', 'required', 'on' => 'create'],
            ['password', 'string', 'min' => 6],
            [[
                'short_info', 'short_info_en', 'short_info_de',
                'full_info', 'full_info_en', 'full_info_de',
            ], 'string'],

            [['status'], 'integer'],
            [['display'], 'integer'],
            [['photo_base_url', 'photo_path'], 'string', 'max' => 1024],
            [['photo'], 'required', 'when' => function ($model)  {
                return ($model->display == User::DISPLAY_TRUE);
            }, 'whenClient' => "function (attribute, value) {
                return $(\"#userform-display\").val() == 1;
            }"],
            [['roles'], 'each',
                'rule' => ['in', 'range' => array_keys(User::roles())]
            ],
        ];
    }

    /**
     * @return User
     */
    public function getModel()
    {
        if (!$this->model) {
            $this->model = new User();
        }
        return $this->model;
    }

    /**
     * @param User $model
     * @return mixed
     */
    public function setModel($model)
    {
        $this->username = $model->username;
        $this->email = $model->email;
        $this->status = $model->status;
        $this->display = $model->display;
        $this->photo = $model->photo;
        $this->certificate = $model->certificate;
        $this->slug = $model->slug;

        foreach (['ru', 'en', 'de'] as $lang) {
            if ($lang == 'ru') {
                $this->first_name = $model->first_name;
                $this->last_name = $model->last_name;
                $this->position = $model->position;
                $this->short_info = $model->short_info;
                $this->full_info = $model->full_info;
            } else {
                $first_name = "first_name_{$lang}";
                $last_name = "last_name_{$lang}";
                $position = "position_{$lang}";
                $short_info = "short_info_{$lang}";
                $full_info = "full_info_{$lang}";
                $this->{$first_name} = $model->{$first_name};
                $this->{$last_name} = $model->{$last_name};
                $this->{$position} = $model->{$position};
                $this->{$short_info} = $model->{$short_info};
                $this->{$full_info} = $model->{$full_info};
            }
        }

        $this->model = $model;
        $this->roles = ArrayHelper::getColumn(
            Yii::$app->authManager->getRolesByUser($model->getId()),
            'name'
        );
        return $this->model;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'username' => Yii::t('common', 'Username'),
            'email' => Yii::t('common', 'Email'),
            'status' => Yii::t('common', 'Status'),
            'display' => Yii::t('common', 'Display On The Site'),
            'password' => Yii::t('common', 'Password'),
            'photo' => Yii::t('common', 'Photo'),
            'roles' => Yii::t('common', 'Roles'),
            'first_name' => Yii::t('common', 'First Name'),
            'last_name' => Yii::t('common', 'Last Name'),
            'position' => Yii::t('common', 'Position'),
            'certificate' => Yii::t('common', 'Certificate'),
            'slug' => Yii::t('common', 'Slug'),
        ];
    }

    /**
     * Signs user up.
     * @return User|null the saved model or null if saving fails
     * @throws Exception
     */
    public function save()
    {
        if ($this->validate()) {
            $model = $this->getModel();
            $isNewRecord = $model->getIsNewRecord();
            $model->username = $this->username;
            $model->email = $this->email;
            $model->status = $this->status;
            $model->display = $this->display;
            $model->photo = $this->photo;


            foreach (['ru', 'en', 'de'] as $lang) {
                if ($lang == 'ru') {
                    $model->first_name = $this->first_name;
                    $model->last_name = $this->last_name;
                    $model->position = $this->position;
                    $model->short_info = $this->short_info;
                    $model->full_info = $this->full_info;
                } else {
                    $first_name = "first_name_{$lang}";
                    $last_name = "last_name_{$lang}";
                    $position = "position_{$lang}";
                    $short_info = "short_info_{$lang}";
                    $full_info = "full_info_{$lang}";
                    $model->{$first_name} = $this->{$first_name};
                    $model->{$last_name} = $this->{$last_name};
                    $model->{$position} = $this->{$position};
                    $model->{$short_info} = $this->{$short_info};
                    $model->{$full_info} = $this->{$full_info};
                }
            }

            $model->certificate = $this->certificate;
            $model->slug = $this->slug;


            if ($this->password) {
                $model->setPassword($this->password);
            }
            if (!$model->save()) {
                throw new Exception('Model not saved');
            }
            if ($isNewRecord) {
                $model->afterSignup();
            }
            $auth = Yii::$app->authManager;
            $auth->revokeAll($model->getId());

            if ($this->roles && is_array($this->roles)) {
                foreach ($this->roles as $role) {
                    $auth->assign($auth->getRole($role), $model->getId());
                }
            }

            return !$model->hasErrors();
        }
        return null;
    }
}
