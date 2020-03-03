<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\MYSQLUsuario */

$this->title = 'Create Mysql Usuario';
$this->params['breadcrumbs'][] = ['label' => 'Mysql Usuarios', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mysqlusuario-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
