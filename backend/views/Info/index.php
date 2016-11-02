<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\InfoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t("common", "info");
$this->params['breadcrumbs'][] = Yii::t("common", "info index");
?>
<div class="info-index">

    <h1><?= Html::encode(Yii::t("common", "info index")) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t("common", "info create"), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'tel',
            'creattime:datetime',
            'provinceid',
            // 'cityid',
            // 'distinctid',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
