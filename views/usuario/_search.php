<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\MYSQLUsuarioSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="mysqlusuario-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'usuario_id') ?>

    <?= $form->field($model, 'usuario_nick') ?>

    <?= $form->field($model, 'usuario_nombre') ?>

    <?= $form->field($model, 'usuario_clave') ?>

    <?= $form->field($model, 'usuario_activo') ?>

    <?php // echo $form->field($model, 'usuario_creado')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
