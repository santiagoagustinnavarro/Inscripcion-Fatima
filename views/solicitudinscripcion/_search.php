<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\MYSQLSolicitudInscripcionSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="mysqlsolicitud-inscripcion-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'solicitud_id') ?>

    <?= $form->field($model, 'solicitud_nro') ?>

    <?= $form->field($model, 'solicitud_fecha') ?>

    <?= $form->field($model, 'solicitud_estado') ?>

    <?= $form->field($model, 'solicitud_establecimiento') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
