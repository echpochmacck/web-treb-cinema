<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Task;

/**
 * FirstSearch represents the model behind the search form of `app\models\Task`.
 */
class FourthSearch extends Task
{

    public $job_title;
    public $titul;
    public $name;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'worker_id', 'job_id'], 'integer'],
            [['order_date', 'labor', 'real_date_end', 'plan_date_end'], 'safe'],
            [['job_title', 'name', 'titul'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Task::find()
            ->select([
                'job.title as job_title',
                'worker.full_name as name',
                'worker.titul as titul',

            ])
            ->innerJoin('job', 'job.id = task.job_id')
            ->innerJoin('worker', 'worker.id = task.worker_id')
            ->where(['job.title' => 'проект Луна']);
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'order_date' => $this->order_date,
            'real_date_end' => $this->real_date_end,
            'plan_date_end' => $this->plan_date_end,
            'worker_id' => $this->worker_id,
            'job_id' => $this->job_id,
        ]);

        $query->andFilterWhere(['like', 'worker.full_name', $this->name])
            ->andFilterWhere(['like', 'job.title', $this->job_title])
            ->andFilterWhere(['like', 'worker.titul', $this->titul])


        ;


        return $dataProvider;
    }


    public static function makeQuery()
    {
        return Task::find()
            ->select([
                'job.title as job_title',
                'worker.full_name as name',
                'worker.titul as titul',

            ])
            ->innerJoin('job', 'job.id = task.job_id')
            ->innerJoin('worker', 'worker.id = task.worker_id')
            ->where(['job.title' => 'проект Луна'])
            ->asArray()
            ->all();
    }
}
