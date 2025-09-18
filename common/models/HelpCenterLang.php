<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%help_center_lang}}".
 *
 * @property int $id
 * @property string $language
 * @property int $help_center_id
 * @property string $name
 * @property string $description
 * @property string $contacts
 *
 * @property HelpCenter $helpCenter
 */
class HelpCenterLang extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%help_center_lang}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['help_center_id'], 'integer'],
            [['description', 'contacts'], 'string'],
            [['language'], 'string', 'max' => 64],
            [['name'], 'string', 'max' => 255],
            [['help_center_id'], 'exist', 'skipOnError' => true, 'targetClass' => HelpCenter::className(), 'targetAttribute' => ['help_center_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'language' => Yii::t('common', 'Language'),
            'help_center_id' => Yii::t('common', 'Help Center ID'),
            'name' => Yii::t('common', 'Name'),
            'description' => Yii::t('common', 'Description'),
            'contacts' => Yii::t('common', 'Contacts'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHelpCenter()
    {
        return $this->hasOne(HelpCenter::className(), ['id' => 'help_center_id']);
    }
}
