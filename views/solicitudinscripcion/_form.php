<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\MYSQLSolicitudInscripcion */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="mysqlsolicitud-inscripcion-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'solicitud_id')->textInput() ?>

    <?= $form->field($model, 'solicitud_nro')->textInput() ?>

    <?= $form->field($model, 'solicitud_fecha')->textInput() ?>

    <?= $form->field($model, 'solicitud_estado')->textInput() ?>

    <?= $form->field($model, 'solicitud_establecimiento')->textInput() ?>
    

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
