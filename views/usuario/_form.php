<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\MYSQLUsuario */
/* @var $form yii\widgets\ActiveForm */
$this->registerJsFile(Url::base() . '/js/cambioClave.js');
?>

<div class="mysqlusuario-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php // echo $form->field($model, 'usuario_nick')->textInput(['maxlength' => true]); ?>

    <?php //echo  $form->field($model, 'usuario_nombre')->textInput(['maxlength' => true]); ?>

    <?= $form->field($model, 'usuario_clave')->passwordInput(['value'=>'','maxlength' => true])->label('Ingrese la nueva clave') ?>
    <?= $form->field($model, 'usuario_clave')->passwordInput(['value'=>'','maxlength' => true,'id'=>'usuario_clave2'])->label('Reingrese la clave') ?>

    <?php // echo $form->field($model, 'usuario_activo')->textInput(); ?>

    <?php echo  $form->field($model, 'usuario_creado')->hiddenInput(['value'=>1])->label(false); ?>
    <div id="difiere"></div>
    <div class="form-group">
        <?= Html::submitButton('Cambiar clave',['id'=>'cambiaClave','class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>