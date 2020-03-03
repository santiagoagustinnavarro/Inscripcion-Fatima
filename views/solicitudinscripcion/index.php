<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\MYSQLSolicitudInscripcionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Mysql Solicitud Inscripcions';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mysqlsolicitud-inscripcion-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Mysql Solicitud Inscripcion', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'solicitud_id',
            'solicitud_nro',
            'solicitud_fecha',
            'solicitud_estado',
            'solicitud_establecimiento',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
