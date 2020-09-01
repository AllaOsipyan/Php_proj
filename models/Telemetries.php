<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "telemetries".
 *
 * @property int $id
 * @property string $name
 * @property string $value
 * @property string|null $time
 */
class Telemetries extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'telemetries';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'value'], 'required'],
            [['time'], 'safe'],
            [['name', 'value'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'value' => 'Value',
            'time' => 'Time',
        ];
    }
}
