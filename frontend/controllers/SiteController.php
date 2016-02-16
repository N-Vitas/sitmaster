<?php
namespace frontend\controllers;

use Yii;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use frontend\components\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index','contact','about','page','logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup','index'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['index','contact','about','page','logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
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

    public function actionIndex()
    {
        //$this->layout = 'landing';
        return $this->render('index');
    }

    public function actionPage()
    {
        $str2 = "123 Regulyar factory";
        $str3 = 'vitasd@mail.rusds';
        $income_str = 'фамилия имя отчество 
        фамилия и о 
        фамилия и.о.';
        $income_str2 = 'Nikonov Vitaliy Sergeevich Urubkova Tatyana Sergeevna';
        $html = '<TH>20.02<BR>05:30</TH>
            <TD class=l>Товар 1<BR>Товар 2</TD
            <TD><B>35</B></TD>
            <TD>
                <A href="http://ссылка/" id=sfsd32dfs onclick="return m(this)">26.92</A><BR>
                <A href="http://ссылка/" id=r3_3143svsfd onclick="return m(this)">27.05</A>
            </TD>
            <TD><B>270.5</B></TD>
        </TR>';
        $url = 'http://mries.kz/editor/em/Unlink.gif';

        $shab1  = '/[a-z]{1,20}/';
        $shab2  = '/[A-Za-z]{1,20}/';
        $shab3  = '/[^A-Za-z]{1,20}/';
        $shab4  = '/[0-9]*/';
        $shab5  = '/[Regulyar a-z]{1,20}/';
        $shab6  = '/[a-z]*[@]{1}[a-z]*[.][a-z]{2}/';
        $shab7  = '/\w*[@]{1}\w*[.]\w{2}/';
        $shab8  = '/\w*@{1}\w*.\w{2}/';
        $shab9  = '/[f][a-zA-Z0-9]*/';
        $shab10 = '/[\s][a-zA-Z0-9]*/';
        $shab11 = '/[\s][a-z]*/';
        $shab12 = '/([^\s]+)\s+([^\s.])[^\s.]*(?:\s|\.)([^\s.])[^\s.]*/'; 
        $shab13 = '/([^\s]+)\s+([^\s.])[^\s.]*(?:\s|\.)([^\s.])[^\s.]*/'; 
        $shab14 = '/(?<!<TD>)(?<=>)\d*.\d*(?!<\/B>)(?=<\/A>)/';
        $shab15 = '/(?<!\/\/)(?<=\/)\w*\.\w*/';

        preg_match_all($shab1,  $str2,$res);
        preg_match_all($shab2,  $str2,$res2);
        preg_match_all($shab3,  $str2,$res3);
        preg_match_all($shab4,  $str2,$res4);
        preg_match_all($shab5,  $str2,$res5);
        preg_match_all($shab6,  $str3,$res6);
        preg_match_all($shab7,  $str3,$res7);
        preg_match_all($shab8,  $str3,$res8);
        preg_match_all($shab9,  $str2,$res9);
        preg_match_all($shab10, $str2,$res10);
        preg_match_all($shab11, $str2,$res11);
        preg_match_all($shab12, $str2,$res12);
        preg_match_all($shab13, $income_str,$out_arr); 
        preg_match_all($shab13, $income_str2,$out_arr2); 
        preg_match_all($shab14, $html, $matches);
        preg_match_all($shab15, $url, $urlresult);
        //var_dump($urlresult); die;
        $array = [
            
            'Строчка'          => '<pre>'.$str2.'</pre>',
            'Строчка 2'        => '<pre>'.$str3.'</pre>',
            'Строчка 3'        => '<pre>'.$income_str2.'</pre>',
            'Путь картинки'        => '<pre>'.$url.'</pre>',
            'Код'              => '<pre>'.htmlspecialchars($html).'</pre>',
            'Шаблон '.htmlspecialchars($shab1)    => $res[0][0],
            'Шаблон '.htmlspecialchars($shab2)    => $res2[0][0],
            'Шаблон '.htmlspecialchars($shab3)    => $res3[0][0],
            'Шаблон '.htmlspecialchars($shab4)    => $res4[0][0],
            'Шаблон '.htmlspecialchars($shab5)    => $res5[0][0],
            'Шаблон '.htmlspecialchars($shab6)    => $res6[0][0],
            'Шаблон '.htmlspecialchars($shab7)    => $res7[0][0],
            'Шаблон '.htmlspecialchars($shab8)    => $res8[0][0],
            'Шаблон '.htmlspecialchars($shab9)    => $res9[0][0],
            'Шаблон '.htmlspecialchars($shab10)   => $res10[0][0],
            'Шаблон '.htmlspecialchars($shab11)   => $res11[0][0],
            'Шаблон '.htmlspecialchars($shab12)   => $res12[0][0],
            'Шаблон '.htmlspecialchars($shab13)   => $out_arr[0][0].' '.
                                                     $out_arr[1][0].' '.
                                                     $out_arr[2][0].' '.
                                                     $out_arr[3][0],
            'Шаблон 2 '.htmlspecialchars($shab13) => $out_arr2[1][0].' '.
                                                     $out_arr2[2][0].' '.
                                                     $out_arr2[3][0].' '.
                                                     $out_arr2[1][1].' '.
                                                     $out_arr2[2][1].' '.
                                                     $out_arr2[3][1].' ',
            'Шаблон '.htmlspecialchars($shab14)   => $matches[0][0].' '.
                                                     $matches[0][1],
            'Шаблон '.htmlspecialchars($shab15)   => $urlresult[0][0],
        ];
        return $this->render('page',['models' => $array]);
    }

    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending email.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    public function actionAbout($id=0)
    {
        return $this->render('about',['id'=>$id]);
    }

    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->getSession()->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->getSession()->setFlash('error', 'Sorry, we are unable to reset password for email provided.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->getSession()->setFlash('success', 'New password was saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }
}
