<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\FirstSearch;
use app\models\FourthSearch;
use app\models\SecondSearch;
use app\models\ThirdSearch;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index-blog');
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        if (Yii::$app->request->isPost) {
            if (Yii::$app->session->has('check')) {
                if (Yii::$app->session->get('check') < 3) {
                    Yii::$app->session->set('check', Yii::$app->session->get('check') + 1);
                } else {
                    Yii::$app->session->setFlash('error', 'Кончились попытки входа');
                    return $this->goHome();
                }
            } else {
                Yii::$app->session->set('check', 1);
            }
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionRegister()
    {
        $model = new \app\models\User();

        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                $model->register();
                Yii::$app->session->setFlash('success', 'Вы успешно зарегстрирвоались в систему и зашли в нее');
                Yii::$app->user->login($model);
                return $this->goHome();
            }
        }

        return $this->render('register', [
            'model' => $model,
        ]);
    }


    public function actionFirst()
    {
        $searchModel = new FirstSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('first', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionExportFirst()
    {
        $data = FirstSearch::makeQuery();
        $str = 'Название работы;Реальная дата Окончания;Планируемая дата окончания' . "\r\n";

        foreach ($data as $row) {
            $str .= $row['job_title'] . ';'
                . $row['real_date_end'] . ';'
                . $row['plan_date_end'] . "\r\n";
        }
        $str = iconv('UTF-8', 'windows-1251', $str);
        Yii::$app->response->sendContentAsFile($str, 'даты.csv')->send();
    }

    public function actionSecond()
    {
        $searchModel = new SecondSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('second', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionExportSecond()
    {
        $data = SecondSearch::makeQuery();
        $str = 'Сотрудник;Количество работ' . "\r\n";

        foreach ($data as $row) {
            $str .= $row['name'] . ';'
                . $row['quantity'] . "\r\n";
        }
        $str = iconv('UTF-8', 'windows-1251', $str);
        Yii::$app->response->sendContentAsFile($str, 'весна.csv')->send();
    }


    public function actionThird()
    {
        $searchModel = new ThirdSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('third', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,

        ]);
    }

    public function actionExportThird()
    {
        $data = ThirdSearch::makeQuery();
        $str = 'Сотрудник;Количество работ' . "\r\n";

        foreach ($data as $row) {
            $str .= $row['name'] . ';'
                . $row['quantity'] . "\r\n";
        }
        $str = iconv('UTF-8', 'windows-1251', $str);
        Yii::$app->response->sendContentAsFile($str, 'Max.csv')->send();
    }

    public function actionFourth()
    {
        $searchModel = new FourthSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('fourth', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,

        ]);
    }

    public function actionExportFourth()
    {
        $data = FourthSearch::makeQuery();
        $str = 'Сотрудник;Доолжность;Проект'  . "\r\n";

        foreach ($data as $row) {
            $str .= $row['name'] . ';'
                . $row['titul'] . ';'

                . $row['job_title'] . "\r\n";
        }
        $str = iconv('UTF-8', 'windows-1251', $str);
        Yii::$app->response->sendContentAsFile($str, 'Max.csv')->send();
    }
}
