<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\MYSQLSolicitud_postula_postulante */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="mysqlsolicitud-postula-postulante-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model->solicitud, 'solicitud_nro')->textInput(['readonly'=>true]) ?>
     <?= $form->field($model->postulante->persona, 'persona_nombres')->textInput(['readonly'=>true]); ?>
     <?= $form->field($model->postulante->persona, 'persona_apellidos')->textInput(['readonly'=>true]); ?>
     <?= $form->field($model->postulante->persona, 'persona_nro_doc')->textInput(['readonly'=>true]); ?>
     <?= $form->field($model->solicitud, 'solicitud_establecimiento')->textInput(['readonly'=>true]); ?>
     <?= $form->field($model->solicitud, 'solicitud_id')->hiddenInput()->label(false);; ?>
     <?= $form->field($model->solicitud, 'solicitud_fecha')->textInput(['readonly'=>true]); ?>
     <?= $form->field($model->solicitud, 'solicitud_estado')->dropDownList([0=>"Pendiente",1=>"Validada"]); ?>
    <div class="form-group">
        <?= Html::submitButton('Confirmar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
