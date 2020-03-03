<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\MYSQLSolicitudInscripcion */

$this->title = $model->solicitud_id;
$this->params['breadcrumbs'][] = ['label' => 'Mysql Solicitud Inscripcions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="mysqlsolicitud-inscripcion-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->solicitud_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->solicitud_id], [
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
            'solicitud_id',
            'solicitud_nro',
            'solicitud_fecha',
            'solicitud_estado',
            'solicitud_establecimiento',
        ],
    ]) ?>

</div>
