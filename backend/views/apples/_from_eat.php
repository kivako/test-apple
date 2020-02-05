<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
?>

<div class="row">
    <div class="col-lg-5">
        <?= $this->render('_progress',['percent' => $current_percent]) ?>

        <?php $form = ActiveForm::begin(['id' => 'eat-form']); ?>

        <?= $form->field($model, 'percent')->textInput(['autofocus' => true]) ?>

        <div class="form-group">
            <?= Html::submitButton('Откусить', ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>
