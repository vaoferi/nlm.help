<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "smi_lang".
 *
 * @property int $id
 * @property int $smi_id
 * @property string $language
 * @property string $preview
 *
 * @property Smi $smi
 */
class SmiLang extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%smi_lang}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['smi_id', 'language'], 'required'],
            [['smi_id'], 'integer'],
            [['preview'], 'string'],
            [['language'], 'string', 'max' => 2],
            [['smi_id'], 'exist', 'skipOnError' => true, 'targetClass' => Smi::className(), 'targetAttribute' => ['smi_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'smi_id' => Yii::t('common', 'Smi ID'),
            'language' => Yii::t('common', 'Language'),
            'preview' => Yii::t('common', 'Preview'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSmi()
    {
        return $this->hasOne(Smi::className(), ['id' => 'smi_id']);
    }
}
