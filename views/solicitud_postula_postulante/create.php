<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\MYSQLSolicitud_postula_postulante */

$this->title = 'Create Mysql Solicitud Postula Postulante';
$this->params['breadcrumbs'][] = ['label' => 'Mysql Solicitud Postula Postulantes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mysqlsolicitud-postula-postulante-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
