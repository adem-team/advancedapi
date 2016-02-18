<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model crm\sistem\models\Userprofile */

$this->title = 'Update Userprofile: ' . ' ' . $model->ID;
$this->params['breadcrumbs'][] = ['label' => 'Userprofiles', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->ID, 'url' => ['view', 'id' => $model->ID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="userprofile-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
