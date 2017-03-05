<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model lukisongroup\efenbi\models\ItemFormula */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="item-formula-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'CREATE_BY')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'CREATE_AT')->textInput() ?>

    <?= $form->field($model, 'UPDATE_BY')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'UPDATE_AT')->textInput() ?>

    <?= $form->field($model, 'STATUS')->textInput() ?>

    <?= $form->field($model, 'TYPE')->textInput() ?>

    <?= $form->field($model, 'TYPE_NM')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ID_STORE')->textInput() ?>

    <?= $form->field($model, 'ID_ITEM')->textInput() ?>

    <?= $form->field($model, 'DISCOUNT_PESEN')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'DISCOUNT_WAKTU')->textInput() ?>

    <?= $form->field($model, 'DISCOUNT_HARI')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
