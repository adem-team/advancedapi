<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model crm\sistem\models\Userpos */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="userpos-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'POSITION_NM')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
