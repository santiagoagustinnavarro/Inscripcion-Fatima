<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\jui\DatePicker;
use yii\bootstrap\Modal;

$this->title = 'Formulario de inscripción';
$this->registerJs($js);
?>
<?=Html::tag('h2','Formulario de Inscripción',['align'=>'center']);?>
<!-------------------------------------Comienzo del formulario-------------------------------------------------------->
<?php


$form = ActiveForm::begin(); 

verificaRegistro($registrado,$provincias);

?>


<!--------------------Fin Formulario----------------------------------------------------->
 <?php  ActiveForm::end();
?>

<?php 
/**
 * Esta funcion imprime según corresponda el formulario si esta o no registrado
 * @param bool $registrado
 * @param array $provincias
 */
    function verificaRegistro($registrado,$provincias){
        if(!$registrado){ //Caso en que el usuario ingresa por primera vez
            sinRegistro($provincias);
        }else{
            conRegistro($provincias);
        }
    }
            ?>      
<?php 

/*******************************************************
 ******************************************************** 
 ******************************************************** 
 ******************************************************** 
 ******************************************************** 
 ******************************************************** 
 *********************Formulario sin registro************
 ******************************************************** 
 ******************************************************** 
 ******************************************************** 
 ******************************************************** 
 ******************************************************** 
 ******************************************************** 
 ******************************************************** 
 */

    function sinRegistro($provincias){
        ?>
        <!----------------------------------Inicio de responsable------------------------------------------------------------->
        <?= Html::tag('h2','Responsable');?>
        <div class="row">
        <div class="col-md-6">
        <?= Html::label('Legajo','responsable[legajo]'); ?>
        <?= Html::input('text','responsable[legajo]','',['class'=>'form-control']); ?>
        </div>
        <div class="col-md-6">
        <?= Html::label('Cuit/cuil','responsable[cuil]'); ?>
        <?= Html::input('text','responsable[cuil]','',['class'=>'form-control']); ?>
        </div>
        </div>
        <?= Html::label('Apellido y nombre','responsable[apellidoYNombre]'); ?>
        <?= Html::input('text','responsable[apellidoYNombre]','',['class'=>'form-control']); ?>
        <div class="row">
        <div class="col-md-2">
        <?= Html::label('Provincia','responsable[provincia]'); ?>
        <?= Html::dropDownList('responsable[provincia]','',$provincias,['class'=>'form-control']);?>
        </div>
        <div class="col-md-2">
        <?= Html::label('Localidad','responsable[localidad]'); ?>
        <?= Html::dropDownList('responsable[localidad]','',[],['class'=>'form-control']); ?>
        </div>
        
        <div class="col-md-2">
        <?= Html::label('Codigo postal','responsable[codigo_postal]'); ?>
        <?= Html::input('number','responsable[codigo_postal]','',['readonly'=>'readonly','class'=>'form-control']); ?>
        </div>
        </div>
        <div class="row">
        <div class="col-md-4">
        <?= Html::label('Calle','responsable[calle]'); ?>
        <?= Html::input('text','responsable[calle]','',['class'=>'form-control']); ?>
        </div>
        
        <div class="col-md-4">
        <?= Html::label('Altura','responsable[altura]'); ?>
        <?= Html::input('number','responsable[altura]','',['class'=>'form-control']); ?>
        </div>
        <div class="col-md-4">
        
        <?= Html::label('Barrio','responsable[barrio]'); ?>
        <?= Html::dropDownList('responsable[barrio]','',[],['class'=>'form-control']);?>
        </div>
        </div>
        <div class="row">
            <div class="col-md-3">
            <?= Html::label('Piso','responsable[piso]'); ?>
            <?= Html::input('number','responsable[piso]','',['class'=>'form-control']); ?>
            </div>
            <div class="col-md-3">
            <?= Html::label('Departamento','responsable[departamento]'); ?>
            <?= Html::input('text','responsable[departamento]','',['class'=>'form-control']); ?>
            </div>
            <div class="col-md-3">
            <?= Html::label('Tira','responsable[tira]'); ?>
            <?= Html::input('text','responsable[tira]','',['class'=>'form-control']); ?>
            </div>
            <div class="col-md-3">
            <?= Html::label('Modulo','responsable[modulo]'); ?>
            <?= Html::input('text','responsable[modulo]','',['class'=>'form-control']); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
            <?= Html::label('Fijo','responsable[telefonoFijo]'); ?>
            <?= Html::input('number','responsable[telefonoFijo]','',['class'=>'form-control']); ?>
            </div>
            <div class="col-md-4">
            <?= Html::label('Movil','responsable[telefonoMovil]'); ?>
            <?= Html::input('number','responsable[telefonoMovil]','',['class'=>'form-control']); ?>
            </div>
        </div>
        
        
        <!------------------------Fin Responsable------------------------------------------>
        <?= Html::tag('hr');?>
        <!--------------------------Inicio Padre---------------------------------------------->
        
        <?= Html::tag('h2','Padre');?>
        <?= Html::label('Apellido y nombre','padre[apellidoYNombre]'); ?>
        <?= Html::input('text','padre[apellidoYNombre]','',['class'=>'form-control']); ?>
        <div class="row">
            <div class="col-md-6">
            <?= Html::label('Ocupación','padre[ocupacion]'); ?>
            <?= Html::input('text','padre[ocupacion]','',['class'=>'form-control']); ?>
            </div>
            <div class="col-md-6">
            <?= Html::label('Cuit/Cuil','padre[cuil]'); ?>
            <?= Html::input('text','padre[cuil]','',['class'=>'form-control']); ?>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-6">
            <?= Html::label('Telefono fijo','padre[telefonoFijo]'); ?>  
             <?= Html::input('number','padre[telefonoFijo]','',['class'=>'form-control']); ?>
            </div>
            <div class="col-md-6">
            <?= Html::label('Telefono Movil','padre[telefonoMovil]'); ?>
            <?= Html::input('number','padre[telefonoMovil]','',['class'=>'form-control']); ?>
            </div>
           
        </div>
        <div class="row">
            <div class="col-md-6">
            <?= Html::label('Lugar de trabajo','padre[lugarTrabajo]'); ?>
            <?= Html::input('text','padre[lugarTrabajo]','',['class'=>'form-control']); ?>
            </div>
            <div class="col-md-6">
            <?= Html::label('Telefono Laboral','padre[telefonoLaboral]'); ?>
            <?= Html::input('number','padre[telefonoLaboral]','',['class'=>'form-control']); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
            <?= Html::label('Fecha de nacimiento','padre[fechaNacimiento]'); ?>
            <span class="glyphicon glyphicon-calendar"></span> 
            <?= DatePicker::widget([
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
            <?= Html::dropDownList('padre[nacionalidad]','',['Argentino','Colombiano','Boliviano','Chileno','Peruano','Venezolano'],['class'=>['form-control']]); ?>
            </div>
        </div>
        <div class="row">
        <div class="col-md-6">
        <?= Html::label('Escuela de egreso primaria','padre[escuelaPrimaria]'); ?>
        <?= Html::dropDownList('padre[escuelaPrimaria]','',['INSF (Ins.Nuestra Señora de Fatima)','ISC(Ins.Santa Catalina)','ISFJ(Ins.San Francisco Javier)'],['class'=>'form-control']); ?>
        </div>
        <div class="col-md-6">
        <?= Html::label('Escuela de egreso secundaria','padre[escuelaSecundaria]'); ?>
        <?= Html::dropDownList('padre[escuelaSecundaria]','',['INSF (Ins.Nuestra Señora de Fatima)','ISC(Ins.Santa Catalina)'],['class'=>'form-control']); ?>
        </div>
        </div>
        <div class="row">
        <div class="col-md-4">
        <?= Html::label('Bautismo','padre[bautismo]'); ?>
        <?=Html::dropDownList('padre[bautismo]','',['Si','No'],['class'=>'form-control']); ?>
        </div>
        <div class="col-md-4">
        <?= Html::label('Comunion','padre[comunion]'); ?>
        <?=Html::dropDownList('padre[comunion]','',['Si','No'],['class'=>'form-control']); ?>
        </div>
        <div class="col-md-4">
        <?= Html::label('Confirmacion','padre[confirmacion]'); ?>
        <?=Html::dropDownList('padre[confirmacion]','',['Si','No'],['class'=>'form-control']); ?>
        </div>
        </div>
        <!-------------------------------- Fin Padre------------------------------------------------------->
        <?=Html::tag('hr');?>
        <!----------------------------------Inicio Madre-------------------------------------------->
        
        <?=Html::tag('h2','Madre');?>
        <?= Html::label('Apellido y nombre','madre[apellidoYNombre]'); ?>
        <?= Html::input('text','madre[apellidoYNombre]','',['class'=>'form-control']); ?>
        <div class="row">
            <div class="col-md-6">
            <?= Html::label('Ocupación','madre[ocupacion]'); ?>
            <?= Html::input('text','madre[ocupacion]','',['class'=>'form-control']); ?>
            </div>
            <div class="col-md-6">
            <?= Html::label('Cuit/Cuil','madre[cuil]'); ?>
            <?= Html::input('text','madre[cuil]','',['class'=>'form-control']); ?>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-6">
            <?= Html::label('Telefono fijo','madre[telefonoFijo]'); ?>  
             <?= Html::input('number','madre[telefonoFijo]','',['class'=>'form-control']); ?>
            </div>
            <div class="col-md-6">
            <?= Html::label('Telefono Movil','madre[telefonoMovil]'); ?>
            <?= Html::input('number','madre[telefonoMovil]','',['class'=>'form-control']); ?>
            </div>
           
        </div>
        <div class="row">
            <div class="col-md-6">
            <?= Html::label('Lugar de trabajo','madre[lugarTrabajo]'); ?>
            <?= Html::input('text','madre[lugarTrabajo]','',['class'=>'form-control']); ?>
            </div>
            <div class="col-md-6">
            <?= Html::label('Telefono Laboral','madre[telefonoLaboral]'); ?>
            <?= Html::input('number','madre[telefonoLaboral]','',['class'=>'form-control']); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
            <?= Html::label('Fecha de nacimiento','madre[fechaNacimiento]'); ?>
            <span class="glyphicon glyphicon-calendar"></span> 
            <?= DatePicker::widget([
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
            <?= Html::dropDownList('madre[nacionalidad]','',['Argentino','Colombiano','Boliviano','Chileno','Peruano','Venezolano'],['class'=>['form-control']]); ?>
            </div>
        </div>
        <div class="row">
        <div class="col-md-6">
        <?= Html::label('Escuela de egreso primaria','madre[escuelaPrimaria]'); ?>
        <?= Html::dropDownList('madre[escuelaPrimaria]','',['INSF (Ins.Nuestra Señora de Fatima)','ISC(Ins.Santa Catalina)','ISFJ(Ins.San Francisco Javier)'],['class'=>'form-control']); ?>
        </div>
        <div class="col-md-6">
        <?= Html::label('Escuela de egreso secundaria','madre[escuelaSecundaria]'); ?>
        <?= Html::dropDownList('madre[escuelaSecundaria]','',['INSF (Ins.Nuestra Señora de Fatima)','ISC(Ins.Santa Catalina)'],['class'=>'form-control']); ?>
        </div>
        </div>
        <div class="row">
        <div class="col-md-4">
        <?= Html::label('Bautismo','madre[bautismo]'); ?>
        <?=Html::dropDownList('madre[bautismo]','',['Si','No'],['class'=>'form-control']); ?>
        </div>
        <div class="col-md-4">
        <?= Html::label('Comunion','madre[comunion]'); ?>
        <?=Html::dropDownList('madre[comunion]','',['Si','No'],['class'=>'form-control']); ?>
        </div>
        <div class="col-md-4">
        <?= Html::label('Confirmacion','madre[confirmacion]'); ?>
        <?=Html::dropDownList('madre[confirmacion]','',['Si','No'],['class'=>'form-control']); ?>
        </div>
        </div>
        <!--------------------Fin madre----------------------------------------------------->
        <?=Html::tag('hr');?>
        <!--------------------Inicio Alumno----------------------------------------------------->
        <?=Html::tag('h2','Alumno');?>
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
            <?=Html::dropDownList('alumno[sexo]','',['Masculino','Femenino'],['class'=>'form-control']); ?>
            </div>
        </div>
        <div class="row">
        <div class="col-md-4">
            <?= Html::label('Seccion','alumno[seccion]'); ?>
            <?=Html::dropDownList('alumno[seccion]','',['A'=>'A','B'=>'B','C'=>'C','D'=>'D','E'=>'E'],['class'=>'form-control']); ?>
        </div>
        <div class="col-md-4">
            <?= Html::label('Nivel','alumno[nivel]'); ?>
            <?=Html::dropDownList('alumno[nivel]','',[],['class'=>'form-control']); ?>
        </div>
        <div class="col-md-4">
            <?= Html::label('Sala/Grado/Curso','alumno[grado]'); ?>
            <?=Html::dropDownList('alumno[grado]','',[],['class'=>'form-control']); ?>
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
        <div class="col-md-4">
        <?= Html::label('Bautismo','alumno[bautismo]'); ?>
        <?=Html::dropDownList('alumno[bautismo]','',['Si'=>'Si','No'=>'No'],['class'=>'form-control']); ?>
        </div>
        <div class="col-md-4">
        <?= Html::label('Lugar de bautismo','alumno[lugarBautismo]'); ?>
        <?=Html::input('text','alumno[lugarBautismo]','',['class'=>'form-control']); ?>
        </div>
        <div class="col-md-4">
            <?= Html::label('Fecha de Bautismo','alumno[fechaBautismo]'); ?>
            <span class="glyphicon glyphicon-calendar"></span> 
            <?= DatePicker::widget([
               'name'=>'alumno[fechaBautismo]','language' => 'es','dateFormat' => 'dd/MM/yyyy',
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
        <div class="col-md-4">
        <?= Html::label('Comunion','alumno[comunion]'); ?>
        <?=Html::dropDownList('alumno[comunion]','',['Si'=>'Si','No'=>'No'],['class'=>'form-control']); ?>
        </div>
        <div class="col-md-4">
        <?= Html::label('Lugar de Comunion','alumno[lugarComunion]'); ?>
        <?=Html::input('text','alumno[lugarComunion]','',['class'=>'form-control']); ?>
        </div>
        <div class="col-md-4">
            <?= Html::label('Fecha de Comunion','alumno[fechaComunion]'); ?>
            <span class="glyphicon glyphicon-calendar"></span> 
            <?= DatePicker::widget([
               'name'=>'alumno[fechaComunion]','language' => 'es','dateFormat' => 'dd/MM/yyyy',
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
        <div class="col-md-4">
        <?= Html::label('Confirmacion','alumno[confirmacion]'); ?>
        <?=Html::dropDownList('alumno[confirmacion]','',['Si'=>'Si','No'=>'No'],['class'=>'form-control']); ?>
        </div>
        <div class="col-md-4">
        <?= Html::label('Lugar de Confirmación','alumno[lugarConfirmacion]'); ?>
        <?=Html::input('text','alumno[lugarConfirmacion]','',['class'=>'form-control']); ?>
        </div>
        <div class="col-md-4">
            <?= Html::label('Fecha de Confirmacion','alumno[fechaConfirmacion]'); ?>
            <span class="glyphicon glyphicon-calendar"></span> 
            <?= DatePicker::widget([
               'name'=>'alumno[fechaConfirmacion]','language' => 'es','dateFormat' => 'dd/MM/yyyy',
               'clientOptions'=>[
               'changeMonth' => true, 
               'changeYear' => true, 
               'showButtonPanel' => true, 
               'yearRange' => '1929:2019'],
               'options'=>['placeholder'=>'Elija la fecha de egreso','readonly'=>'readonly', 'showButtonPanel' => true,'class'=>'form-control']]);
               ?>
            </div>
        </div>
        <?php 
        
        
          
        
        echo Html::input('button','nuevoAlumno','Cargar un alumno',['class'=>'btn btn-info']);
    }



    /************************************************************************
 ****************************************************************************
 **************************************************************************** 
 ****************************************************************************
 **************************************************************************** 
 **************************************************************************** 
 *********************************** Formulario con registro****************
 **************************************************************************** 
 **************************************************************************** 
 **************************************************************************** 
 **************************************************************************** 
 **************************************************************************** 
 **************************************************************************** 
 **************************************************************************** 
 */
    function conRegistro($provincias){ 
        ?>
        <!----------------------------------Inicio de responsable------------------------------------------------------------->
            <?= Html::tag('h2','Responsable');?>
            <div class="row">
            <div class="col-md-6">
            <?= Html::label('Legajo','responsable[legajo]'); ?>
            <?= Html::input('text','responsable[legajo]','FAT-313',['class'=>'form-control']); ?>
            </div>
            <div class="col-md-6">
            <?= Html::label('Cuit/cuil','responsable[cuil]'); ?>
            <?= Html::input('text','responsable[cuil]','80092',['class'=>'form-control']); ?>
            </div>
            </div>
            <?= Html::label('Apellido y nombre','responsable[apellidoYNombre]'); ?>
            <?= Html::input('text','responsable[apellidoYNombre]','Hernesto Guevara',['class'=>'form-control']); ?>
            <div class="row">
            <div class="col-md-2">
            <?= Html::label('Provincia','responsable[provincia]'); ?>
            <?= Html::dropDownList('responsable[provincia]','Neuquen',$provincias,['class'=>'form-control']);?>
            </div>
            <div class="col-md-2">
            <?= Html::label('Localidad','responsable[localidad]'); ?>
            <?= Html::dropDownList('responsable[localidad]','Neuquén',['Neuquen'],['class'=>'form-control']); ?>
            </div>
            
            <div class="col-md-2">
            <?= Html::label('Codigo postal','responsable[codigo_postal]'); ?>
            <?= Html::input('number','responsable[codigo_postal]','8300',['readonly'=>'readonly','class'=>'form-control']); ?>
            </div>
            </div>
            <div class="row">
            <div class="col-md-4">
            <?= Html::label('Calle','responsable[calle]'); ?>
            <?= Html::input('text','responsable[calle]','Islas Malvinas',['class'=>'form-control']); ?>
            </div>
            
            <div class="col-md-4">
            <?= Html::label('Altura','responsable[altura]'); ?>
            <?= Html::input('number','responsable[altura]','5300',['class'=>'form-control']); ?>
            </div>
            <div class="col-md-4">
            
            <?= Html::label('Barrio','responsable[barrio]'); ?>
            <?= Html::dropDownList('responsable[barrio]','9',['Ciudad Industrial Jaime de Nevares',
    'Valentina Norte Rural',
    'Valentina Norte Urbana',
    'Esfuerzo',
    'Hi.Be.Pa',
    'Cuenca XV',
    'Gran Neuquén Norte',
    'Gran Neuquén Sur',
    'San Lorenzo Norte',
    'San Lorenzo Sur',
    'Canal V',
    'Melipal',
    'Unión de Mayo',
    'Huilliches',
    'Gregorio Álvarez',
    'El Progreso',
    'Villa Ceferino',
    'Bardas Soleadas',
    'Islas Malvinas',
    'Cumelen',
    'Bouquet Roldán',
    'Terrazas Neuquén',
    'Alta Barda',
    'Área Centro Oeste',
    'Área Centro Sur',
    '14 De Octubre/Co.Pol.',
    'Área Centro Este',
    'Rincón De Emilio',
    'Santa Genoveva',
    'Villa Farrell',
    'Mariano Moreno',
    'Provincias Unidas',
    'Sapere, Aníbal',
    'Valentina Sur Rural',
    'Valentina Sur Urbana',
    'Militar',
    'La Sirena',
    'Altos del Limay',
    'Villa Florencia',
    'Don Bosco III',
    'Don Bosco II',
    'Limay',
    'Nuevo, Barrio',
    'Villa María',
    'Río Grande',
    'Belgrano, Manuel',
    'Confluencia Urbana',
    'Confluencia Rural'
    ],['class'=>'form-control']);?>
            </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                <?= Html::label('Piso','responsable[piso]'); ?>
                <?= Html::input('number','responsable[piso]','Ninguno',['class'=>'form-control']); ?>
                </div>
                <div class="col-md-3">
                <?= Html::label('Departamento','responsable[departamento]'); ?>
                <?= Html::input('text','responsable[departamento]','Ninguno',['class'=>'form-control']); ?>
                </div>
                <div class="col-md-3">
                <?= Html::label('Tira','responsable[tira]'); ?>
                <?= Html::input('text','responsable[tira]','Ninguno',['class'=>'form-control']); ?>
                </div>
                <div class="col-md-3">
                <?= Html::label('Modulo','responsable[modulo]'); ?>
                <?= Html::input('text','responsable[modulo]','Ninguno',['class'=>'form-control']); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                <?= Html::label('Fijo','responsable[telefonoFijo]'); ?>
                <?= Html::input('number','responsable[telefonoFijo]','02972491632',['class'=>'form-control']); ?>
                </div>
                <div class="col-md-4">
                <?= Html::label('Movil','responsable[telefonoMovil]'); ?>
                <?= Html::input('number','responsable[telefonoMovil]','299463851',['class'=>'form-control']); ?>
                </div>
            </div>
            
            
            <!------------------------Fin Responsable------------------------------------------>
            <?= Html::tag('hr');?>
            <!--------------------------Inicio Padre---------------------------------------------->
            
            <?= Html::tag('h2','Padre');?>
            <?= Html::label('Apellido y nombre','padre[apellidoYNombre]'); ?>
            <?= Html::input('text','padre[apellidoYNombre]','Navarro Hernesto Agustin',['class'=>'form-control']); ?>
            <div class="row">
                <div class="col-md-6">
                <?= Html::label('Ocupación','padre[ocupacion]'); ?>
                <?= Html::input('text','padre[ocupacion]','Profesor',['class'=>'form-control']); ?>
                </div>
                <div class="col-md-6">
                <?= Html::label('Cuit/Cuil','padre[cuil]'); ?>
                <?= Html::input('text','padre[cuil]','20658798767',['class'=>'form-control']); ?>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                <?= Html::label('Telefono fijo','padre[telefonoFijo]'); ?>  
                 <?= Html::input('number','padre[telefonoFijo]','02972857421',['class'=>'form-control']); ?>
                </div>
                <div class="col-md-6">
                <?= Html::label('Telefono Movil','padre[telefonoMovil]'); ?>
                <?= Html::input('number','padre[telefonoMovil]','2998071457',['class'=>'form-control']); ?>
                </div>
               
            </div>
            <div class="row">
                <div class="col-md-6">
                <?= Html::label('Lugar de trabajo','padre[lugarTrabajo]'); ?>
                <?= Html::input('text','padre[lugarTrabajo]','Neuquen',['class'=>'form-control']); ?>
                </div>
                <div class="col-md-6">
                <?= Html::label('Telefono Laboral','padre[telefonoLaboral]'); ?>
                <?= Html::input('number','padre[telefonoLaboral]','02972658962',['class'=>'form-control']); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                <?= Html::label('Fecha de nacimiento','padre[fechaNacimiento]'); ?>
                <span class="glyphicon glyphicon-calendar"></span> 
                <?= DatePicker::widget(['value'=>'14/08/1975',
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
                <?= Html::dropDownList('padre[nacionalidad]','',['Argentino','Colombiano','Boliviano','Chileno','Peruano','Venezolano'],['class'=>['form-control']]); ?>
                </div>
            </div>
            <div class="row">
            <div class="col-md-6">
            <?= Html::label('Escuela de egreso primaria','padre[escuelaPrimaria]'); ?>
            <?= Html::dropDownList('padre[escuelaPrimaria]','',['INSF (Ins.Nuestra Señora de Fatima)','ISC(Ins.Santa Catalina)','ISFJ(Ins.San Francisco Javier)'],['class'=>'form-control']); ?>
            </div>
            <div class="col-md-6">
            <?= Html::label('Escuela de egreso secundaria','padre[escuelaSecundaria]'); ?>
            <?= Html::dropDownList('padre[escuelaSecundaria]','',['INSF (Ins.Nuestra Señora de Fatima)','ISC(Ins.Santa Catalina)'],['class'=>'form-control']); ?>
            </div>
            </div>
            <div class="row">
            <div class="col-md-4">
            <?= Html::label('Bautismo','padre[bautismo]'); ?>
            <?=Html::dropDownList('padre[bautismo]','',['Si','No'],['class'=>'form-control']); ?>
            </div>
            <div class="col-md-4">
            <?= Html::label('Comunion','padre[comunion]'); ?>
            <?=Html::dropDownList('padre[comunion]','',['Si','No'],['class'=>'form-control']); ?>
            </div>
            <div class="col-md-4">
            <?= Html::label('Confirmacion','padre[confirmacion]'); ?>
            <?=Html::dropDownList('padre[confirmacion]','',['Si','No'],['class'=>'form-control']); ?>
            </div>
            </div>
            <!-------------------------------- Fin Padre------------------------------------------------------->
            <?=Html::tag('hr');?>
            <!----------------------------------Inicio Madre-------------------------------------------->
            
            <?=Html::tag('h2','Madre');?>
            <?= Html::label('Apellido y nombre','madre[apellidoYNombre]'); ?>
            <?= Html::input('text','madre[apellidoYNombre]','Susana Isla',['class'=>'form-control']); ?>
            <div class="row">
                <div class="col-md-6">
                <?= Html::label('Ocupación','madre[ocupacion]'); ?>
                <?= Html::input('text','madre[ocupacion]','Farmaceútica',['class'=>'form-control']); ?>
                </div>
                <div class="col-md-6">
                <?= Html::label('Cuit/Cuil','madre[cuil]'); ?>
                <?= Html::input('text','madre[cuil]','1847598766',['class'=>'form-control']); ?>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                <?= Html::label('Telefono fijo','madre[telefonoFijo]'); ?>  
                 <?= Html::input('number','madre[telefonoFijo]','02972854789',['class'=>'form-control']); ?>
                </div>
                <div class="col-md-6">
                <?= Html::label('Telefono Movil','madre[telefonoMovil]'); ?>
                <?= Html::input('number','madre[telefonoMovil]','2944611396',['class'=>'form-control']); ?>
                </div>
               
            </div>
            <div class="row">
                <div class="col-md-6">
                <?= Html::label('Lugar de trabajo','madre[lugarTrabajo]'); ?>
                <?= Html::input('text','madre[lugarTrabajo]','Cipolletti',['class'=>'form-control']); ?>
                </div>
                <div class="col-md-6">
                <?= Html::label('Telefono Laboral','madre[telefonoLaboral]'); ?>
                <?= Html::input('number','madre[telefonoLaboral]','02972845732',['class'=>'form-control']); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                <?= Html::label('Fecha de nacimiento','madre[fechaNacimiento]'); ?>
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
                <?= Html::dropDownList('madre[nacionalidad]','',['Argentino','Colombiano','Boliviano','Chileno','Peruano','Venezolano'],['class'=>['form-control']]); ?>
                </div>
            </div>
            <div class="row">
            <div class="col-md-6">
            <?= Html::label('Escuela de egreso primaria','madre[escuelaPrimaria]'); ?>
            <?= Html::dropDownList('madre[escuelaPrimaria]','',['INSF (Ins.Nuestra Señora de Fatima)','ISC(Ins.Santa Catalina)','ISFJ(Ins.San Francisco Javier)'],['class'=>'form-control']); ?>
            </div>
            <div class="col-md-6">
            <?= Html::label('Escuela de egreso secundaria','madre[escuelaSecundaria]'); ?>
            <?= Html::dropDownList('madre[escuelaSecundaria]','',['INSF (Ins.Nuestra Señora de Fatima)','ISC(Ins.Santa Catalina)'],['class'=>'form-control']); ?>
            </div>
            </div>
            <div class="row">
            <div class="col-md-4">
            <?= Html::label('Bautismo','madre[bautismo]'); ?>
            <?=Html::dropDownList('madre[bautismo]','',['Si','No'],['class'=>'form-control']); ?>
            </div>
            <div class="col-md-4">
            <?= Html::label('Comunion','madre[comunion]'); ?>
            <?=Html::dropDownList('madre[comunion]','',['Si','No'],['class'=>'form-control']); ?>
            </div>
            <div class="col-md-4">
            <?= Html::label('Confirmacion','madre[confirmacion]'); ?>
            <?=Html::dropDownList('madre[confirmacion]','',['Si','No'],['class'=>'form-control']); ?>
            </div>
            </div>
            <!--------------------Fin madre----------------------------------------------------->
            <?=Html::tag('hr');?>
            <!--------------------Inicio Alumno----------------------------------------------------->
            
         
            <?=Html::tag('h2','Alumno');?>
            <?php
            echo Html::label('Alumnos','alumnos');
            echo Html::dropDownList('alumnos','',['Elija un alumno','Jose Alberto Navarro'=>'Jose Alberto Navarro','nuevo'=>'Ingrese uno nuevo'],['class'=>'form-control']);
            
            ?>
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
                <?=Html::dropDownList('alumno[sexo]','',['Masculino','Femenino'],['class'=>'form-control']); ?>
                </div>
            </div>
            <div class="row">
            <div class="col-md-4">
                <?= Html::label('Seccion','alumno[seccion]'); ?>
                <?=Html::dropDownList('alumno[seccion]','',['A'=>'A','B'=>'B','C'=>'C','D'=>'D','E'=>'E'],['class'=>'form-control']); ?>
            </div>
            <div class="col-md-4">
                <?= Html::label('Nivel','alumno[nivel]'); ?>
                <?=Html::dropDownList('alumno[nivel]','',[],['class'=>'form-control']); ?>
            </div>
            <div class="col-md-4">
                <?= Html::label('Sala/Grado/Curso','alumno[grado]'); ?>
                <?=Html::dropDownList('alumno[grado]','',[],['class'=>'form-control']); ?>
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
            <div class="col-md-4">
            <?= Html::label('Bautismo','alumno[bautismo]'); ?>
            <?=Html::dropDownList('alumno[bautismo]','',['Si'=>'Si','No'=>'No'],['class'=>'form-control']); ?>
            </div>
            <div class="col-md-4">
            <?= Html::label('Lugar de bautismo','alumno[lugarBautismo]'); ?>
            <?=Html::input('text','alumno[lugarBautismo]','',['class'=>'form-control']); ?>
            </div>
            <div class="col-md-4">
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
            </div>
            <div class="row">
            <div class="col-md-4">
            <?= Html::label('Comunion','alumno[comunion]'); ?>
            <?=Html::dropDownList('alumno[comunion]','',['Si'=>'Si','No'=>'No'],['class'=>'form-control']); ?>
            </div>
            <div class="col-md-4">
            <?= Html::label('Lugar de Comunion','alumno[lugarComunion]'); ?>
            <?=Html::input('text','alumno[lugarComunion]','',['class'=>'form-control']); ?>
            </div>
            <div class="col-md-4">
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
            </div>
            <div class="row">
            <div class="col-md-4">
            <?= Html::label('Confirmacion','alumno[confirmacion]'); ?>
            <?=Html::dropDownList('alumno[confirmacion]','',['Si'=>'Si','No'=>'No'],['class'=>'form-control']); ?>
            </div>
            <div class="col-md-4">
            <?= Html::label('Lugar de Confirmación','alumno[lugarConfirmacion]'); ?>
            <?=Html::input('text','alumno[lugarConfirmacion]','',['class'=>'form-control']); ?>
            </div>
            <div class="col-md-4">
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
            </div>
                   <?php 
                   
                
         Modal::begin([
            'header'=>'<h4>Información</h4>',
            'id'=>'modal',
            'size'=>'modal-lg',
         ]);

        echo "<div id='modalContent'>Datos actualizados correctamente</div>";
        Modal::end();
        echo  Html::input('button','Aceptar','Aceptar',['class'=>'btn btn-success']);?>  </div> <?php
    }
?>


    









