<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\InfoSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="info-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'tel') ?>

    <?= $form->field($model, 'creattime') ?>

    <?= $form->field($model, 'provinceid') ?>

    <?php // echo $form->field($model, 'cityid') ?>

    <?php // echo $form->field($model, 'distinctid') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
