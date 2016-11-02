<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Info */

$this->title = Yii::t("common", "info create");
$this->params['breadcrumbs'][] = ['label' => Yii::t("common", "info"), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="info-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
