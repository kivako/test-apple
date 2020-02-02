<?php
use yii\grid\GridView;
use kartik\datetime\DateTimePicker;
use \app\models\Apples;
use yii\helpers\Html;
?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        [
            'attribute' => 'color',
            'filter' => Apples::COLORS,
            'contentOptions' => function ($data) {
                return ['style' => 'background-color:'.$data->color];
            },
            'value' => function ($data) {
                return  Apples::COLORS[$data->color];
            },
        ],
        [
            'attribute' => 'date_create',
            //'format' => ['date', 'HH:mm:ss dd.MM.Y'],
            'filter' => DateTimePicker::widget([
                'model'=>$searchModel,
                'attribute'=>'date_create',
                'language' => 'ru',
                'type' => DateTimePicker::TYPE_COMPONENT_APPEND,
                'pluginOptions' => [
                    'format' => 'yyyy-mm-dd hh',
                    'autoclose' => true,
                    'minView' => 1,
                    //'startDate' => '01-Mar-2014 12:00 AM',
                    'todayHighlight' => true
                ]
            ]),
        ],
        [
            'attribute' => 'body_percent',
            'format' => 'html',
            'value' => function ($data) {
                return $this->render('_progress',['percent' => $data->body_percent]);
            }

        ],
        [
            'attribute' => 'status',
            'filter' => Apples::STATUSES,
            'value' => function ($data) {
                return  Apples::STATUSES[$data->status];
            },
        ],
        ['class' => 'yii\grid\ActionColumn',
            'header' => 'Действия',
            'buttons' => [
                'eat'=>function ($url, $model) {
                    return \yii\helpers\Html::a( 'Кушать',
                        ['addr-clients/index', 'client_id' => $model->id],
                        ['title' => Yii::t('yii', 'Адреса доставки'), 'data-pjax' => '0']);
                },
                'up'=>function ($url, $model) {
                    return \yii\helpers\Html::a( 'Поднять',
                        ['addr-clients/index', 'client_id' => $model->id],
                        ['title' => Yii::t('yii', 'Адреса доставки'), 'data-pjax' => '0']);
                },
            ],
            'visibleButtons'=>[
                            //Отображаем кнопку "есть" только если яблоко поднято с земли
                            'eat'=> function($data){
                                  return $data->status == Apples::STATUS_ON_UP;
                             },
                            //Отображаем кнопку "поднять" только если яблоко лежит на земле
                            'up'=> function($data){
                                return $data->status == Apples::STATUS_ON_GROUND;
                            },
                        ],
            'template' => '{eat} {up} {view} {update} {delete}',
        ],
    ],
]);?>
