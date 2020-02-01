<?php 
    namespace app\controllers;

    use Yii;
    use yii\filters\AccessControl;
    use yii\web\Controller;
    use yii\web\Response;
    use yii\filters\VerbFilter;
    use app\models\LoginForm;
    use app\models\ContactForm;
    use app\models\ODEOContacto;
    use app\models\Pais;
    use app\models\ODEOAlumno;
    use app\models\ODEONivel;
    use app\models\ODEOGrado;
    use app\models\ODEODivision;
    use app\models\ODEOCliente;
    use app\models\Provincia;
    use app\models\Localidad;
    use app\models\ContactoCaracteristica;
    use app\models\ProvinciaLocal;
    use app\models\CiudadLocal;
    class InscripcionController extends Controller{

        /**
         * Funcion encargada de recibir un legajo y en base al mismo mostrar datos
         */
        function actionTraerdatos($id=""){
            if($id!=""){
                
                $localidadModel=new Localidad();
                //Trae todos los alumnos según el legajo ingresado
                $alumno=Yii::$app->db->createCommand("select a.ODEO_AlumnoKey,c.ClienteKey, a.Apellido, a.Nombre,
                d.Nombre as Division, g.Nombre as Grado, n.Nombre as Nivel,
                a.NumeroDocumento, a.FechaNacimiento, a.Sexo,
                a.FechaIngreso,
                case when bautismo.Variante is null then 'NO' else 'SI' end as Bautismo,
                bautismo.Variante as LugarBautismo,
                diosecisBautismo.Variante as DiosecisBautismo,
                fechaBautismo.Variante as FechaBautismo,
                case when comunion.Variante is null then 'NO' else 'SI' end as Comunion,
                comunion.Variante as LugarComunion,
                diosecisComunion.Variante as DiosecisComunion,
                fechaComunion.Variante as FechaComunion,
                case when confirmacion.Variante is null then 'NO' else 'SI' end as Confirmacion,
                confirmacion.Variante as LugarConfirmacion,
                diosecisConfirmacion.Variante as DiosecisConfirmacion,
                fechaConfirmacion.Variante as FechaConfirmacion,
                '' as LugarNacimiento
                from Cliente c
                join ODEO_FamiliaIntegrante f on (c.ClienteKey = f.ClienteKey)
                join ODEO_Alumno a on (f.ODEO_AlumnoKey = a.ODEO_AlumnoKey)
                join ODEO_Division d on (a.ODEO_DivisionKey = d.ODEO_DivisionKey)
                join ODEO_Grado g on (d.ODEO_GradoKey = g.ODEO_GradoKey)
                join ODEO_Nivel n on (g.ODEO_NivelKey = n.ODEO_NivelKey)
                left join ODEO_AlumnoCaracteristica bautismo on (a.ODEO_AlumnoKey = bautismo.ODEO_AlumnoKey) and (bautismo.CaracteristicaKey = 1)
                left join ODEO_AlumnoCaracteristica diosecisBautismo on (a.ODEO_AlumnoKey = diosecisBautismo.ODEO_AlumnoKey) and (diosecisBautismo.CaracteristicaKey = 2)
                left join ODEO_AlumnoCaracteristica fechaBautismo on (a.ODEO_AlumnoKey = fechaBautismo.ODEO_AlumnoKey) and (diosecisBautismo.CaracteristicaKey = 3)
                left join ODEO_AlumnoCaracteristica comunion on (a.ODEO_AlumnoKey = comunion.ODEO_AlumnoKey) and (comunion.CaracteristicaKey = 4)
                left join ODEO_AlumnoCaracteristica diosecisComunion on (a.ODEO_AlumnoKey = diosecisComunion.ODEO_AlumnoKey) and (diosecisComunion.CaracteristicaKey = 5)
                left join ODEO_AlumnoCaracteristica fechaComunion on (a.ODEO_AlumnoKey = fechaComunion.ODEO_AlumnoKey) and (diosecisBautismo.CaracteristicaKey = 6)
                left join ODEO_AlumnoCaracteristica confirmacion on (a.ODEO_AlumnoKey = confirmacion.ODEO_AlumnoKey) and (confirmacion.CaracteristicaKey = 7)
                left join ODEO_AlumnoCaracteristica diosecisConfirmacion on (a.ODEO_AlumnoKey = diosecisConfirmacion.ODEO_AlumnoKey) and (diosecisConfirmacion.CaracteristicaKey = 8)
                left join ODEO_AlumnoCaracteristica fechaConfirmacion on (a.ODEO_AlumnoKey = fechaConfirmacion.ODEO_AlumnoKey) and (fechaConfirmacion.CaracteristicaKey = 9)
                where a.vigente = 1 and legajo=$id
                order by c.ClienteKey")->queryAll();
                $responsable=ODEOCliente::find()->select(['loc.localidadkey','cliente.numeroDocumento','cliente.clientekey','cliente.codigo','cliente.razonsocial as titular','cliente.cuit','cliente.domicilio as domiciliotitular','isNull(cliente.CodigoPostal, \'\') + \' - \' + cliente.Localidad as LocalidadTitular','prov.nombre as provinciatitular','loc.codigopostal as cptitular','prov.provinciakey','cliente.telefono as teltitular','cliente.telefonomovil as celtitular','cliente.email as emailtitular'])->innerJoin('localidad as loc','cliente.localidadkey=loc.localidadkey')->innerJoin('provincia as prov','prov.provinciakey=loc.provinciakey')->where(['cliente.codigo'=>$id])->andWhere('cliente.clientekey in (select clientekey from V_ODEO_TitularesVigentes)')->OrderBy('cliente.clientekey','desc')->asArray()->one();
                //Verifica cuales son los alumnos activos para dejarlos en el formulario,el resto permanece oculto
                if($alumno!=null){
                    for($i=0;$i++;$i<count($alumno)){
                        if($alumno[$i]['activo']==0){
                            unset($alumno[$i]);
                        }
                    }
                   
                $paises=Pais::find()->select(['*'])->asArray()->all();//Array con todos los paises
                //Trae datos del padre
                $padre=Yii::$app->db->createCommand(" select cp.RazonSocial as NombrePadre, cp.NumeroDocumento as DocumentoPadre,
                cp.Telefono as TelefonoPadre,
                cp.Celular as CelularPadre,
                cp.Puesto as PuestoPadre, cp.Email as EmailPadre,
                cp.Domicilio as DomicilioLaboralPadre,
                cp.FechaNacimiento as FechaNacimientoPadre,
                cp.TelefonoParticular as TelefonoParticularPadre,
                pp.Nombre as NacionalidadPadre,
                cpPrimaria.Valor as PrimariaPadre, cpSecundaria.Valor as SecundariaPadre,
                cpBautismo.Valor as BautismoPadre,
                cpComunion.Valor as ComunionPadre,
                cpConfirmacion.Valor as ConfirmacionPadre from Cliente c
                join V_ODEO_TitularesVigentes v on (c.ClienteKey = v.ClienteKey) left join Contacto cp on (c.ClienteKey = cp.ClienteKey) and (cp.TipoContactoKey = 1)
                left join Pais pp on (cp.PaisNacimientoKey = pp.PaisKey) left join Localidad loc on (c.LocalidadKey = loc.LocalidadKey)
                left join Provincia prov on (loc.ProvinciaKey = prov.ProvinciaKey)
                left join ContactoCaracteristica cpPrimaria on (cp.ContactoKey= cpPrimaria.ContactoKey) and (cpPrimaria.CaracteristicaKey = 18) left join ContactoCaracteristica cpSecundaria on (cp.ContactoKey= cpSecundaria.ContactoKey) and (cpSecundaria.CaracteristicaKey = 19)
                left join ContactoCaracteristica cpBautismo on (cp.ContactoKey= cpBautismo.ContactoKey) and (cpBautismo.CaracteristicaKey = 13)
                left join ContactoCaracteristica cpComunion on (cp.ContactoKey= cpComunion.ContactoKey) and (cpComunion.CaracteristicaKey = 14)
                left join ContactoCaracteristica cpConfirmacion on (cp.ContactoKey= cpConfirmacion.ContactoKey) and (cpConfirmacion.CaracteristicaKey = 15) join ODEO_FamiliaIntegrante f on (c.ClienteKey = f.ClienteKey)  
                where f.ODEO_AlumnoKey in (select  ODEO_Alumno.ODEO_alumnoKey from  ODEO_Alumno where legajo=$id)
                order by NombrePadre" )->queryOne();
                //Trae datos de la madre
                $madre=Yii::$app->db->createCommand(" select cm.RazonSocial as NombreMadre, cm.NumeroDocumento as DocumentoMadre,
                cm.Telefono as TelefonoMadre,
                cm.Celular as CelularMadre,
                cm.Puesto as PuestoMadre, cm.Email as EmailMadre,
                cm.Domicilio as DomicilioLaboralMadre,
                cm.FechaNacimiento as FechaNacimientoMadre,
                cm.TelefonoParticular as TelefonoParticularMadre,
                pp.Nombre as NacionalidadMadre,
                cmPrimaria.Valor as PrimariaMadre, cmSecundaria.Valor as SecundariaMadre,
                cmBautismo.Valor as BautismoMadre,
                cmComunion.Valor as ComunionMadre,
                cmConfirmacion.Valor as ConfirmacionMadre from Cliente c
                join V_ODEO_TitularesVigentes v on (c.ClienteKey = v.ClienteKey) left join Contacto cm on (c.ClienteKey = cm.ClienteKey) and (cm.TipoContactoKey = 2)
                left join Pais pp on (cm.PaisNacimientoKey = pp.PaisKey) left join Localidad loc on (c.LocalidadKey = loc.LocalidadKey)
                left join Provincia prov on (loc.ProvinciaKey = prov.ProvinciaKey)
                left join ContactoCaracteristica cmPrimaria on (cm.ContactoKey= cmPrimaria.ContactoKey) and (cmPrimaria.CaracteristicaKey = 18) left join ContactoCaracteristica cmSecundaria on (cm.ContactoKey= cmSecundaria.ContactoKey) and (cmSecundaria.CaracteristicaKey = 19)
                left join ContactoCaracteristica cmBautismo on (cm.ContactoKey= cmBautismo.ContactoKey) and (cmBautismo.CaracteristicaKey = 13)
                left join ContactoCaracteristica cmComunion on (cm.ContactoKey= cmComunion.ContactoKey) and (cmComunion.CaracteristicaKey = 14)
                left join ContactoCaracteristica cmConfirmacion on (cm.ContactoKey= cmConfirmacion.ContactoKey) and (cmConfirmacion.CaracteristicaKey = 15) join ODEO_FamiliaIntegrante f on (c.ClienteKey = f.ClienteKey)  
                where f.ODEO_AlumnoKey in (select  ODEO_Alumno.ODEO_alumnoKey from  ODEO_Alumno where legajo=$id)
                order by NombreMadre")->queryOne();
               $nivelModel=new ODEONivel();
                $provinciaModel=new Provincia();
              $this->layout='vacio';
                return $this->render('inscripcionExistente',['nivelModel'=>$nivelModel,'alumno'=>$alumno,'localidadModel'=>$localidadModel,'responsable'=>$responsable,'paises'=>$paises,'padre'=>$padre,'madre'=>$madre,'provinciaModel'=>$provinciaModel]);
            }else{//Caso en que el legajo que se ingreso no esta en la BD
                
            }   
            }else{//Caso en que el legajo no fue ingresado
                $provinciasModel= new ProvinciaLocal();
                $localidadModel=new CiudadLocal();
                $provincias=$provinciasModel->find()->select('*')->all();
                $this->layout='vacio';
                return $this->render('index',['provincias'=>$provincias,'provinciaModel'=>$provinciasModel,'localidadModel'=>$localidadModel]);
            }
        }
       /**
        * Función que actualiza los datos de la familia
        *y de ser necesario realiza insercion de datos
        */
        function actionRealizarinscripcion(){
            $idAlumno=$_POST['alumnos'];
            if($idAlumno==""){//Nuevo alumno a insertar

            }else{//Alumno existente se actualizan los datos
                $nombreAlumno=$_POST['alumno']['nombre'];
                $apellidoAlumno=$_POST['alumno']['apellidos'];
                $sexoAlumno=$_POST['alumno']['sexo'];
                $dniAlumno=$_POST['alumno']['dni'];
                $divisionAlumno=$_POST['alumno']['seccion'];
                $nacimientoAlumno=$_POST['alumno']['lugarNacimiento'];
                $alumnoActual=ODEOAlumno::findOne($idAlumno);
                $alumnoActual->Nombre=$nombreAlumno;
                $alumnoActual->Apellido=$nombreAlumno;
                $alumnoActual->NumeroDocumento=$dniAlumno; 
                $alumnoActual->Sexo=$sexoAlumno;
                $alumnoActual->LocalidadNacimientoKey=$nacimientoAlumno;
                $alumnoActual->ODEO_DivisionKey=$divisionAlumno;
                if($alumnoActual->update(false)){
                
                

                }else{
                    echo "no";
                }
         

            }
            



        }


function actionIndex($id=""){
  
    return $this->render("inscripcion_form",['id'=>$id]);
}


/*///////////////////////////////FUNCIONES INVOCADAS DESDE EL FORMULARIO POR AJAX/////////////////////////////////////
/////////////////////////////////(TRAEN DATOS AL FORMULARIO DE INSCRIPCION AL HACER CLICK EN LOS CAMPOS)//////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
*/
        function actionTraerlocalidad(){
            $idLocalidad=$_POST['idLocalidad'];
            $localidades=Localidad::find()->select(['*'])->where(['LocalidadKey'=>$idLocalidad])->asArray()->all();
            return json_encode($localidades);
        }
        function actionLocalidades(){
            $idProvincia=$_POST['idProvincia'];
            $localidades=Localidad::find()->select(['*'])->where(['ProvinciaKey'=>$idProvincia])->asArray()->all();
            return json_encode($localidades);
        }
      /*  function actionTraeralumno(){
            $idAlumno=$_POST['ODEO_alumnoKey'];
            $alumno=ODEOAlumno::find()->select(['*'])->where(['ODEO_AlumnoKey'=>$idAlumno])->asArray()->all();
            return json_encode($alumno);
        }*/
        function actionTraergrado(){
            $nivel=$_POST['ODEO_nivelKey'];
            $grados=ODEOGrado::find()->select(['*'])->where(['ODEO_NivelKey'=>$nivel])->asArray()->all();
            return json_encode($grados);

        }
        function actionTraerdivision(){
            $grado=$_POST['ODEO_gradoKey'];
            $divisiones=ODEODivision::find()->select(['*'])->where(['ODEO_GradoKey'=>$grado])->asArray()->all();
            return json_encode($divisiones);

        }
        function actionDivisionasignada($grado,$nivel){
            $divisiones=ODEODivision::find()->where(['ODEO_GradoKey'=>$grado])->asArray()->all();
            $grados=ODEOGrado::find()->where(['ODEO_NivelKey'=>$nivel])->asArray()->all();
            $niveles=ODEONivel::find()->asArray()->all();
            $array=["divisiones"=>$divisiones,"grados"=>$grados,"niveles"=>$niveles];
            return json_encode($array);
           
        }

        function actionTraeralumnocompleto(){
            $idAlumno=$_POST['ODEO_alumnoKey'];
           $alumno= Yii::$app->db->createCommand("select a.ODEO_AlumnoKey,c.ClienteKey, a.Apellido, a.Nombre,
                d.Nombre as Division, g.Nombre as Grado, n.Nombre as Nivel,n.ODEO_NivelKey,g.ODEO_GradoKey as GradoKey,d.ODEO_DivisionKey as DivisionKey,
                a.NumeroDocumento, a.FechaNacimiento, a.Sexo,a.FechaNacimiento,a.FechaIngreso,a.FechaEgreso,
                case when bautismo.Variante is null then 'NO' else 'SI' end as Bautismo,
                bautismo.Variante as LugarBautismo,
                diosecisBautismo.Variante as DiosecisBautismo,
                fechaBautismo.Variante as FechaBautismo,
                case when comunion.Variante is null then 'NO' else 'SI' end as Comunion,
                comunion.Variante as LugarComunion,
                diosecisComunion.Variante as DiosecisComunion,
                fechaComunion.Variante as FechaComunion,
                case when confirmacion.Variante is null then 'NO' else 'SI' end as Confirmacion,
                confirmacion.Variante as LugarConfirmacion,
                diosecisConfirmacion.Variante as DiosecisConfirmacion,
                fechaConfirmacion.Variante as FechaConfirmacion,
                localidad.nombre as LugarNacimiento
                from Cliente c
                join ODEO_FamiliaIntegrante f on (c.ClienteKey = f.ClienteKey)
                join ODEO_Alumno a on (f.ODEO_AlumnoKey = a.ODEO_AlumnoKey)
                join ODEO_Division d on (a.ODEO_DivisionKey = d.ODEO_DivisionKey)
                join ODEO_Grado g on (d.ODEO_GradoKey = g.ODEO_GradoKey)
                join ODEO_Nivel n on (g.ODEO_NivelKey = n.ODEO_NivelKey)
                left join ODEO_AlumnoCaracteristica bautismo on (a.ODEO_AlumnoKey = bautismo.ODEO_AlumnoKey) and (bautismo.CaracteristicaKey = 1)
                left join ODEO_AlumnoCaracteristica diosecisBautismo on (a.ODEO_AlumnoKey = diosecisBautismo.ODEO_AlumnoKey) and (diosecisBautismo.CaracteristicaKey = 2)
                left join ODEO_AlumnoCaracteristica fechaBautismo on (a.ODEO_AlumnoKey = fechaBautismo.ODEO_AlumnoKey) and (fechaBautismo.CaracteristicaKey = 3)
                left join ODEO_AlumnoCaracteristica comunion on (a.ODEO_AlumnoKey = comunion.ODEO_AlumnoKey) and (comunion.CaracteristicaKey = 4)
                left join ODEO_AlumnoCaracteristica diosecisComunion on (a.ODEO_AlumnoKey = diosecisComunion.ODEO_AlumnoKey) and (diosecisComunion.CaracteristicaKey = 5)
                left join ODEO_AlumnoCaracteristica fechaComunion on (a.ODEO_AlumnoKey = fechaComunion.ODEO_AlumnoKey) and (fechaComunion.CaracteristicaKey = 6)
                left join ODEO_AlumnoCaracteristica confirmacion on (a.ODEO_AlumnoKey = confirmacion.ODEO_AlumnoKey) and (confirmacion.CaracteristicaKey = 7)
                left join ODEO_AlumnoCaracteristica diosecisConfirmacion on (a.ODEO_AlumnoKey = diosecisConfirmacion.ODEO_AlumnoKey) and (diosecisConfirmacion.CaracteristicaKey = 8)
                left join ODEO_AlumnoCaracteristica fechaConfirmacion on (a.ODEO_AlumnoKey = fechaConfirmacion.ODEO_AlumnoKey) and (fechaConfirmacion.CaracteristicaKey = 9)
                left join localidad on (localidad.localidadKey=a.LocalidadNacimientoKey)
                where a.ODEO_AlumnoKey=$idAlumno order by c.ClienteKey")->queryAll();
              
                return json_encode($alumno);
        }
        
    }
?>