<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
$this->title="Inscripciones generadas";
foreach($mensajes as $unMensaje){
    echo Html::tag('h2',$unMensaje);
}



?>
