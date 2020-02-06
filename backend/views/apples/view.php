<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\Apples;

$this->params['breadcrumbs'][] = ['label' => 'Яблоки', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Яблоко( Цвет:'.Apples::COLORS[$model->color].' Статус:'.Apples::STATUSES[$model->status].')';

\yii\web\YiiAsset::register($this);
?>
<div class="stocks-view">

    <p>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы уверены что хотите удалить?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'date_create',

            [
                'attribute' => 'color',
                'contentOptions' => ['style' => 'background-color:'.$model->color],
                'value' => Apples::COLORS[$model->color],
            ],
            [
                'attribute' =>  'body_percent',
                'format' => 'html',
                'value' => $this->render('_progress',['percent' => $model->body_percent]),
                'options' => ['style' => 'width:129px;'],
            ],
            [
                'attribute' => 'status',
                'value' => Apples::STATUSES[$model->status],
            ],
            'date_fall',
            'date_up',
        ],
    ]) ?>

</div>
