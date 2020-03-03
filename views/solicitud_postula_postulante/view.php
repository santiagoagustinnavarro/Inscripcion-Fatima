<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\MYSQLSolicitud_postula_postulante */

$this->title = $model->solicitud_id;
$this->params['breadcrumbs'][] = ['label' => 'Mysql Solicitud Postula Postulantes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="mysqlsolicitud-postula-postulante-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'solicitud_id' => $model->solicitud_id, 'postulante_id' => $model->postulante_id], ['class' => 'btn btn-primary']) ?>
        <?php Html::a('Delete', ['delete', 'solicitud_id' => $model->solicitud_id, 'postulante_id' => $model->postulante_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
    <?php 
    if($model->solicitud->solicitud_estado==0){
$estado='Pendiente';
    }else{
$estado='Validado';
    }
    ?>
    <?= DetailView::widget([
        
        'model' => $model->solicitud,
        ['attributes' => ['solicitud_estado', 'format' => 'raw','value'=>$estado]],
    ]) ?>

</div>
