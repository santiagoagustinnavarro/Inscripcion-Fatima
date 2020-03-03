<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\MYSQLSolicitudInscripcion */

$this->title = 'Update Mysql Solicitud Inscripcion: ' . $model->solicitud_id;
$this->params['breadcrumbs'][] = ['label' => 'Mysql Solicitud Inscripcions', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->solicitud_id, 'url' => ['view', 'id' => $model->solicitud_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="mysqlsolicitud-inscripcion-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
