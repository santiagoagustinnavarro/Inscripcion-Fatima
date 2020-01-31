

<?php 
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use yii\jui\DatePicker;
use yii\bootstrap\Modal;
use yii\helpers\Url;
/*if($responsable['cuit']==''){
    $responsable['cuit']=$responsable['numeroDocumento'];
}*/

?>
<?php 
$this->title = 'Formulario de inscripción';

?>

<div class="row">
<div class="col-md-offset-9 col-md-3">
<?= Html::label('Legajo','responsable[legajo]'); ?>
<?= Html::input('text','responsable[Legajo]',$responsable['codigo'],['readonly'=>'readonly','class'=>'form-control']); ?>
</div>
</div>
<?php $form=ActiveForm::begin([
    'method' => 'post',
    'action' => ['inscripcion/realizarinscripcion'],
    
]);?>
<?= Html::tag('h2','Responsable');?>
<?= Html::label('Cuit/cuil','responsable[cuit]'); ?>
<?= Html::input('text','responsable[cuit]',$responsable['cuit'],['class'=>'form-control']); ?>


<?= Html::label('Apellido y nombre','responsable[apellidoYNombre]'); ?>
<?= Html::input('text','responsable[apellidoYNombre]',$responsable['titular'],['class'=>'form-control']); ?>
<div class="row">
<div class="col-md-2">

<?=  $form->field($provinciaModel,'Nombre')->dropDownList(ArrayHelper::map($provinciaModel->find()->asArray()->all(),'ProvinciaKey','Nombre'),['options'=>[$responsable['provinciakey']=>['selected'=>true]],'prompt'=>'Selecciona una Provincia...','name'=>'responsable[provincia]','label'=>'Provincia',
'onchange'=>"$.ajax({

	type :'POST',
    dataType:'JSON',
	url  :'inscripcion/localidades',
    data:{'idProvincia':+$(\"select[name='responsable[provincia]']\").val()},
	success  : function(response) {
        var array,elem;
        $(\"#cargaLocalidad\").html('');
        $(\"select[name='responsable[localidad]']\").html('');
        for(elem in response){
            $(\"input[name='responsable[codigo_postal]']\").val(response[elem].CodigoPostal);
            
            $(\"select[name='responsable[localidad]']\").append('<option value='+response[elem].LocalidadKey+'>'+response[elem].Nombre+'</option>');
          
        }
    }
    ,
    beforeSend:function(){
        $(\"#cargaLocalidad\").html('".Html::img('@web/images/ajax-loader.gif', ['alt'=>'some', 'class'=>'thing'])."Cargando,espere por favor...');
    }
    })"
    ])
->label('Provincia');
?>
</div>
<div class="col-md-2">

<?=  $form->field($localidadModel,'Nombre')->dropDownList(ArrayHelper::map($localidadModel->find()->where(['provinciakey'=>$responsable['provinciakey']])->asArray()->all(),'LocalidadKey','Nombre'),['options'=>[$responsable['localidadkey']=>['selected'=>true]],'name'=>'responsable[localidad]','label'=>'Localidad','onchange'=>"$.ajax({

type :'POST',
dataType:'JSON',
url  :'inscripcion/traerlocalidad',
data:{'idLocalidad':+$(\"select[name='responsable[localidad]']\").val()},
success  : function(response) {
    var array,elem;
    $(\"#cargaLocalidad\").html('');
    for(elem in response){
        $(\"input[name='responsable[codigo_postal]']\").val(response[elem].CodigoPostal);
    }
},
beforeSend:function(){
    $(\"#cargaLocalidad\").html('".Html::img('@web/images/ajax-loader.gif', ['alt'=>'some', 'class'=>'thing'])."Cargando,espere por favor...');
}
})"]);?>
<?php //Html::label('Localidad','responsable[localidad]'); 
?>
<?php /* Html::dropDownList('responsable[localidad]',$responsable['localidadkey'],[''],['prompt'=>'Seleccione una localidad','class'=>'form-control','onchange'=>"$.ajax({

type :'POST',
dataType:'JSON',
url  :'index.php?r=inscripcion%2Ftraerlocalidad',
data:{'idLocalidad':+$(\"select[name='responsable[localidad]']\").val()},
success  : function(response) {
    var array,elem;
    for(elem in response){
        $(\"input[name='responsable[codigo_postal]']\").val(response[elem].CodigoPostal);
    }
}
})"]); */?>
</div>
<div class="col-md-2">
<?= Html::label('Codigo postal','responsable[codigo_postal]'); ?>
<?= Html::input('number','responsable[codigo_postal]',$responsable['cptitular'],['readonly'=>'readonly','class'=>'form-control']); ?>
</div>
<div class="col-md-2" id="cargaLocalidad"></div>
</div>
<?= Html::label('Domicilio','responsable[domicilio]'); ?>
<?= Html::input('text','responsable[domicilio]',$responsable['domiciliotitular'],['class'=>'form-control']); ?>

<div class="row">
    <div class="col-md-4">
    <?= Html::label('Fijo','responsable[telefonoFijo]'); ?>
    <?= Html::input('text','responsable[telefonoFijo]',$responsable['teltitular'],['class'=>'form-control']); ?>
    </div>
    <div class="col-md-4">
    <?= Html::label('Movil','responsable[telefonoMovil]'); ?>
    <?= Html::input('text','responsable[telefonoMovil]',$responsable['celtitular'],['class'=>'form-control']); ?>
    </div>
    <div class="col-md-4">
    <?= Html::label('Email','responsable[email]'); ?>
    <?= Html::input('email','responsable[email]',$responsable['emailtitular'],['class'=>'form-control']); ?>
    </div>
</div>


<!------------------------Fin Responsable------------------------------------------>
<?= Html::tag('hr');?>
<!--------------------------Inicio Padre---------------------------------------------->

<?= Html::tag('h2','Padre');?>
<?= Html::label('Apellido y nombre','padre[apellidoYNombre]'); ?>
<?= Html::input('text','padre[apellidoYNombre]',$padre['NombrePadre'],['class'=>'form-control']); ?>
<div class="row">
    <div class="col-md-6">
    <?= Html::label('Ocupación','padre[ocupacion]'); ?>
    <?= Html::input('text','padre[ocupacion]',$padre['PuestoPadre'],['class'=>'form-control']); ?>
    </div>
    <div class="col-md-6">
    <?= Html::label('Cuit/Cuil','padre[cuil]'); ?>
    <?= Html::input('text','padre[cuil]',$padre['DocumentoPadre'],['class'=>'form-control']); ?>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
    <?= Html::label('Telefono fijo','padre[telefonoFijo]'); ?>  
     <?= Html::input('number','padre[telefonoFijo]',trim($padre['TelefonoParticularPadre']),['class'=>'form-control']); ?>
    </div>
    <div class="col-md-6">
    <?= Html::label('Telefono Movil','padre[telefonoMovil]'); ?>
    <?= Html::input('number','padre[telefonoMovil]',trim($padre['CelularPadre']),['class'=>'form-control']); ?>
    </div>
   
</div>
<div class="row">
    <div class="col-md-6">
    <?= Html::label('Lugar de trabajo','padre[lugarTrabajo]'); ?>
    <?= Html::input('text','padre[lugarTrabajo]',$padre['DomicilioLaboralPadre'],['class'=>'form-control']); ?>
    </div>
    <div class="col-md-6">
    <?= Html::label('Telefono Laboral','padre[telefonoLaboral]'); ?>
    <?= Html::input('number','padre[telefonoLaboral]',trim($padre['TelefonoPadre']),['class'=>'form-control']); ?>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
    <?= Html::label('Fecha de nacimiento','padre[fechaNacimiento]'); ?>
    <span class="glyphicon glyphicon-calendar"></span> 
    <?= DatePicker::widget(['value'=>$padre['FechaNacimientoPadre'],
       'name'=>'padre[fechaNacimiento]','language' => 'es','dateFormat' => 'dd/MM/yyyy',
       'clientOptions'=>[
       'changeMonth' => true, 
       'changeYear' => true, 
       'showButtonPanel' => true, 
       'yearRange' => '1929:2019'],
       'options'=>['placeholder'=>'Elija la fecha de nacimiento','readonly'=>'readonly', 'showButtonPanel' => true,'class'=>'form-control']]);
       ?>
    </div>
    <div class="col-md-6">
    <?= Html::label('Nacionalidad','padre[nacionalidad]'); ?>
    <?= Html::dropDownList('padre[nacionalidad]',$padre['NacionalidadPadre'],ArrayHelper::map($paises,'Nombre','Nombre'),['prompt'=>'Seleccione una nacionalidad','class'=>['form-control']]); ?>
    </div>
</div>
<div class="row">
<div class="col-md-6">
<?= Html::label('Escuela de egreso primaria','padre[escuelaPrimaria]'); ?>
<?= Html::dropDownList('padre[escuelaPrimaria]',$padre['PrimariaPadre'],['INSF'=>'INSF (Ins.Nuestra Señora de Fatima)','ISC'=>'ISC(Ins.Santa Catalina)','ISFJ'=>'ISFJ(Ins.San Francisco Javier)'],['prompt'=>'Seleccione Escuela','class'=>'form-control']); ?>
</div>
<div class="col-md-6">
<?= Html::label('Escuela de egreso secundaria','padre[escuelaSecundaria]'); ?>
<?= Html::dropDownList('padre[escuelaSecundaria]',$padre['SecundariaPadre'],['INSF'=>'INSF (Ins.Nuestra Señora de Fatima)','ISC'=>'ISC(Ins.Santa Catalina)'],['prompt'=>'Seleccione Escuela','class'=>'form-control']); ?>
</div>
</div>
<div class="row">
<div class="col-md-4">
<?= Html::label('Bautismo','padre[bautismo]'); ?>
<?php

?>
<?=Html::dropDownList('padre[bautismo]',$padre['BautismoPadre'],['NO'=>'No','SI'=>'Si'],['class'=>'form-control']); ?>
</div>
<div class="col-md-4">
<?= Html::label('Comunion','padre[comunion]'); ?>
<?php


?>
<?=Html::dropDownList('padre[comunion]',$padre['ComunionPadre'],['NO'=>'No','SI'=>'Si'],['class'=>'form-control']); ?>
</div>
<div class="col-md-4">
<?= Html::label('Confirmacion','padre[confirmacion]'); ?>

<?=Html::dropDownList('padre[confirmacion]',$padre['ConfirmacionPadre'],['NO'=>'No','SI'=>'Si'],['class'=>'form-control']);  ?>
</div>
</div>
<!-------------------------------- Fin Padre------------------------------------------------------->
<?=Html::tag('hr');?>
<!----------------------------------Inicio Madre-------------------------------------------->

<?= Html::tag('h2','Madre');?>
<?= Html::label('Apellido y nombre','madre[apellidoYNombre]'); ?>
<?= Html::input('text','madre[apellidoYNombre]',$madre['NombreMadre'],['class'=>'form-control']); ?>
<div class="row">
    <div class="col-md-6">
    <?= Html::label('Ocupación','madre[ocupacion]'); ?>
    <?= Html::input('text','madre[ocupacion]',$madre['PuestoMadre'],['class'=>'form-control']); ?>
    </div>
    <div class="col-md-6">
    <?= Html::label('Cuit/Cuil','madre[cuil]'); ?>
    <?= Html::input('text','madre[cuil]',$madre['DocumentoMadre'],['class'=>'form-control']); ?>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
    <?= Html::label('Telefono fijo','madre[telefonoFijo]'); ?>  
     <?= Html::input('number','madre[telefonoFijo]',trim($madre['TelefonoParticularMadre']),['class'=>'form-control']); ?>
    </div>
    <div class="col-md-6">
    <?= Html::label('Telefono Movil','madre[telefonoMovil]'); ?>
    <?= Html::input('number','madre[telefonoMovil]',trim($madre['CelularMadre']),['class'=>'form-control']); ?>
    </div>
   
</div>
<div class="row">
    <div class="col-md-6">
    <?= Html::label('Lugar de trabajo','madre[lugarTrabajo]'); ?>
    <?= Html::input('text','madre[lugarTrabajo]',$madre['DomicilioLaboralMadre'],['class'=>'form-control']); ?>
    </div>
    <div class="col-md-6">
    <?= Html::label('Telefono Laboral','madre[telefonoLaboral]'); ?>
    <?= Html::input('number','madre[telefonoLaboral]',trim($madre['TelefonoMadre']),['class'=>'form-control']); ?>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
    <?= Html::label('Fecha de nacimiento',$madre['FechaNacimientoMadre']); ?>
    <span class="glyphicon glyphicon-calendar"></span> 
    <?= DatePicker::widget(['value'=>'05/07/1975',
       'name'=>'madre[fechaNacimiento]','language' => 'es','dateFormat' => 'dd/MM/yyyy',
       'clientOptions'=>[
       'changeMonth' => true, 
       'changeYear' => true, 
       'showButtonPanel' => true, 
       'yearRange' => '1929:2019'],
       'options'=>['placeholder'=>'Elija la fecha de nacimiento','readonly'=>'readonly', 'showButtonPanel' => true,'class'=>'form-control']]);
       ?>
    </div>
    <div class="col-md-6">
    <?= Html::label('Nacionalidad','madre[nacionalidad]'); ?>
    <?= Html::dropDownList('madre[nacionalidad]',$madre['NacionalidadMadre'],ArrayHelper::map($paises,'Nombre','Nombre'),['prompt'=>'Seleccione una nacionalidad','class'=>['form-control']]); ?>
    </div>
</div>
<div class="row">
<div class="col-md-6">
<?= Html::label('Escuela de egreso primaria','madre[escuelaPrimaria]'); ?>
<?= Html::dropDownList('madre[escuelaPrimaria]',$madre['PrimariaMadre'],['INSF'=>'INSF (Ins.Nuestra Señora de Fatima)','ISC'=>'ISC(Ins.Santa Catalina)','ISFJ'=>'ISFJ(Ins.San Francisco Javier)'],['prompt'=>'Seleccione un colegio','class'=>'form-control']); ?>
</div>
<div class="col-md-6">
<?= Html::label('Escuela de egreso secundaria','madre[escuelaSecundaria]');?>
<?= Html::dropDownList('madre[escuelaSecundaria]',$madre['SecundariaMadre'],['INSF'=>'INSF (Ins.Nuestra Señora de Fatima)','ISC'=>'ISC(Ins.Santa Catalina)'],['prompt'=>'Seleccione un colegio','class'=>'form-control']); ?>
</div>
</div>
<div class="row">
<div class="col-md-4">
<?= Html::label('Bautismo','madre[bautismo]'); ?>
<?=Html::dropDownList('madre[bautismo]',$madre['BautismoMadre'],['SI'=>'Si','NO'=>'No'],['class'=>'form-control']); ?>
</div>
<div class="col-md-4">
<?= Html::label('Comunion','madre[comunion]'); ?>
<?=Html::dropDownList('madre[comunion]',$madre['ComunionMadre'],['SI'=>'Si','NO'=>'No'],['class'=>'form-control']); ?>
</div>
<div class="col-md-4">
<?= Html::label('Confirmacion','madre[confirmacion]'); ?>
<?=Html::dropDownList('madre[confirmacion]',$madre['ConfirmacionMadre'],['SI'=>'Si','NO'=>'No'],['class'=>'form-control']); ?>
</div>
</div>
<!--------------------Fin madre----------------------------------------------------->
<?= Html::tag('hr');?>
<!--------------------Inicio Alumno----------------------------------------------------->
<?=Html::tag('h2','Alumnos');?>
<?=Html::dropDownList('alumnos','',ArrayHelper::map($alumno,'ODEO_AlumnoKey','Nombre'),['class'=>'form-control','prompt'=>'Selecciona un alumno...','label'=>'Lista de alumnos',
'onchange'=>"if( $(\"select[name='alumnos']\").val()==''){
    $(\"input[name='alumno[nombre]']\").val('')
    $(\"input[name='alumno[apellidos]']\").val('')
    $(\"input[name='alumno[dni]']\").val('')
    $(\"input[name='alumno[fechaIngreso]']\").val('')
    $(\"input[name='alumno[fechaEgreso']\").val('')
    $(\"input[name='alumno[fechaBautismo']\").val('')
    $(\"input[name='alumno[fechaComunion']\").val('')
    $(\"input[name='alumno[fechaNacimiento']\").val('')
    $(\"input[name='alumno[fechaConfirmacion']\").val('')
}else{
    $.ajax({
	type :'POST',
    dataType:'JSON',
	url  :'inscripcion/traeralumnocompleto',
    data:{'ODEO_alumnoKey':+$(\"select[name='alumnos']\").val()},
	success  : function(response) {
        var array,elem;
        
        $(\"#alumnos\").show();
        for(elem in response){
           
            console.log(response[elem].FechaBautismo)
         
            var fechaNacimiento = new Date(response[elem].FechaNacimiento);
            var fechaIngreso=new Date(response[elem].FechaIngreso);
            //var fechaComunion=new Date(response[elem].FechaComunion);
            var options = { year: 'numeric', month: 'numeric', day: 'numeric' };
            var fechaEgreso=new Date(response[elem].FechaEgreso);
            var fechaBautismo=new Date(response[elem].FechaBautismo);
            var fechaConfirmacion=new Date(response[elem].FechaConfirmacion);
            $(\"input[name='alumno[fechaIngreso]']\").val(fechaIngreso.toLocaleDateString(\"es-ES\", options));
            $(\"input[name='alumno[dni]']\").val(response[elem].NumeroDocumento);
            //$(\"input[name='alumno[fechaEgreso]']\").val(response[elem].FechaEgreso);
            $(\"input[name='alumno[nombre]']\").val(response[elem].Nombre);
            $(\"input[name='alumno[apellidos]']\").val(response[elem].Apellido);
            $(\"select[name='alumno[nivel]']\").val(response[elem].ODEO_NivelKey);
            $(\"select[name='alumno[nivel]'] option[value=\"+ response[elem].ODEO_NivelKey +\"]\").attr(\"selected\",true);
            $(\"select[name='alumno[sexo]']\").val(response[elem].Sexo);
            $(\"select[name='alumno[bautismo]']\").val(response[elem].Bautismo);
            $(\"select[name='alumno[comunion]']\").val(response[elem].Comunion);
            $(\"select[name='alumno[confirmacion]']\").val(response[elem].Confirmacion);
            $(\"input[name='alumno[lugarNacimiento]']\").val(response[elem].LugarNacimiento);
            $(\"input[name='alumno[lugarBautismo]']\").val(response[elem].LugarBautismo);
            $(\"input[name='alumno[lugarComunion]']\").val(response[elem].LugarComunion);
            $(\"input[name='alumno[diosecisBautismo]']\").val(response[elem].DiosecisBautismo);
            $(\"input[name='alumno[fechaBautismo]']\").val(response[elem].FechaBautismo);
            $(\"input[name='alumno[fechaComunion]']\").val(response[elem].FechaComunion);
            $(\"input[name='alumno[fechaConfirmacion]']\").val(response[elem].FechaConfirmacion);
            $(\"input[name='alumno[fechaNacimiento]']\").val(fechaNacimiento.toLocaleDateString(\"es-ES\", options));
            $(\"input[name='alumno[lugarConfirmacion]']\").val(response[elem].LugarConfirmacion);
          
            $(\"input[name='alumno[diosecisComunion]']\").val(response[elem].DiosecisComunion);
            $(\"input[name='alumno[diosecisConfirmacion]']\").val(response[elem].DiosecisConfirmacion);
        }
        $.ajax({
            type :'POST',
            dataType:'JSON',
            url  :'inscripcion/traergrado',
            data:{'ODEO_nivelKey':$(\"select[name='alumno[nivel]']\").val()},
            success  : function(responseAux) {
                $(\"#cargaAlumnos\").html('');
                $(\"select[name='alumno[grado]']\").html('');
                for(elemAux in responseAux){
                    $(\"select[name='alumno[grado]']\").append('<option value=\''+responseAux[elemAux].ODEO_GradoKey+'\'>'+responseAux[elemAux].DescripcionFacturacion+'</option>');
                   
                } 
                $(\"select[name='alumno[grado]'] option[value=\"+ response[elem].GradoKey +\"]\").attr(\"selected\",true);
                $.ajax({
                    type :'POST',
                    dataType:'JSON',
                    url  :'index.php?r=inscripcion/traerdivision',
                    data:{'ODEO_gradoKey':$(\"select[name='alumno[grado]']\").val()},
                    success  : function(responseDivision) {
                        $(\"select[name='alumno[seccion]']\").html('');
                       
                        for(elemDivision in responseDivision){
                            $(\"select[name='alumno[seccion]']\").append('<option value=\''+responseDivision[elemDivision].ODEO_DivisionKey+'\'>'+responseDivision[elemDivision].Nombre+'</option>');
                           
                        } 
                      
                        $(\"select[name='alumno[seccion]'] option[value=\"+ response[elem].DivisionKey +\"]\").attr(\"selected\",true);
                        if($(\"select[name='alumno[bautismo]']\").val()==\"NO\"){
                            $(\"input[name='alumno[lugarBautismo]']\").val('');
                            $(\"input[name='alumno[fechaBautismo]']\").val('');
                            $(\"input[name='alumno[lugarBautismo]']\").attr('disabled','disabled');
                            $(\"input[name='alumno[fechaBautismo]']\").attr('disabled','disabled');
                            $(\"input[name='alumno[diosecisBautismo]']\").attr('disabled','disabled');
                        }
                        if($(\"select[name='alumno[comunion]']\").val()==\"NO\"){
                            $(\"input[name='alumno[lugarComunion]']\").val('');
                            $(\"input[name='alumno[fechaComunion]']\").val('');
                            $(\"input[name='alumno[lugarComunion]']\").attr('disabled','disabled');
                            $(\"input[name='alumno[fechaComunion]']\").attr('disabled','disabled');
                            $(\"input[name='alumno[diosecisComunion]']\").attr('disabled','disabled');
                        }
                        if($(\"select[name='alumno[confirmacion]']\").val()==\"NO\"){

                            $(\"input[name='alumno[lugarConfirmacion]']\").val('');
                            $(\"input[name='alumno[fechaConfirmacion]']\").val('');
                            $(\"input[name='alumno[lugarConfirmacion]']\").attr('disabled','disabled');
                            $(\"input[name='alumno[diosecisConfirmacion]']\").attr('disabled','disabled');
                            $(\"input[name='alumno[fechaConfirmacion]']\").attr('disabled','disabled');
                        }
                    }
                
                })  
            }
           
           
           });
           
    }
    ,beforeSend:function(){
        $(\"#cargaAlumnos\").html('".Html::img('@web/images/ajax-loader.gif', ['alt'=>'some', 'class'=>'thing'])."Cargando,espere por favor...');
    }
    }); 
}"
    ]); ?>


<div id="cargaAlumnos"></div>
<div style="display: none" id="alumnos">
           
           <?= Html::label('DNI','alumno[dni]'); ?>
           <?=Html::input('number','alumno[dni]','',['class'=>'form-control']); ?>
           <div class="row">
               <div class="col-md-4">
               <?= Html::label('Nombres','alumno[nombres]'); ?>
               <?=Html::input('text','alumno[nombre]','',['class'=>'form-control']); ?>
               </div>
               <div class="col-md-4">
               <?= Html::label('Apellidos','alumno[apellidos]'); ?>
               <?=Html::input('text','alumno[apellidos]','',['class'=>'form-control']); ?>
               </div>
               <div class="col-md-4">
               <?= Html::label('Sexo','alumno[sexo]'); ?>
               <?=Html::dropDownList('alumno[sexo]','',['M'=>'Masculino','F'=>'Femenino'],['class'=>'form-control']); ?>
               </div>
           </div>
           <div class="row">
           <div class="col-md-4">
               <?= $form->field($nivelModel,'Nombre')->dropDownList(ArrayHelper::map($nivelModel->find()->asArray()->all(),'ODEO_NivelKey','Nombre'), ['name'=>'alumno[nivel]','prompt' => 'Seleccione Uno' ,'class'=>'form-control'
               ,'onchange'=>"$.ajax({
                type :'POST',
                dataType:'JSON',
                url  :'inscripcion/traergrado',
                data:{'ODEO_nivelKey':+$(\"select[name='alumno[nivel]']\").val()},
                success  : function(response) {
                    $(\"select[name='alumno[grado]']\").html('');
                    $(\"select[name='alumno[seccion]']\").html('');
                    for(elem in response){
                      
                        $(\"select[name='alumno[grado]']\").append('<option value=\''+response[elem].ODEO_GradoKey+'\'>'+response[elem].DescripcionFacturacion+'</option>');
                    } 
                }
               
               
               })"
               
               
               
               ])->label('Nivel'); ?>
           </div>
           <div class="col-md-4">
               <?= Html::label('Sala/Grado/Curso','alumno[grado]'); ?>
               <?=Html::dropDownList('alumno[grado]','',[],['class'=>'form-control',
               'onclick'=>"$.ajax({
                type :'POST',
                dataType:'JSON',
                url  :'inscripcion/traerdivision',
                data:{'ODEO_gradoKey':+$(\"select[name='alumno[grado]']\").val()},
                success  : function(response) {
                    $(\"select[name='alumno[seccion]']\").html('');
                    for(elem in response){
                      
                        $(\"select[name='alumno[seccion]']\").append('<option value=\''+response[elem].ODEO_DivisionKey+'\'>'+response[elem].Nombre+'</option>');
                    } 
                }
               
               
               })"
               
               
               ]); ?>
           </div>
           <div class="col-md-4">
               <?= Html::label('Seccion','alumno[seccion]'); ?>
               <?=Html::dropDownList('alumno[seccion]','',['A'=>'A','B'=>'B','C'=>'C','D'=>'D','E'=>'E'],['class'=>'form-control']); ?>
           </div>
           
           
           </div>
           <div class="row">
               <div class="col-md-6">
               <?= Html::label('Lugar de nacimiento','alumno[lugarNacimiento]'); ?>
               <?=Html::input('text','alumno[lugarNacimiento]','',['class'=>'form-control']); ?>
               </div>
               <div class="col-md-6">
               <?= Html::label('Fecha de nacimiento','alumno[fechaNacimiento]'); ?>
               <span class="glyphicon glyphicon-calendar"></span> 
               <?= DatePicker::widget([
                  'name'=>'alumno[fechaNacimiento]','language' => 'es','dateFormat' => 'dd/MM/yyyy',
                  'clientOptions'=>[
                  'changeMonth' => true, 
                  'changeYear' => true, 
                  'showButtonPanel' => true, 
                  'yearRange' => '1929:2019'],
                  'options'=>['placeholder'=>'Elija la fecha de nacimiento','readonly'=>'readonly', 'showButtonPanel' => true,'class'=>'form-control']]);
                  ?>
               </div>
           </div>
           <div class="row">
           <div class="col-md-6">
               <?= Html::label('Fecha de Ingreso','alumno[fechaIngreso]'); ?>
               <span class="glyphicon glyphicon-calendar"></span> 
               <?= DatePicker::widget([
                  'name'=>'alumno[fechaIngreso]','language' => 'es','dateFormat' => 'dd/MM/yyyy',
                  'clientOptions'=>[
                  'changeMonth' => true, 
                  'changeYear' => true, 
                  'showButtonPanel' => true, 
                  'yearRange' => '1929:2019'],
                  'options'=>['placeholder'=>'Elija la fecha de ingreso','readonly'=>'readonly', 'showButtonPanel' => true,'class'=>'form-control']]);
                  ?>
               </div>
               <div class="col-md-6">
               <?= Html::label('Fecha de egreso','alumno[fechaEgreso]'); ?>
               <span class="glyphicon glyphicon-calendar"></span> 
               <?= DatePicker::widget([
                  'name'=>'alumno[fechaEgreso]','language' => 'es','dateFormat' => 'dd/MM/yyyy',
                  'clientOptions'=>[
                  'changeMonth' => true, 
                  'changeYear' => true, 
                  'showButtonPanel' => true, 
                  'yearRange' => '1929:2019'],
                  'options'=>['placeholder'=>'Elija la fecha de egreso','readonly'=>'readonly', 'showButtonPanel' => true,'class'=>'form-control']]);
                  ?>
               </div>
           </div>
           <div class="row">
           <div class="col-md-3">
           <?= Html::label('Bautismo','alumno[bautismo]'); ?>
           <?=Html::dropDownList('alumno[bautismo]','',['SI'=>'Si','NO'=>'No'],['class'=>'form-control',
           'onchange'=>
           "
           if($(\"select[name='alumno[bautismo]']\").val()=='SI'){
               
            $(\"input[name='alumno[lugarBautismo]']\").removeAttr('disabled')
            $(\"input[name='alumno[fechaBautismo]']\").removeAttr('disabled')
            $(\"input[name='alumno[diosecisBautismo]']\").removeAttr('disabled')
           }else{
            $(\"input[name='alumno[lugarBautismo]']\").attr('disabled','disabled');
            $(\"input[name='alumno[fechaBautismo]']\").attr('disabled','disabled');
            $(\"input[name='alumno[diosecisBautismo]']\").attr('disabled','disabled');
           }"]); ?>
           </div>
           <div class="col-md-3">
           <?= Html::label('Lugar de bautismo','alumno[lugarBautismo]'); ?>
           <?=Html::input('text','alumno[lugarBautismo]','',['class'=>'form-control']); ?>
           </div>
           <div class="col-md-3">
               <?= Html::label('Fecha de Bautismo','alumno[fechaBautismo]'); ?>
               <span class="glyphicon glyphicon-calendar"></span> 
               <?= DatePicker::widget([
                  'name'=>'alumno[fechaBautismo]','language' => 'es','dateFormat' => 'dd/MM/yyyy',
                  'clientOptions'=>[
                  'changeMonth' => true, 
                  'changeYear' => true, 
                  'showButtonPanel' => true, 
                  'yearRange' => '1929:2019'],
                  'options'=>['placeholder'=>'Elija la fecha de bautismo','readonly'=>'readonly', 'showButtonPanel' => true,'class'=>'form-control']]);
                  ?>
               </div>
               <div class="col-md-3">
               <?= Html::label('Diosecis Bautismo','alumno[diosecisBautismo]'); ?>
           <?=Html::input('text','alumno[diosecisBautismo]','',['class'=>'form-control']); ?>
           </div>
        
              
           </div>
           <div class="row">
           <div class="col-md-3">
           <?= Html::label('Comunion','alumno[comunion]'); ?>
           <?=Html::dropDownList('alumno[comunion]','',['SI'=>'Si','NO'=>'No'],['class'=>'form-control',
           'onchange'=>
           "if($(\"select[name='alumno[comunion]']\").val()=='SI'){
            $(\"input[name='alumno[lugarComunion]']\").removeAttr('disabled')
            $(\"input[name='alumno[fechaComunion]']\").removeAttr('disabled')
            $(\"input[name='alumno[diosecisComunion]']\").removeAttr('disabled')
           }else{
            $(\"input[name='alumno[lugarComunion]']\").attr('disabled','disabled');
            $(\"input[name='alumno[fechaComunion]']\").attr('disabled','disabled');
            $(\"input[name='alumno[diosecisComunion]']\").attr('disabled','disabled');
           }"]); ?>
           </div>
           <div class="col-md-3">
           <?= Html::label('Lugar de Comunion','alumno[lugarComunion]'); ?>
           <?=Html::input('text','alumno[lugarComunion]','',['class'=>'form-control']); ?>
           </div>
           <div class="col-md-3">
               <?= Html::label('Fecha de Comunion','alumno[fechaComunion]'); ?>
               <span class="glyphicon glyphicon-calendar"></span> 
               <?= DatePicker::widget([
                  'name'=>'alumno[fechaComunion]','language' => 'es','dateFormat' => 'dd/MM/yyyy',
                  'clientOptions'=>[
                  'changeMonth' => true, 
                  'changeYear' => true, 
                  'showButtonPanel' => true, 
                  'yearRange' => '1929:2019'],
                  'options'=>['placeholder'=>'Elija la fecha de comunión','readonly'=>'readonly', 'showButtonPanel' => true,'class'=>'form-control']]);
                  ?>
               </div>
               <div class="col-md-3">
               <?= Html::label('Diosecis Comunion','alumno[diosecisComunion]'); ?>
           <?=Html::input('text','alumno[diosecisComunion]','',['class'=>'form-control']); ?>
           </div>
           </div>
           <div class="row">
           <div class="col-md-3">
           <?= Html::label('Confirmacion','alumno[confirmacion]'); ?>
           <?=Html::dropDownList('alumno[confirmacion]','',['SI'=>'Si','NO'=>'No'],['class'=>'form-control',
           'onchange'=>
           "if($(\"select[name='alumno[confirmacion]']\").val()=='SI'){
            $(\"input[name='alumno[lugarConfirmacion]']\").removeAttr('disabled')
            $(\"input[name='alumno[fechaConfirmacion]']\").removeAttr('disabled')
            $(\"input[name='alumno[diosecisConfirmacion]']\").removeAttr('disabled')
           }else{
            $(\"input[name='alumno[lugarConfirmacion]']\").attr('disabled','disabled');
            $(\"input[name='alumno[fechaConfirmacion]']\").attr('disabled','disabled');
            $(\"input[name='alumno[diosecisConfirmacion]']\").attr('disabled','disabled');
           }"]); ?>
           </div>
           <div class="col-md-3">
           <?= Html::label('Lugar de Confirmación','alumno[lugarConfirmacion]'); ?>
           <?=Html::input('text','alumno[lugarConfirmacion]','',['class'=>'form-control']); ?>
           </div>
           <div class="col-md-3">
               <?= Html::label('Fecha de Confirmacion','alumno[fechaConfirmacion]'); ?>
               <span class="glyphicon glyphicon-calendar"></span> 
               <?= DatePicker::widget([
                  'name'=>'alumno[fechaConfirmacion]','language' => 'es','dateFormat' => 'dd/MM/yyyy',
                  'clientOptions'=>[
                  'changeMonth' => true, 
                  'changeYear' => true, 
                  'showButtonPanel' => true, 
                  'yearRange' => '1929:2019'],
                  'options'=>['placeholder'=>'Elija la fecha de confirmación','readonly'=>'readonly', 'showButtonPanel' => true,'class'=>'form-control']]);
                  ?>
               </div>
               <div class="col-md-3">
               <?= Html::label('Diosecis Confirmacion','alumno[diosecisConfirmacion]'); ?>
           <?=Html::input('text','alumno[diosecisConfirmacion]','',['class'=>'form-control']); ?>
           </div>
           </div>
           <br/>
           <br/>
           <?php echo Html::button('Guardar',['class'=>'btn btn-success','type'=>'submit','onclick'=>"alert('Acción en construcción')"]);?>
           </div>
          


<?php 

ActiveForm::end();

?>