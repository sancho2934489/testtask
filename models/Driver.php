<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "driver".
 *
 * @property integer $id
 * @property string $fio
 * @property string $photo
 * @property string $birthday
 * @property integer $active
 * @property integer $bus_id
 *
 * @property Bus $bus
 */
class Driver extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'driver';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fio', 'birthday', 'active'], 'required'],
            [['birthday'], 'safe'],
            [['active', 'bus_id'], 'integer'],
            [['fio'], 'string', 'max' => 255],
            [['fio'], 'unique'],
            [['bus_id'], 'exist', 'skipOnError' => true, 'targetClass' => Bus::className(), 'targetAttribute' => ['bus_id' => 'id']],
            [['photo'], 'file', 'extensions' => 'jpg, gif, png']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'fio' => Yii::t('app', 'Fio'),
            'photo' => Yii::t('app', 'Photo'),
            'birthday' => Yii::t('app', 'Birthday'),
            'active' => Yii::t('app', 'Active'),
            'bus_id' => Yii::t('app', 'Bus ID'),
        ];
    }

    /**
     * Get model Bus by id driver
     * @param int $id
     * @return mixed
     */
    public static function getDriverBus(int $id)
    {
        return Bus::find()->innerJoin('driver','driver.bus_id = bus.id')->where(['driver.id' => $id])->one();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBus()
    {
        return $this->hasOne(Bus::className(), ['id' => 'bus_id']);
    }
}
