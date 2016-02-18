<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model api\modules\master\models\Kabupaten */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="kabupaten-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'CITY_ID')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'PROVINCE_ID')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'PROVINCE')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'CITY_NAME')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
