<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\jui\DatePicker;

?>
<?php
$this->registerJsFile(Url::base() . '/js/formulario.js');
$this->title = 'Formulario de inscripción';

?>


<?php $form = ActiveForm::begin([
    'id'=>'formInscripcion',
    'method' => 'post',
    'action' => ['solicitudinscripcion/solicitarinscripcion'],

]);?>
<div class="row">
    <div class="col-md-offset-9 col-md-3">
        <?=Html::label('Legajo', 'responsable[legajo]');?>
        <?=Html::input('text', 'responsable[legajo]', $responsable['codigo'], ['readonly' => 'readonly', 'class' => 'form-control']);?>
    </div>
</div>
<!---------------------------------------------------------------- Inicio Responsable------------------------------------------->
<?=Html::tag('h2', 'Responsable');?>
<?=Html::label('Cuit/cuil', 'responsable[cuit]');?>
<?=Html::input('text', 'responsable[cuit]', $responsable['cuit'], ['class' => 'form-control']);?>


<?=Html::label('Apellido y nombre', 'responsable[apellidoYNombre]');?>
<?=Html::input('text', 'responsable[apellidoYNombre]', $responsable['titular'], ['class' => 'form-control']);?>
<div class="row">
    <div class="col-md-2">

        <?=$form->field($provinciaModel, 'Nombre')->dropDownList(ArrayHelper::map($provinciaModel->find()->asArray()->all(), 'ProvinciaKey', 'Nombre'), ['options' => [$responsable['provinciakey'] => ['selected' => true]], 'prompt' => 'Selecciona una Provincia...', 'name' => 'responsable[provincia]', 'label' => 'Provincia',
    'onchange' => "traerLocalidades('" . Url::base() . "');"])->label('Provincia');
?>
    </div>
    <div class="col-md-2">

        <?=$form->field($localidadModel, 'Nombre')->dropDownList(ArrayHelper::map($localidadModel->find()->where(['provinciakey' => $responsable['provinciakey']])->asArray()->all(), 'LocalidadKey', 'Nombre'), ['options' => [$responsable['localidadkey'] => ['selected' => true]], 'name' => 'responsable[localidad]', 'label' => 'Localidad',
    "onchange" => "traerCP('" . Url::base() . "');"]);?>

    </div>
    <div class="col-md-2">
        <?=Html::label('Codigo postal', 'responsable[codigo_postal]');?>
        <?=Html::input('number', 'responsable[codigo_postal]', $responsable['cptitular'], ['readonly' => 'readonly', 'class' => 'form-control']);?>
    </div>
    <div class="col-md-2" id="cargaLocalidad"></div>
</div>
<?=Html::label('Domicilio', 'responsable[domicilio]');?>
<?=Html::input('text', 'responsable[domicilio]', $responsable['domiciliotitular'], ['class' => 'form-control']);?>

<div class="row">
    <div class="col-md-4">
        <?=Html::label('Fijo', 'responsable[telefonoFijo]');?>
        <?=Html::input('text', 'responsable[telefonoFijo]', $responsable['teltitular'], ['class' => 'form-control']);?>
    </div>
    <div class="col-md-4">
        <?=Html::label('Movil', 'responsable[telefonoMovil]');?>
        <?=Html::input('text', 'responsable[telefonoMovil]', $responsable['celtitular'], ['class' => 'form-control']);?>
    </div>
    <div class="col-md-4">
        <?=Html::label('Email', 'responsable[email]');?>
        <?=Html::input('email', 'responsable[email]', $responsable['emailtitular'], ['class' => 'form-control']);?>
    </div>
</div>


<!------------------------Fin Responsable------------------------------------------>
<?=Html::tag('hr');?>
<!--------------------------Inicio Padre---------------------------------------------->

<?=Html::tag('h2', 'Padre');?>
<?=Html::label('Apellido y nombre', 'padre[apellidoYNombre]');?>
<?=Html::input('text', 'padre[apellidoYNombre]', $padre['NombrePadre'], ['class' => 'form-control']);?>
<div class="row">
    <div class="col-md-6">
        <?=Html::label('Ocupación', 'padre[ocupacion]');?>
        <?=Html::input('text', 'padre[ocupacion]', $padre['PuestoPadre'], ['class' => 'form-control']);?>
    </div>
    <div class="col-md-6">
        <?=Html::label('Cuit/Cuil', 'padre[cuil]');?>
        <?php
if ($padre['TipoDocPadre'] == 'CUIT' || $padre['TipoDocPadre'] == 'CUIL') {
    echo Html::input('text', 'padre[cuil]', $padre['DocumentoPadre'], ['class' => 'form-control']);
} else {
    echo Html::input('text', 'padre[cuil]', '', ['class' => 'form-control']);
}?>

    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <?=Html::label('Telefono fijo', 'padre[telefonoFijo]');?>
        <?=Html::input('number', 'padre[telefonoFijo]', trim($padre['TelefonoParticularPadre']), ['class' => 'form-control']);?>
    </div>
    <div class="col-md-6">
        <?=Html::label('Telefono Movil', 'padre[telefonoMovil]');?>
        <?=Html::input('number', 'padre[telefonoMovil]', trim($padre['CelularPadre']), ['class' => 'form-control']);?>
    </div>

</div>
<div class="row">
    <div class="col-md-6">
        <?=Html::label('Lugar de trabajo', 'padre[lugarTrabajo]');?>
        <?=Html::input('text', 'padre[lugarTrabajo]', $padre['DomicilioLaboralPadre'], ['class' => 'form-control']);?>
    </div>
    <div class="col-md-6">
        <?=Html::label('Telefono Laboral', 'padre[telefonoLaboral]');?>
        <?=Html::input('number', 'padre[telefonoLaboral]', trim($padre['TelefonoPadre']), ['class' => 'form-control']);?>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <?=Html::label('Fecha de nacimiento', 'padre[fechaNacimiento]');?>
        <span class="glyphicon glyphicon-calendar"></span>
        <?php $date = new DatePicker();
$date->init();?>
        <?=DatePicker::widget(['value' => $padre['FechaNacimientoPadre'],
    'name' => 'padre[fechaNacimiento]', 'language' => 'es', 'dateFormat' => 'dd/MM/yyyy',
    'clientOptions' => [
        'changeMonth' => true,
        'changeYear' => true,
        'showButtonPanel' => true,
        'yearRange' => '1929:2019'],
    'options' => ['placeholder' => 'Elija la fecha de nacimiento', 'readonly' => 'readonly', 'showButtonPanel' => true, 'class' => 'form-control']]);
?>
    </div>
    <div class="col-md-6">
        <?=Html::label('Nacionalidad', 'padre[nacionalidad]');?>
        <?=Html::dropDownList('padre[nacionalidad]', $padre['NacionalidadPadre'], ArrayHelper::map($paises, 'Nombre', 'Nombre'), ['prompt' => 'Seleccione una nacionalidad', 'class' => ['form-control']]);?>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <?=Html::label('Escuela de egreso primaria', 'padre[escuelaPrimaria]');?>
        <?=Html::dropDownList('padre[escuelaPrimaria]', $padre['PrimariaPadre'], ['INSF' => 'INSF (Ins.Nuestra Señora de Fatima)', 'ISC' => 'ISC(Ins.Santa Catalina)', 'ISFJ' => 'ISFJ(Ins.San Francisco Javier)'], ['prompt' => 'Seleccione Escuela', 'class' => 'form-control']);?>
    </div>
    <div class="col-md-6">
        <?=Html::label('Escuela de egreso secundaria', 'padre[escuelaSecundaria]');?>
        <?=Html::dropDownList('padre[escuelaSecundaria]', $padre['SecundariaPadre'], ['INSF' => 'INSF (Ins.Nuestra Señora de Fatima)', 'ISC' => 'ISC(Ins.Santa Catalina)'], ['prompt' => 'Seleccione Escuela', 'class' => 'form-control']);?>
    </div>
</div>
<div class="row">
    <div class="col-md-4">
        <?=Html::label('Bautismo', 'padre[bautismo]');?>
        <?php
if (is_null($padre['BautismoPadre'])) {$padre['BautismoPadre'] = "NO";
}
if (is_null($padre['ComunionPadre'])) {$padre['ComunionPadre'] = "NO";
}
if (is_null($padre['ConfirmacionPadre'])) {$padre['ConfirmacionPadre'] = "NO";
}

?>
        <?=Html::dropDownList('padre[bautismo]', $padre['BautismoPadre'], ['NO' => 'No', 'SI' => 'Si'], ['class' => 'form-control']);?>
    </div>
    <div class="col-md-4">
        <?=Html::label('Comunion', 'padre[comunion]');?>
        <?php

?>
        <?=Html::dropDownList('padre[comunion]', $padre['ComunionPadre'], ['NO' => 'No', 'SI' => 'Si'], ['class' => 'form-control']);?>
    </div>
    <div class="col-md-4">
        <?=Html::label('Confirmacion', 'padre[confirmacion]');?>

        <?=Html::dropDownList('padre[confirmacion]', $padre['ConfirmacionPadre'], ['NO' => 'No', 'SI' => 'Si'], ['class' => 'form-control']);?>
    </div>
    <input name='padre[tipoDoc]' type="hidden" value=<?php echo $padre['TipoDocPadre'] ?>>
</div>
<!-------------------------------- Fin Padre------------------------------------------------------->
<?=Html::tag('hr');?>
<!----------------------------------Inicio Madre-------------------------------------------->

<?=Html::tag('h2', 'Madre');?>
<?=Html::label('Apellido y nombre', 'madre[apellidoYNombre]');?>
<?=Html::input('text', 'madre[apellidoYNombre]', $madre['NombreMadre'], ['class' => 'form-control']);?>
<div class="row">
    <div class="col-md-6">
        <?=Html::label('Ocupación', 'madre[ocupacion]');?>
        <?=Html::input('text', 'madre[ocupacion]', $madre['PuestoMadre'], ['class' => 'form-control']);?>
    </div>
    <div class="col-md-6">
        <?=Html::label('Cuit/Cuil', 'madre[cuil]');?>
        <?php
if ($madre['TipoDocMadre'] == 'CUIT' || $madre['TipoDocMadre'] == 'CUIL') {
    echo Html::input('text', 'madre[cuil]', $madre['DocumentoMadre'], ['class' => 'form-control']);
} else {
    echo Html::input('text', 'madre[cuil]', '', ['class' => 'form-control']);
}?>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <?=Html::label('Telefono fijo', 'madre[telefonoFijo]');?>
        <?=Html::input('number', 'madre[telefonoFijo]', trim($madre['TelefonoParticularMadre']), ['class' => 'form-control']);?>
    </div>
    <div class="col-md-6">
        <?=Html::label('Telefono Movil', 'madre[telefonoMovil]');?>
        <?=Html::input('number', 'madre[telefonoMovil]', trim($madre['CelularMadre']), ['class' => 'form-control']);?>
    </div>

</div>
<div class="row">
    <div class="col-md-6">
        <?=Html::label('Lugar de trabajo', 'madre[lugarTrabajo]');?>
        <?=Html::input('text', 'madre[lugarTrabajo]', $madre['DomicilioLaboralMadre'], ['class' => 'form-control']);?>
    </div>
    <div class="col-md-6">
        <?=Html::label('Telefono Laboral', 'madre[telefonoLaboral]');?>
        <?=Html::input('number', 'madre[telefonoLaboral]', trim($madre['TelefonoMadre']), ['class' => 'form-control']);?>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <?=Html::label('Fecha de nacimiento', 'madre[FechaNacimiento]');?>
        <span class="glyphicon glyphicon-calendar"></span>
        <?=DatePicker::widget(['value' => $madre['FechaNacimientoMadre'],
    'name' => 'madre[fechaNacimiento]', 'language' => 'es', 'dateFormat' => 'dd/MM/yyyy',
    'clientOptions' => [
        'changeMonth' => true,
        'changeYear' => true,
        'showButtonPanel' => true,
        'yearRange' => '1929:2019'],
    'options' => ['placeholder' => 'Elija la fecha de nacimiento', 'readonly' => 'readonly', 'showButtonPanel' => true, 'class' => 'form-control']]);
?>
    </div>
    <div class="col-md-6">
        <?=Html::label('Nacionalidad', 'madre[nacionalidad]');?>
        <?=Html::dropDownList('madre[nacionalidad]', $madre['NacionalidadMadre'], ArrayHelper::map($paises, 'Nombre', 'Nombre'), ['prompt' => 'Seleccione una nacionalidad', 'class' => ['form-control']]);?>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <?=Html::label('Escuela de egreso primaria', 'madre[escuelaPrimaria]');?>
        <?=Html::dropDownList('madre[escuelaPrimaria]', $madre['PrimariaMadre'], ['INSF' => 'INSF (Ins.Nuestra Señora de Fatima)', 'ISC' => 'ISC(Ins.Santa Catalina)', 'ISFJ' => 'ISFJ(Ins.San Francisco Javier)'], ['prompt' => 'Seleccione un colegio', 'class' => 'form-control']);?>
    </div>
    <div class="col-md-6">
        <?=Html::label('Escuela de egreso secundaria', 'madre[escuelaSecundaria]');?>
        <?=Html::dropDownList('madre[escuelaSecundaria]', $madre['SecundariaMadre'], ['INSF' => 'INSF (Ins.Nuestra Señora de Fatima)', 'ISC' => 'ISC(Ins.Santa Catalina)'], ['prompt' => 'Seleccione un colegio', 'class' => 'form-control']);?>
    </div>
</div>
<div class="row">
    <div class="col-md-4">
        <?=Html::label('Bautismo', 'madre[bautismo]');?>
        <?php if (is_null($madre['BautismoMadre'])) {$madre['BautismoMadre'] = "NO";
}
if (is_null($madre['ComunionMadre'])) {$madre['ComunionMadre'] = "NO";
}
if (is_null($madre['ConfirmacionMadre'])) {$madre['ConfirmacionMadre'] = "NO";
}
?>

        <?=Html::dropDownList('madre[bautismo]', $madre['BautismoMadre'], ['SI' => 'Si', 'NO' => 'No'], ['class' => 'form-control']);?>
    </div>
    <div class="col-md-4">
        <?=Html::label('Comunion', 'madre[comunion]');?>
        <?=Html::dropDownList('madre[comunion]', $madre['ComunionMadre'], ['SI' => 'Si', 'NO' => 'No'], ['class' => 'form-control']);?>
    </div>
    <div class="col-md-4">
        <?=Html::label('Confirmacion', 'madre[confirmacion]');?>
        <?=Html::dropDownList('madre[confirmacion]', $madre['ConfirmacionMadre'], ['SI' => 'Si', 'NO' => 'No'], ['class' => 'form-control']);?>
    </div>
    <input name='madre[tipoDoc]' type="hidden" value=<?php echo $madre['TipoDocMadre'] ?>>
</div>
<!--------------------Fin madre----------------------------------------------------->
<?=Html::tag('hr');?>
<!--------------------Inicio Alumno----------------------------------------------------->
<?=Html::tag('h2', 'Alumnos');?>
<?php
//print_r($alumnos);
$alumnos = ArrayHelper::map($alumno, 'ODEO_AlumnoKey', 'Nombre');
//$alumnos["new"] = 'Nuevo alumno'; //Genera la opcion de nuevo alumno en el select
?>
<?=Html::dropDownList('alumnos', '', $alumnos, ['class' => 'form-control', 'prompt' => 'Selecciona un alumno...', 'label' => 'Lista de alumnos',
    'onchange' => "datosAlumno('" . Url::base() . "')"]);?>
 
<div id="cargaAlumnos"></div>
<!-- <div style="display: none" id="alumnos"> -->

<?php

for($i=0;$i<count($alumno);$i++){ ?>
<div id="seleccionado<?php echo $alumno[$i]['ODEO_AlumnoKey'];?>" style='display:none'> 
<?=Html::input('hidden', 'alumnosArray['.$i.']'.'[persona_id]',  $alumno[$i]['ODEO_AlumnoKey'], ['class' => 'form-control']);?>

    <?=Html::label('DNI', 'alumnosArray['.$i.'][dni]');?>
    <?=Html::input('number', 'alumnosArray['.$i.']'.'[dni]',  $alumno[$i]['NumeroDocumento'], ['class' => 'form-control']);?>
    <div class="row">
        <div class="col-md-4">
            <?=Html::label('Nombres', 'alumno[nombres]');?>
            <?=Html::input('text', 'alumnosArray['.$i.']'.'[nombre]',   $alumno[$i]['Nombre'], ['class' => 'form-control']);?>
        </div>
        <div class="col-md-4">
            <?=Html::label('Apellidos', 'alumnosArray['.$i.'][apellidos]');?>
            <?=Html::input('text', 'alumnosArray['.$i.']'.'[apellidos]',  $alumno[$i]['Apellido'], ['class' => 'form-control']);?>
        </div>
        <div class="col-md-4">
            <?=Html::label('Sexo', 'alumnosArray['.$i.'][sexo]');?>
            <?=Html::dropDownList('alumnosArray['.$i.']'.'[sexo]', $alumno[$i]['Sexo'], ['M' => 'Masculino', 'F' => 'Femenino'], ['class' => 'form-control']);?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <?=$form->field($nivelModel, 'Nombre')->dropDownList(ArrayHelper::map($nivelModel->find()->asArray()->all(), 'ODEO_NivelKey', 'Nombre'), ['name' => 'alumnosArray['.$i.']'.'[nivel]', 'prompt' => 'Seleccione Uno', 'class' => 'form-control'
    , 'onchange' => "traerGrado('" . Url::base() . "',".$i.");",'value'=>$alumno[$i]['IdNivel'],
])->label('Nivel');?>
        </div>
        <div class="col-md-4">
       
            <?=Html::label('Sala/Grado/Curso', 'alumnosArray['.$i.'][grado]');?>
            <?=Html::dropDownList('alumnosArray['.$i.'][grado]',  $alumno[$i]['IdGrado'],ArrayHelper::map($grados[$i], 'ODEO_GradoKey', 'DescripcionFacturacion'), ['class' => 'form-control',
    'onclick' =>  "traerDivision('" . Url::base() . "',".$i.");",
]);?>
        </div>
        <div class="col-md-3">
            <?=Html::label('Seccion', 'alumnosArray['.$i.'][seccion]');?>
            <?=Html::dropDownList('alumnosArray['.$i.'][seccion]',  $alumno[$i]['IdDivision'], ArrayHelper::map($divisiones[$i], 'ODEO_DivisionKey', 'Codigo'), ['class' => 'form-control']);?>
        </div>
        <div class="col-md-1" id="cargaAsignaAlumno">
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <?=Html::label('Lugar de nacimiento', 'alumnosArray['.$i.'][lugarNacimiento]');?>
            <?=Html::input('text', 'alumnosArray['.$i.'][lugarNacimiento]', $alumno[$i]['LugarNacimiento'], ['class' => 'form-control']);?>
        </div>
        <div class="col-md-6">
            <?=Html::label('Fecha de nacimiento', 'alumnosArray['.$i.'][fechaNacimiento]');?>
            <span class="glyphicon glyphicon-calendar"></span>
            <?=DatePicker::widget([
    'name' => 'alumnosArray['.$i.'][fechaNacimiento]', 'language' => 'es', 'dateFormat' => 'dd/MM/yyyy','value'=>$alumno[$i]['FechaNacimiento'],
    'clientOptions' => [
        'changeMonth' => true,
        'changeYear' => true,
        'showButtonPanel' => true,
        'yearRange' => '1929:2019'],
    'options' => ['placeholder' => 'Elija la fecha de nacimiento', 'readonly' => 'readonly', 'showButtonPanel' => true, 'class' => 'form-control']]);
?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <?=Html::label('Fecha de Ingreso', 'alumnosArray['.$i.'][fechaIngreso]');?>
            <span class="glyphicon glyphicon-calendar"></span>
            <?=DatePicker::widget([
    'name' => 'alumnosArray['.$i.'][fechaIngreso]', 'language' => 'es', 'dateFormat' => 'dd/MM/yyyy','value'=>$alumno[$i]['FechaIngreso'],
    'clientOptions' => [
        'changeMonth' => true,
        'changeYear' => true,
        'showButtonPanel' => true,
        'yearRange' => '1929:2019'],
    'options' => ['placeholder' => 'Elija la fecha de ingreso', 'readonly' => 'readonly', 'showButtonPanel' => true, 'class' => 'form-control']]);
?>
        </div>
        <div class="col-md-6">
            <?=Html::label('Fecha de egreso', 'alumnosArray['.$i.'][fechaEgreso]');?>
            <span class="glyphicon glyphicon-calendar"></span>
            <?=DatePicker::widget([
    'name' => 'alumnosArray['.$i.'][fechaEgreso]', 'language' => 'es', 'dateFormat' => 'dd/MM/yyyy',
    'clientOptions' => [
        'changeMonth' => true,
        'changeYear' => true,
        'showButtonPanel' => true,
        'yearRange' => '1929:2019'],
    'options' => ['placeholder' => 'Elija la fecha de egreso', 'readonly' => 'readonly', 'showButtonPanel' => true, 'class' => 'form-control']]);
?>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-3">
            <?=Html::label('Bautismo', 'alumnosArray['.$i.'][bautismo]');?>
            <?=Html::dropDownList('alumnosArray['.$i.'][bautismo]', $alumno[$i]['Bautismo'], ['SI' => 'Si', 'NO' => 'No'], ['class' => 'form-control',
    'onchange' => "deshabilitarSacramento('bautismo',".$i.")"]);?>
        </div>
        <div class="col-md-3">
            <?=Html::label('Lugar de bautismo', 'alumnosArray['.$i.'][lugarBautismo]');?>
            <?=Html::input('text', 'alumnosArray['.$i.'][lugarBautismo]', $alumno[$i]['LugarBautismo'], ['class' => 'form-control']);?>
        </div>
        <div class="col-md-3">
            <?=Html::label('Fecha de Bautismo', 'alumnosArray['.$i.'][fechaBautismo]');?>
            <span class="glyphicon glyphicon-calendar"></span>
            <?=DatePicker::widget([
    'name' => 'alumnosArray['.$i.'][fechaBautismo]', 'language' => 'es', 'dateFormat' => 'dd/MM/yyyy','value'=>$alumno[$i]['FechaBautismo'],
    'clientOptions' => [
        'changeMonth' => true,
        'changeYear' => true,
        'showButtonPanel' => true,
        'yearRange' => '1929:2019'],
        
    'options' => ['placeholder' => 'Elija la fecha de bautismo', 'readonly' => 'readonly', 'showButtonPanel' => true, 'class' => 'form-control']]);
?>
        </div>
        <div class="col-md-3">
            <?=Html::label('Diosecis Bautismo', 'alumnosArray['.$i.'][diosecisBautismo]');?>
            <?=Html::input('text', 'alumnosArray['.$i.'][diosecisBautismo]', $alumno[$i]['DiosecisBautismo'], ['class' => 'form-control']);?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3">
            <?=Html::label('Comunion', 'alumnosArray['.$i.'][comunion]');?>
            <?=Html::dropDownList('alumnosArray['.$i.'][comunion]', $alumno[$i]['Comunion'], ['SI' => 'Si', 'NO' => 'No'], ['class' => 'form-control',
    'onchange' => "deshabilitarSacramento('comunion',".$i.")"]);?>
        </div>
        <div class="col-md-3">
            <?=Html::label('Lugar de Comunion', 'alumnosArray['.$i.'][lugarComunion]');?>
            <?=Html::input('text', 'alumnosArray['.$i.'][lugarComunion]',$alumno[$i]['LugarComunion'] , ['class' => 'form-control']);?>
        </div>
        <div class="col-md-3">
            <?=Html::label('Fecha de Comunion', 'alumnosArray['.$i.'][fechaComunion]');?>
            <span class="glyphicon glyphicon-calendar"></span>
            <?=DatePicker::widget([
    'name' => 'alumnosArray['.$i.'][fechaComunion]', 'language' => 'es', 'dateFormat' => 'dd/MM/yyyy','value'=>$alumno[$i]['FechaComunion'],
    'clientOptions' => [
        'changeMonth' => true,
        'changeYear' => true,
        'showButtonPanel' => true,
        'yearRange' => '1929:2019'],
    'options' => ['placeholder' => 'Elija la fecha de comunión', 'readonly' => 'readonly', 'showButtonPanel' => true, 'class' => 'form-control']]);
?>
        </div>
        <div class="col-md-3">
            <?=Html::label('Diosecis Comunion', 'alumnosArray['.$i.'][diosecisComunion]');?>
            <?=Html::input('text', 'alumnosArray['.$i.'][diosecisComunion]', $alumno[$i]['DiosecisComunion'], ['class' => 'form-control']);?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3">
            <?=Html::label('Confirmacion', 'alumnosArray['.$i.'][confirmacion]');?>
            <?=Html::dropDownList('alumnosArray['.$i.'][confirmacion]', $alumno[$i]['Confirmacion'], ['SI' => 'Si', 'NO' => 'No'], ['class' => 'form-control',
    'onchange' => "deshabilitarSacramento('confirmacion',".$i.")"]);?>
        </div>
        <div class="col-md-3">
            <?=Html::label('Lugar de Confirmación', 'alumnosArray['.$i.'][lugarConfirmacion]');?>
            <?=Html::input('text', 'alumnosArray['.$i.'][lugarConfirmacion]', $alumno[$i]['LugarConfirmacion'], ['class' => 'form-control']);?>
        </div>
        <div class="col-md-3">
            <?=Html::label('Fecha de Confirmacion', 'alumnosArray['.$i.'][fechaConfirmacion]');?>
            <span class="glyphicon glyphicon-calendar"></span>
            <?=DatePicker::widget([
    'name' => 'alumnosArray['.$i.'][fechaConfirmacion]', 'language' => 'es', 'dateFormat' => 'dd/MM/yyyy','value'=>$alumno[$i]['FechaConfirmacion'],
    'clientOptions' => [
        'changeMonth' => true,
        'changeYear' => true,
        'showButtonPanel' => true,
        'yearRange' => '1929:2019'],
    'options' => ['placeholder' => 'Elija la fecha de confirmación', 'readonly' => 'readonly', 'showButtonPanel' => true, 'class' => 'form-control']]);
?>
        </div>
        <div class="col-md-3">
            <?=Html::label('Diosecis Confirmacion', 'alumnosArray['.$i.'][diosecisConfirmacion]');?>
            <?=Html::input('text', 'alumnosArray['.$i.'][diosecisConfirmacion]', $alumno[$i]['DiosecisConfirmacion'], ['class' => 'form-control']);?>
        </div>
    </div>
    <br />
    <br /> </div>
   
    
  
    <?php 
    $this->registerJs('deshabilitarSacramento("bautismo",'.$i.')
    deshabilitarSacramento("comunion",'.$i.');
    deshabilitarSacramento("confirmacion",'.$i.');');
    
    }//Fin foreach?>
    
    <input name='padre[tipoDoc]' type="hidden" value=<?php echo $padre['TipoDocPadre'] ?>>
    


<!--</div>-->
<br>
<?php echo Html::button('Realizar inscripcion', ['id'=>'enviarFormulario','class' => 'btn btn-success', 'type' => 'button']); ?>

<?php
ActiveForm::end();
?>