<?php

namespace backend\controllers;


use Yii;
use yii\web\Response;
use app\models\Apples;
use app\models\ApplesSearch;


class ApplesController extends \yii\web\Controller
{
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

            return $this->redirect(['index']);
        }
    }

    public function actionGenerate(){
        if (Yii::$app->request->isAjax) {
            for ($i = 0; $i < 30; $i++)
                Apples::createByRandom()->save();
        }

        return $this->redirect(['index']);
    }

    public function actionDeleteAll(){
        if (Yii::$app->request->isAjax) {
            Apples::deleteAll();
        }
        return $this->redirect(['index']);
    }

    public function actionDelete($id){
        if ($apple = Apples::findOne($id)) $apple->delete();
        return $this->redirect(['index']);
    }

    public function actionUp($id){
        if ($apple = Apples::findOne($id)){
            $apple->date_up = date('Y-m-d H:i:s');
            $apple->status = Apples::STATUS_ON_UP;
            $apple->save();
        }
        return $this->redirect(['index']);
    }

    public function actionEat($id, $percent){
        if ($apple = Apples::findOne($id)){
            $apple->body_percent -= $percent;
            $apple->save();
        }
        return $this->redirect(['index']);
    }
}
