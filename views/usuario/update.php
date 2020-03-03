<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\MYSQLUsuario */

$this->title = 'Cambio de clave '; //. $model->usuario_id;
$this->params['breadcrumbs'][] = ['label' => 'Cambio de clave', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->usuario_nombre, 'url' => ['view', 'id' => $model->usuario_id]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="mysqlusuario-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>