<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "task".
 *
 * @property int $id
 * @property string $order_date
 * @property string $labor
 * @property string $real_date_end
 * @property string $plan_date_end
 * @property int $worker_id
 * @property int $job_id
 *
 * @property Job $job
 * @property Worker $worker
 */
class Task extends \yii\db\ActiveRecord
{
    public $job_title;
    public $quantity;
    public $name;
    public $titul;



    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'task';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['order_date', 'labor', 'real_date_end', 'plan_date_end', 'worker_id', 'job_id'], 'required'],
            [['order_date', 'real_date_end', 'plan_date_end'], 'safe'],
            [['worker_id', 'job_id'], 'integer'],
            [['labor'], 'string', 'max' => 255],
            [['job_id'], 'exist', 'skipOnError' => true, 'targetClass' => Job::class, 'targetAttribute' => ['job_id' => 'id']],
            [['worker_id'], 'exist', 'skipOnError' => true, 'targetClass' => Worker::class, 'targetAttribute' => ['worker_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'order_date' => 'Дата назначения',
            'labor' => 'Labor',
            'real_date_end' => 'Реальная Дата окончания',
            'plan_date_end' => 'Запланипованная дата конца',
            'worker_id' => 'Worker ID',
            'job_id' => 'Job ID',
            'job_title' => 'Название работы',
            'name' => 'Имя сотрудника',
            'titul' => 'Должность'
        ];
    }

    /**
     * Gets query for [[Job]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getJob()
    {
        return $this->hasOne(Job::class, ['id' => 'job_id']);
    }

    /**
     * Gets query for [[Worker]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getWorker()
    {
        return $this->hasOne(Worker::class, ['id' => 'worker_id']);
    }
}
