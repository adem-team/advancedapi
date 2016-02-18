<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model api\modules\master\models\KabSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="kab-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'CITY_ID') ?>

    <?= $form->field($model, 'PROVINCE_ID') ?>

    <?= $form->field($model, 'PROVINCE') ?>

    <?= $form->field($model, 'TYPE') ?>

    <?= $form->field($model, 'CITY_NAME') ?>

    <?php // echo $form->field($model, 'POSTAL_CODE') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
