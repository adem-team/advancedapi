<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model api\modules\master\models\Kab */

$this->title = 'Create Kab';
$this->params['breadcrumbs'][] = ['label' => 'Kabs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="kab-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
