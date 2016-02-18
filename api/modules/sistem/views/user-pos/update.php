<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model crm\sistem\models\Userpos */

$this->title = 'Update Userpos: ' . ' ' . $model->POSITION_LOGIN;
$this->params['breadcrumbs'][] = ['label' => 'Userpos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->POSITION_LOGIN, 'url' => ['view', 'id' => $model->POSITION_LOGIN]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="userpos-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
