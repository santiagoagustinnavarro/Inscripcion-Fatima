<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\AlumnoLocal */

$this->title = 'Update Alumno Local: ' . $model->alumno_id;
$this->params['breadcrumbs'][] = ['label' => 'Alumno Locals', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->alumno_id, 'url' => ['view', 'id' => $model->alumno_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="alumno-local-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
