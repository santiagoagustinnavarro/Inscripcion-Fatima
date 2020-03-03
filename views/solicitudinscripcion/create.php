<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\MYSQLSolicitudInscripcion */

$this->title = 'Create Mysql Solicitud Inscripcion';
$this->params['breadcrumbs'][] = ['label' => 'Mysql Solicitud Inscripcions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mysqlsolicitud-inscripcion-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
