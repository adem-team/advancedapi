<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model crm\sistem\models\Userpos */

$this->title = 'Create Userpos';
$this->params['breadcrumbs'][] = ['label' => 'Userpos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="userpos-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
