<?php
/**
 * Created by PhpStorm.
 * User: Nikolay
 * Date: 28.08.2019
 * Time: 15:49
 */
namespace api\controllers\demo;

use Yii;
use yii\rest\Controller;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Response;

use core\entities\Demo\DemoFinance;
use core\forms\Demo\FinanceForm;

class FinanceController extends Controller
{
    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            'corsFilter' => [
                'class' => \yii\filters\Cors::class,
                'cors' => [
                    'Origin' => ['*'],
                    'Access-Control-Request-Method' => ['POST', 'GET', 'PUT', 'DELETE', 'PATCH', 'OPTIONS'],
                    'Access-Control-Allow-Credentials' => true,
                    'Access-Control-Request-Headers' => ['*'],
                    'Access-Control-Max-Age' => 3600,
                    'Access-Control-Expose-Headers' => ['*'],
                    'Access-Control-Allow-Origin' => ['*'],
                ],
            ],
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => [],
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                    [
                        'actions' => ['get-data', 'save-data'],
                        'allow' => true,
                        'roles' => ['?', 'user'],
                    ]
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    //'create' => ['POST'],
                ],
            ],
            [
                'class' => 'yii\filters\ContentNegotiator',
                'formats' => [
                    'application/json' => Response::FORMAT_JSON,
                ],
                'languages' => [
                    'en', 'ru'
                ],
            ],
        ]);
    }


    public function actionGetData() {
        return DemoFinance::find()->all();
    }

    public function actionSaveData() {
        $data = Yii::$app->request->getBodyParams();
        $color = $data['color'];
        $email = $data['email'];
        $name = $data['name'];

        if (empty($data)) {
            throw new \DomainException('Данные не получены.');
        }

        $form = new FinanceForm();

        if (!$form->load(['email' => $email, 'name' => $name], '')) {
            throw new \DomainException('Данные формы не загружены.');
        }

        if (!$form->validate()) {
            throw new \DomainException('Данные не прошли валидацию.');
        }

        try {
            $finance = new DemoFinance();
            $finance->email = $email;
            $finance->name = $name;
            $finance->save();

            return $color%2 == 0 ? 0 : 1;
        } catch (\DomainException $e) {
            throw new \DomainException($e->getMessage());
        }
    }
}
