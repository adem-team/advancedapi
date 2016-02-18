<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model crm\sistem\models\Userprofile */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="userprofile-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'ID')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'NM_FIRST')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'NM_MIDDLE')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'NM_END')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'JOIN_DATE')->textInput() ?>

    <?= $form->field($model, 'RESIGN_DATE')->textInput() ?>

    <?= $form->field($model, 'STS')->textInput() ?>

    <?= $form->field($model, 'EMP_IMG')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'KD_DISTRIBUTOR')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'KD_SUBDIST')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'KD_OUTSRC')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'KTP')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ALAMAT')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ZIP')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'GENDER')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'TGL_LAHIR')->textInput() ?>

    <?= $form->field($model, 'EMAIL')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'TLP_HOME')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'HP')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'CORP_ID')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'CREATED_BY')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'CREATED_AT')->textInput() ?>

    <?= $form->field($model, 'UPDATED_BY')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'UPDATED_TIME')->textInput() ?>

    <?= $form->field($model, 'STATUS')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
