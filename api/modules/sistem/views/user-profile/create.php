<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model crm\sistem\models\Userprofile */

$this->title = 'Create Userprofile';
$this->params['breadcrumbs'][] = ['label' => 'Userprofiles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="userprofile-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
