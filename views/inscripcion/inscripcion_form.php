<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use yii\jui\DatePicker;
use yii\bootstrap\Modal;
use yii\helpers\Url;

$this->registerJsFile(Url::base().'/js/formulario.js');

$this->title="Formulario de inscripción";
?>
<style>
#cargaContenido{
    display: flex;
  justify-content: center;
  align-items: center;
}</style>
<div id="contenido"></div>
<div class="col-offset-md-6" id="cargaContenido"></div>
<?php 
$this->registerJs("
 $.ajax({
        type: 'GET',
        url: 'inscripcion/traerdatos?id=$id',
        success: function (response) {
            $('#cargaContenido').html('');
            $('#contenido').html(response);
           
        },
        beforeSend:function(){
            $('#cargaContenido').html(\"<img src='" . Url::base() . "/images/Spinner.gif' /><h1>Obteniendo datos...</h1>\");
        }
    });"
);
?>