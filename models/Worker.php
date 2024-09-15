<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "worker".
 *
 * @property int $id
 * @property string $titul
 * @property int $number
 * @property string $full_name
 *
 * @property Task[] $tasks
 */
class Worker extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'worker';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['titul', 'number', 'full_name'], 'required'],
            [['number'], 'integer'],
            [['titul', 'full name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'titul' => 'Titul',
            'number' => 'Number',
            'full_name' => 'Full Name',
        ];
    }

    /**
     * Gets query for [[Tasks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTasks()
    {
        return $this->hasMany(Task::class, ['worker_id' => 'id']);
    }
}
