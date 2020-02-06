<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\grid\GridView;
use kartik\datetime\DateTimePicker;
use \app\models\Apples;

?>

<?php Pjax::begin(); ?>
<p>
    <?= Html::a('Создать...', ['create'], ['class' => 'btn btn-success']) ?>
    <?= Html::a('Генерировать Яблоки', ['apples/generate'], ['title' => 'Рандомно создаем 30 яблок' ,'class' => 'btn btn-primary']) ?>
    <?= Html::a('Потрясти дерево', ['apples/shake-tree', 'data-pjax' => 1], ['title' => 'Если потрясти дерево, несколько яблок упадут на землю','class' => 'btn btn-warning']) ?>
    <?= Html::a('Удалить все Яблоки', ['apples/delete-all'], ['class' => 'btn btn-danger']) ?>
</p>

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
                'eat' => function ($url, $model, $key) {
                    return Html::a( 'Кушать', ['apples/eat', 'id' => $model->id], [
                        'id' => 'activity-eat-link',
                        'title' => 'Кушать поднятое яблоко',
                        'data-toggle' => 'modal',
                        'data-target' => '#modalvote',
                        'data-id' => $key,
                        'data-pjax' => '1'
                    ]);
                },
                'up' => function ($url, $model) {
                    return Html::a( 'Поднять', ['apples/up', 'id' => $model->id], [
                            'title' => 'Поднять упавшее яблоко',
                            'data-pjax' => '1'
                    ]);
                },
                'delete' => function ($url, $model, $key)
                    {
                         return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
                                'title' => 'Удалить',
                                'data-confirm' => Yii::t('yii', 'Вы действительно хотите удалить это яблоко?'),
                                'data-pjax' => '1'
                      ]);
                    }
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
            'template' => '{eat} {up} {view} {delete}',
        ],
    ],
]);?>
<?php Pjax::end(); ?>


<div class="modal remote fade" id="modalvote">
    <div class="modal-dialog">
        <div class="modal-content loader-lg"></div>
    </div>
</div>
