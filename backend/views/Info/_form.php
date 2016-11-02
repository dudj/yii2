<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use backend\models\Region;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $model backend\models\Info */
/* @var $form yii\widgets\ActiveForm */
$cityUrl = Url::to(['info/cities']);
$this->registerJS(<<<JS
$("#info-provinceid").on('change',function(){
    var _this = $(this);
    var _city = $("#info-cityid");
    $.ajax({
        url: "${cityUrl}",
        data: {provinceId: _this.val()},
        success: function(html) {
            _city.html(html);
        }
    })
});
JS
);
$distinctUrl = Url::to(['info/distincts']);
//获取区域信息
$this->registerJS(<<<JS
$("#info-cityid").on('change',function(){
    var _this = $(this);
    var _distinct = $("#info-distinctid");
    $.ajax({
        url: "${distinctUrl}",
        data: {cityId: _this.val()},
        success: function(html) {
            _distinct.html(html);
        }
    })
});
JS
)
?>

<div class="info-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tel')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'creattime')->textInput() ?>

    <?= $form->field($model, 'provinceid')
        ->dropDownList(ArrayHelper::map(Region::findAllProvince(), 'region_id', 'region_name'), [
            'prompt' => '请选择省份'
        ]) ?>
    <?= $form->field($model, 'cityid')
        ->dropDownList(ArrayHelper::map(Region::findAllCities($model->provinceid), 'region_id', 'region_name'), [
            'prompt' => '请选择城市'
        ]) ?>
    <?= $form->field($model, 'distinctid')
        ->dropDownList(ArrayHelper::map(Region::findAllDistincts($model->cityid), 'region_id', 'region_name'), [
            'prompt' => '请选择区域'
        ]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t("common", "create") : Yii::t("common", "update"), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
