<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Bus */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Bus',
]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Buses'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="bus-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
