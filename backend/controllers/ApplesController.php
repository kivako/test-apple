<?php

namespace backend\controllers;


use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Response;
use app\models\Apples;
use app\models\ApplesSearch;
use backend\models\ApplesEatForm;
use yii\base\Exception;


class ApplesController extends \yii\web\Controller
{

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }


    public function actionIndex()
    {
        $searchModel = new ApplesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionShakeTree(){
        if (Yii::$app->request->isAjax) {
            //Ищем яблоки на дереве и рандомно роняем их
            $apples_on_tree  = Apples::findAll([
                    'status' =>  Apples::STATUS_ON_TREE,
                ]);

            foreach ($apples_on_tree as $item){
                if(rand(0, 1)){
                    $item->date_fall = date('Y-m-d H:i:s', strtotime("now"));
                    $item->status = Apples::STATUS_ON_GROUND;
                    $item->save();
                }
            }

            return $this->actionIndex();
        }
    }

    public function actionGenerate(){
        if (Yii::$app->request->isAjax) {
            for ($i = 0; $i < 30; $i++)
                Apples::createByRandom()->save();
        }

        return $this->actionIndex();
    }

    public function actionDeleteAll(){
        if (Yii::$app->request->isAjax) {
            Apples::deleteAll();
        }
        return $this->actionIndex();
    }

    public function actionDelete($id){
        if ($apple = Apples::findOne($id)) $apple->delete();
        return $this->actionIndex();
    }

    public function actionUp($id){
        if ($apple = Apples::findOne($id)){
            $apple->date_up = date('Y-m-d H:i:s');
            $apple->status = Apples::STATUS_ON_UP;
            $apple->save();
        }
        return $this->actionIndex();
    }

    public function actionEat($id){

        $model = new ApplesEatForm();

        if (!$apple = Apples::findOne($id))
            throw new Exception('Apples ID not found');

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
                    $apple->body_percent -= $model->percent;
                    $apple->save();
            //return $this->actionIndex();
            return $this->redirect(['index']);
        } else {
            return $this->renderPartial('_from_eat', ['model' => $model, 'current_percent' => $apple->body_percent]);
        }
    }
}
