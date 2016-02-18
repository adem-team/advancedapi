<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model crm\sistem\models\Userprofile */

$this->title = $model->ID;
$this->params['breadcrumbs'][] = ['label' => 'Userprofiles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="userprofile-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->ID], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->ID], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'ID',
            'NM_FIRST',
            'NM_MIDDLE',
            'NM_END',
            'JOIN_DATE',
            'RESIGN_DATE',
            'STS',
            'EMP_IMG',
            'KD_DISTRIBUTOR',
            'KD_SUBDIST',
            'KD_OUTSRC',
            'KTP',
            'ALAMAT',
            'ZIP',
            'GENDER',
            'TGL_LAHIR',
            'EMAIL:email',
            'TLP_HOME',
            'HP',
            'CORP_ID',
            'CREATED_BY',
            'CREATED_AT',
            'UPDATED_BY',
            'UPDATED_TIME',
            'STATUS',
        ],
    ]) ?>

</div>
