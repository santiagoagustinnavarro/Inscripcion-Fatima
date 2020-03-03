<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\MYSQLSolicitud_postula_postulante */

$this->title = 'Confirmar inscripcion Nº' . $model->solicitud->solicitud_nro;
$this->params['breadcrumbs'][] = ['label' => 'Lista Solicitudes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->solicitud_id, 'url' => ['view', 'solicitud_id' => $model->solicitud_id, 'postulante_id' => $model->postulante_id]];
$this->params['breadcrumbs'][] = 'Solicitud';
?>
<div class="mysqlsolicitud-postula-postulante-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
