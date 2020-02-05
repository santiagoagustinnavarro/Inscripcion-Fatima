<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\MYSQLSolicitud_postula_postulante;
use app\models\MYSQLSolicitudInscripcion;
use app\models\MYSQLPersona;
use app\models\MYSQLPostulante;
use app\models\MYSQLDomicilio;
use app\models\Localidad;
use app\models\Provincia;
use app\models\MYSQLCiudad;
use app\models\MYSQLResponsable;
use app\models\MYSQLFamilia;
use app\models\MYSQLPersonaFormaFamilia;
use app\models\MYSQLNivel;
use app\models\ODEONivel;
class SolicitudinscripcionController extends Controller{
    function actionSolicitarinscripcion(){
        $idAlumno=$_POST['alumnos'];
        if(is_numeric($idAlumno)){//El alumno esta en SQL
            $existe=MYSQLPostulante::findOne($idAlumno);
            if($existe==null){//El alumno no se ha postulado
                $datosForm=$_POST;
                $personasGeneradas=$this->generaPersonas($datosForm);
                $familiaPostulante=$this->generarFamilia($personasGeneradas['alumno'],$personasGeneradas['padre'],$personasGeneradas['madre']);//Para hacer
                $responsable=new MYSQLResponsable();
                $responsable->responsable_persona=$personasGeneradas['responsable']->persona_id;
                $responsable->responsable_tel_contacto=$_POST['responsable']['telefonoFijo'];
                $responsable->responsable_mail_contacto=$_POST['responsable']['email'];
                $responsableAux=$responsable->find()->select("max(responsable_id)")->one();
    if($responsableAux==null){
        $nro=1;
    }else{
        $nro=($responsableAux->responsable_id)+1;
    }
    $responsable->responsable_id=$nro;
                $responsable->insert();
                $idPost=$_POST['alumnos'];
                $postulante=$this->generarPostulante($idPost,$personasGeneradas['alumno'],$responsable,$familiaPostulante,$_POST['alumno']['nivel']);
                $this->generarSolicitud($postulante);
                echo "su solicitud ha sido enviada espere a que un administrador la confirme";


            }else{
                $this->generarSolicitud($existe);
                echo "su solicitud ha sido enviada espere a que un administrador la confirme";
            }


    
        }else{
            echo "Seccion de legajos nuevos en construccion";
        }
    }   
function generarSolicitud($unPostulante){
    $relacionPostula=new MYSQLSolicitud_postula_postulante();
    $solicitudInscripcion=new MYSQLSolicitudInscripcion();
    $solicitudAux= new MYSQLSolicitudInscripcion();
    $solicitudAux=$solicitudAux->find()->select("max(solicitud_nro)")->one();
    if($solicitudAux==null){
        $nro=1;
    }else{
        $nro=($solicitudAux->solicitud_nro)+1;
    }
   
    $solicitudInscripcion->solicitud_nro=$nro;
    $solicitudInscripcion->solicitud_id=$nro;
    $solicitudInscripcion->solicitud_fecha= date("Y")."-".date("m")."-".date("d");
    $solicitudInscripcion->solicitud_estado=0;
    $solicitudInscripcion->solicitud_establecimiento=1;
    $solicitudInscripcion->insert();
    $relacionPostula->postulante_id=$unPostulante->postulante_id;
    $relacionPostula->solicitud_id=$solicitudInscripcion->solicitud_id;
    $relacionPostula->insert();

}
    


function generarPostulante($idPost,$alumno,$responsable,$familia,$antNivel){
    $postulante=new MYSQLPostulante();
    $nivelAct=new ODEONivel();
    $nivelAct=$nivelAct->findOne($antNivel);
    $nivel=new MYSQLNivel();
    $nivel=$nivel->find()->where(['nivel_nombre'=>$nivelAct->Nombre])->one();
    $postulante->postulante_id=$idPost;
    $postulante->postulante_persona=$alumno->persona_id;
    $postulante->postulante_confirmado=0;
    $postulante->postulante_familia=$familia->familia_id;
    $postulante->postulante_nivel=$nivel->nivel_id;
    $postulante->postulante_responsable=$responsable->responsable_id;
    $postulante->insert();
    
    return $postulante;

}
/**
 * Dadas las personas del hijo ,padre y madre genera la union familiar
 */

function generarFamilia($alumno,$padre,$madre){
    $familia= new MYSQLFamilia();
    $familiaAux=$familia->find()->select("max(familia_id) as familia_id")->one();
    if($familiaAux->familia_id==''){
        $id=1;
    }else{
        $id=($familiaAux->familia_id)+1;
    }
    $familia->familia_id=$id;
    $familia->insert();
    $relacionFamiliaHijo=new MYSQLPersonaFormaFamilia();
    $relacionFamiliaHijo->persona_id=$alumno->persona_id;
    $relacionFamiliaHijo->familia_id=$familia->familia_id;
    $relacionFamiliaHijo->parentezco="Hijo";
    $relacionFamiliaHijo->insert();
    $relacionFamiliaPadre=new MYSQLPersonaFormaFamilia();
    $relacionFamiliaPadre->persona_id=$padre->persona_id;
    $relacionFamiliaPadre->familia_id=$familia->familia_id;
    $relacionFamiliaPadre->parentezco="Padre";
    $relacionFamiliaPadre->insert();
    $relacionFamiliaMadre=new MYSQLPersonaFormaFamilia();
    $relacionFamiliaMadre->persona_id=$madre->persona_id;
    $relacionFamiliaMadre->familia_id=$familia->familia_id;
    $relacionFamiliaMadre->parentezco="Madre";
    $relacionFamiliaMadre->insert();
    return $relacionFamiliaHijo;



}
    /**
     * Esta función recibe los datos del formulario , realiza las inserciones
     * en la entidad de persona y retorna el array con las 3 personas (responsable,padre,madre,alumno)
     * no se utilizó repetición ya que cada rol tiene o le faltan datos respecto de los otros
     * @param Array $datosForm
     */
    function generaPersonas($datosForm){
        $arrPersonas=array();
        /////////////Registramos al responsable como persona/////////////////////
        $responsableP=new MYSQLPersona(); //La letra P equivale a decir que es de la entidad Persona
        $responsableP->persona_nombres=$datosForm['responsable']['apellidoYNombre'];
        $responsableP->persona_apellidos=$datosForm['responsable']['apellidoYNombre'];
        $domicilio=new MYSQLDomicilio();
        $domicilio->domicilio_calle=$datosForm['responsable']['domicilio'];
        $localidad=new Localidad();
        $localidad=$localidad->find()->where(["LocalidadKey"=>$datosForm['responsable']['localidad']])->one();
        $provincia=new Provincia();
        $provincia=$provincia->find()->where(["ProvinciaKey"=>$datosForm['responsable']['provincia']])->one();
        $localidad=MYSQLCiudad::find()->select("*")->innerJoin('provincia','ciudad.ciudad_provincia=provincia.provincia_id')->where(["ciudad.ciudad_nombre"=>$localidad->Nombre,'provincia.provincia_nombre'=>$provincia->Nombre])->one();
        $domicilio->domicilio_ciudad=$localidad->ciudad_id;
        $idDomicilio=$domicilio->find()->select('max(domicilio_id) as domicilio_id')->one();
        $idDomicilio=$idDomicilio->domicilio_id;
        if($idDomicilio=='' || $idDomicilio==null){
            $domicilio->domicilio_id=1;
        }else{
            $domicilio->domicilio_id=$idDomicilio+1;
        }       
        $insertarDomicilio=$domicilio->insert();
        $responsableP->persona_domicilio= $domicilio->domicilio_id; 
        $idPersona=$responsableP->find()->select('max(persona_id)')->asArray()->one();
        
        if($idPersona['max(persona_id)']==''){
            $responsableP->persona_id=1;
        }else{
            $idPersona= $idPersona['max(persona_id)'];
            $responsableP->persona_id=$idPersona+1;
        }
        
        $responsableP->persona_sexo=3;
        $responsableP->persona_cuil=$datosForm['responsable']['cuit'];
        $auxDoc=str_replace('-','',$responsableP->persona_cuil);
        $responsableP->persona_nro_doc=substr($auxDoc,2,strlen($auxDoc)-3);
        $responsableP->persona_tipodoc=2;
        $responsableP->insert();
        $arrPersonas["responsable"]=$responsableP;
        ////////////////Registramos al padre como persona//////////////////////
        $padreP=new MYSQLPersona();
        $padreP->persona_nombres=$datosForm['padre']['apellidoYNombre'];
        $padreP->persona_apellidos=$datosForm['padre']['apellidoYNombre'];
        if($datosForm['padre']['tipoDoc']=='CUIT' || $datosForm['padre']['tipoDoc']=='CUIL'){
            $padreP->persona_cuil=$datosForm['padre']['cuil'];
            $padreP->persona_nro_doc=substr($padreP->persona_cuil,2,strlen($auxDoc)-3);//Quita los primeros dos caracteres y el ultimo (queda el documento)
        }else{
            $padreP->persona_cuil='';
            $padreP->persona_nro_doc=$datosForm['padre']['cuil'];
        }
        $padreP->persona_sexo=2;
        $padreP->persona_tipodoc=2;
        $padreP->persona_domicilio=$responsableP->persona_domicilio;
        $idPersonaP=$padreP->find()->select('max(persona_id)')->asArray()->one();
        
        if($idPersonaP['max(persona_id)']==''){
            $padreP->persona_id=1;
        }else{
            $idPersonaP= $idPersonaP['max(persona_id)'];
            $padreP->persona_id=$idPersonaP+1;
        }
        $insercion=$padreP->insert();
        if($insercion){
            echo "el padre se inserto con id".$padreP->persona_id;
        }else{
            echo "por algun motivo no se inserto";
        }
     
       
        $arrPersonas["padre"]=$padreP;
        //////////////////////Registramos a la madre como persona/////////////////////
        $madreP=new MYSQLPersona();
        $madreP->persona_nombres=$datosForm['madre']['apellidoYNombre'];
        $madreP->persona_apellidos=$datosForm['madre']['apellidoYNombre'];
        if($datosForm['madre']['tipoDoc']=='CUIT' || $datosForm['madre']['tipoDoc']=='CUIL'){
            $madreP->persona_cuil=$datosForm['madre']['cuil'];
            $madreP->persona_nro_doc=substr($madreP->persona_cuil,2,strlen($auxDoc)-3);//Quita los primeros dos caracteres y el ultimo (queda el documento)
        }else{
            $madreP->persona_cuil='';
            $madreP->persona_nro_doc=$datosForm['madre']['cuil'];
        }
        $madreP->persona_sexo=2;
        $madreP->persona_tipodoc=2;
        $madreP->persona_domicilio=$responsableP->persona_domicilio;
        $idPersonaM=$madreP->find()->select('max(persona_id)')->asArray()->one();
     
       
        if($idPersonaM['max(persona_id)']==''){
            
            $madreP->persona_id=1;
        }else{
            $idPersonaM= $idPersonaM['max(persona_id)'];
            $madreP->persona_id=$idPersonaM+1;
        }
        $madreP->insert();
        $arrPersonas["madre"]=$madreP;
       //////Registramos al alumno como una persona///////
       $alumnoP=new MYSQLPersona();
       $alumnoP->persona_apellidos=$datosForm['alumno']['apellidos'];
       $alumnoP->persona_nombres=$datosForm['alumno']['nombre'];
       if($datosForm['alumno']['sexo']=="F"){
        $alumnoP->persona_sexo=1;
       }else{
        $alumnoP->persona_sexo=2;
       }
       $alumnoP->persona_cuil='';
       $alumnoP->persona_tipodoc=2;
       $alumnoP->persona_nro_doc=$datosForm['alumno']['dni'];
      $alumnoP->persona_domicilio=$responsableP->persona_domicilio;
      $idPersonaA=$alumnoP->find()->select('max(persona_id)')->asArray()->one();
     
        if(is_null($idPersonaA)){
          $alumnoP->persona_id=1;
      }else{
        $idPersonaA= $idPersonaA['max(persona_id)'];
          $alumnoP->persona_id=$idPersonaA+1;
      }
      $alumnoP->insert();
      $arrPersonas["alumno"]=$alumnoP;
      return $arrPersonas;


    }
   
}



?>