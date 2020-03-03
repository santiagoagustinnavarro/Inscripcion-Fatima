<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\MYSQLSolicitud_postula_postulanteSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Solicitudes de Inscripción';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mysqlsolicitud-postula-postulante-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Mysql Solicitud Postula Postulante', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            ['label'=>'Nombres','attribute'=>'nombre','value'=>'postulante.persona.persona_nombres'],
            ['label'=>'Apellidos','attribute'=>'apellido','value'=>'postulante.persona.persona_apellidos'],
            ['label'=>'DNI','attribute'=>'nroDoc','value'=>'postulante.persona.persona_nro_doc'],
            'solicitud_id',
            'postulante_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
