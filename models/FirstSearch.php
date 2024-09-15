<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Task;

/**
 * FirstSearch represents the model behind the search form of `app\models\Task`.
 */
class FirstSearch extends Task
{

    public $job_title;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'worker_id', 'job_id'], 'integer'],
            [['order_date', 'labor', 'real_date_end', 'plan_date_end'], 'safe'],
            ['job_title', 'safe'],
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
                'real_date_end',
                'plan_date_end',

            ])
            ->innerJoin('job', 'job.id = task.job_id')
            ->where('real_date_end < plan_date_end')
            ->andwhere('real_date_end BETWEEN "2023-01-01" and "2023-12-31"');

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

        $query->andFilterWhere(['like', 'labor', $this->labor])
            ->andFilterWhere(['like', 'job.title', $this->job_title])

        ;


        return $dataProvider;
    }


    public static function makeQuery()
    {
        return Task::find()
            ->select([
                'job.title as job_title',
                'real_date_end',
                'plan_date_end',

            ])
            ->innerJoin('job', 'job.id = task.job_id')
            ->where('real_date_end < plan_date_end')
            ->andwhere('real_date_end BETWEEN "2023-01-01" and "2023-12-31"')
            ->asArray()
            ->all();
    }
}
