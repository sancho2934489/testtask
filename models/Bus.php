<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "bus".
 *
 * @property integer $id
 * @property string $mark
 * @property string $model
 * @property integer $year
 * @property integer $average_speed
 *
 * @property Driver[] $drivers
 */
class Bus extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'bus';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['mark'], 'required'],
            [['year', 'average_speed'], 'integer'],
            [['mark', 'model'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'mark' => Yii::t('app', 'Mark'),
            'model' => Yii::t('app', 'Model'),
            'year' => Yii::t('app', 'Year'),
            'average_speed' => Yii::t('app', 'Average Speed'),
        ];
    }

    /**
     * Get buses for select
     * @return array
     */
    public static function getAllBus():array
    {
        $arr = [];
        foreach (self::find()->all() as $bus):
            $arr[$bus->id] = $bus->mark . '(' . $bus->model . ')';
        endforeach;
        return $arr;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDrivers()
    {
        return $this->hasMany(Driver::className(), ['bus_id' => 'id']);
    }
}
