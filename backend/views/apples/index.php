<?php
/* @var $this yii\web\View */

use yii\helpers\Url;
use yii\helpers\Html;

?>
<script>
    function onClickGenApples() {
        $.ajax({
            url: '<?= Url::to(['generate'])?>',
            type: 'post',
            data: {
                searchname: $("#searchname").val() ,
                searchby:$("#searchby").val() ,
                _csrf : '<?= Yii::$app->getRequest()->getCsrfToken() ?>'

            },
            success: function (data) {
                $('#response').html(data);
                console.log(data);
            }
        });
    }

    function onClickDelAllApples() {
        $.ajax({
            url: '<?= Url::to(['delete-all'])?>',
            type: 'post',
            data: {
                searchname: $("#searchname").val() ,
                searchby:$("#searchby").val() ,
                _csrf : '<?= Yii::$app->getRequest()->getCsrfToken() ?>'

            },
            success: function (data) {
                $('#response').html(data);
                console.log(data);
            }
        });
    }

    function onClickShakeTree() {
        $.ajax({
            url: '<?= Url::to(['shake-tree'])?>',
            type: 'post',
            data: {
                searchname: $("#searchname").val() ,
                searchby:$("#searchby").val() ,
                _csrf : '<?= Yii::$app->getRequest()->getCsrfToken() ?>'

            },
            success: function (data) {
                $('#response').html(data);
                console.log(data);
            }
        });
    }
</script>

<p>
    <?= Html::a('Создать...', ['create'], ['class' => 'btn btn-success']) ?>
    <?= Html::a('Генерировать Яблоки', '#', ['onClick' => 'onClickGenApples()', 'class' => 'btn btn-primary']) ?>
    <?= Html::a('Потрясти дерево', '#', ['onClick' => 'onClickShakeTree()', 'class' => 'btn btn-warning']) ?>
    <?= Html::a('Удалить все Яблоки', '#', ['onClick' => 'onClickDelAllApples()', 'class' => 'btn btn-danger']) ?>
</p>

<div id="response">
    <?= $this->render('_grid',['dataProvider' => $dataProvider, 'searchModel' => $searchModel]) ?>
</div>


