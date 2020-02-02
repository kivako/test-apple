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

    private function renderGrid(){
        $searchModel = new ApplesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->renderPartial('_grid', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    public function actionSnakeTree(){
        if (Yii::$app->request->isAjax) {
            //Ищем яблоки на дереве и рандомно роняем их
            $apples_on_tree  = Apples::findAll([
                    'status' =>  Apples::STATUS_ON_TREE,
                ]);

            //TODO Не доделано

            return $this->renderGrid();
        }
    }

    public function actionGenerate(){
        if (Yii::$app->request->isAjax) {
            for ($i = 0; $i < 30; $i++)
                Apples::createByRandom()->save();
            return $this->renderGrid();
        }
    }

    public function actionDeleteAll(){
        if (Yii::$app->request->isAjax) {
            Apples::deleteAll();
            return $this->renderGrid();
        }

    }

}
