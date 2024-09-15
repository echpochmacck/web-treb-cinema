<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "job".
 *
 * @property int $id
 * @property string $title
 * @property string $date_end
 * @property string $cypher
 * @property string $labor
 *
 * @property Task[] $tasks
 */
class Job extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'job';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'date_end', 'cypher', 'labor'], 'required'],
            [['date_end'], 'safe'],
            [['title', 'cypher', 'labor'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'date_end' => 'Date End',
            'cypher' => 'Cypher',
            'labor' => 'Labor',
        ];
    }

    /**
     * Gets query for [[Tasks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTasks()
    {
        return $this->hasMany(Task::class, ['job_id' => 'id']);
    }
}
