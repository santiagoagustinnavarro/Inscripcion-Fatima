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
use app\models\MYSQLCiudad;


class SolicitudinscripcionController extends Controller{
    function actionSolicitarinscripcion(){
        $docPost= $alumno['nroDoc']=$_POST['alumno']['dni'];
        $existe=MYSQLPersona::find()->where(['persona_nro_doc'=>$docPost])->one();

        if($existe==null){//Nuevo en la BD
            $solicitudAndPostulante=new MYSQLSolicitud_postula_postulante();
            $persona=new MYSQLPersona();
            $postulante=new MYSQLPostulante();
            $solicitudInscripcion=new MYSQLSolicitudInscripcion();
            $responsable['nombre']=$_POST['responsable']['apellidoYNombre'];
            $responsable['apellido']=$_POST['responsable']['apellidoYNombre'];
            $responsable['cuit']=$_POST['responsable']['cuit'];
            $responsable['provincia']=$_POST['responsable']['provincia'];
            $responsable['localidad']=$_POST['responsable']['localidad'];
            $responsable['codigo_postal']=$_POST['responsable']['codigo_postal'];
            $responsable['domicilio']=$_POST['responsable']['domicilio'];
            $responsable['telefonoFijo']=$_POST['responsable']['telefonoFijo'];
            $responsable['telefonoMovil']=$_POST['responsable']['telefonoMovil'];
            $responsable['email']=$_POST['responsable']['email'];
            $responsable['domicilio']=$_POST['responsable']['domicilio'];
            $registroResponsable=$this->registrarPersona($responsable,'responsable');
            $alumno['nombre']=$_POST['alumno']['apellidos'];
            $alumno['apellido']=$_POST['alumno']['nombre'];
            //$alumno['cuit']=$_POST['alumno']['cuit'];
           // $alumno['provincia']=$_POST['alumno']['provincia'];
            $alumno['localidad']='';
            $alumno['codigo_postal']='';
            $alumno['domicilio']='';
            $alumno['telefonoFijo']='';
            $alumno['telefonoMovil']='';
            $alumno['email']='';
            $alumno['domicilio']='';
            $alumno['sexo']=$_POST['alumno']['sexo'];
            $alumno['nroDoc']=$_POST['alumno']['dni'];
           $alumno['domicilio']=$registroResponsable[1]->persona_domicilio;
           $registroPostulante=$this->registrarPersona($alumno,'alumno');
           $padre['nombre']=$_POST['padre']['apellidoYNombre'];
           $padre['apellido']=$_POST['padre']['apellidoYNombre'];
           $padre['nroDoc']=$_POST['padre']['cuil'];
           //$padre['telefonoFijo']=$_POST['padre']['telefonoFijo'];
           //$padre['telefonoMovil']=$_POST['padre']['telefonoMovil'];
           //$padre['email']=$_POST['padre']['email'];
           $padre['domicilio']=$registroResponsable[1]->persona_domicilio;
           $registroPadre=$this->registrarPersona($padre,'padre');
           $madre['nombre']=$_POST['madre']['apellidoYNombre'];
           $madre['apellido']=$_POST['madre']['apellidoYNombre'];
           $madre['nroDoc']=$_POST['madre']['cuil'];
           //$padre['telefonoFijo']=$_POST['padre']['telefonoFijo'];
           //$padre['telefonoMovil']=$_POST['padre']['telefonoMovil'];
           //$padre['email']=$_POST['padre']['email'];
           $madre['domicilio']=$registroResponsable[1]->persona_domicilio;
           $registroMadre=$this->registrarPersona($madre,'madre');
         
        }else{
            echo "ya existe ese postulante washu";
        }
    }
    /**
     * @param array $datosPersona
     * @param string $rol 
     */
    function registrarPersona($datosPersona,$caracteristica){
        $persona=new MYSQLPersona();
        $persona->persona_nombres=$datosPersona['nombre'];
        $persona->persona_apellidos=$datosPersona['apellido'];
        $persona->persona_tipodoc=2;
        //$persona->persona_provincia=$datosPersona['provincia'];
        if($caracteristica=='responsable'){
            $persona->persona_sexo=3;
            $persona->persona_cuil=str_replace('-','',$datosPersona['cuit']);
            $persona->persona_nro_doc=str_replace('-','',$datosPersona['cuit']);
            $persona->persona_nro_doc=substr( $persona->persona_nro_doc,2,strlen($persona->persona_nro_doc)-3);
            if(isset($datosPersona['domicilio'])){
                $domicilio=new MYSQLDomicilio();
                $domicilio->domicilio_calle=$datosPersona['domicilio'];
                $localidad=Localidad::findOne($datosPersona['localidad']);
                $localidad=MYSQLCiudad::find()->where(["ciudad_nombre"=>$localidad->Nombre])->one();
                $domicilio->domicilio_ciudad=$localidad->ciudad_id;
                $idDomicilio=$domicilio->find()->select('max(domicilio_id)')->asArray()->one();
                $idDomicilio=$idDomicilio['max(domicilio_id)'];
                if($idDomicilio==null){
                    $domicilio->domicilio_id=1;
                }else{
                    $domicilio->domicilio_id=$idDomicilio+1;
                } 
                $insertarDomicilio=$domicilio->insert();
                $persona->persona_domicilio=$idDomicilio; 
            }

        }else{
            if($caracteristica=="madre"){
                $persona->persona_sexo=1;
                $persona->persona_nro_doc=$datosPersona['nroDoc'];
                $persona->persona_domicilio=$datosPersona['domicilio'];
            }else{
                if($caracteristica=="padre"){
                    $persona->persona_sexo=2;
                    $persona->persona_nro_doc=$datosPersona['nroDoc'];
                    $persona->persona_domicilio=$datosPersona['domicilio'];
                }else{
                    if($caracteristica=='alumno'){
                        if($datosPersona["sexo"]=="M"){
                            $persona->persona_sexo=2;
                        }else{
                            $persona->persona_sexo=1;
                        }
                        $persona->persona_domicilio=$datosPersona['domicilio'];
                        $persona->persona_cuil='';
                        $persona->persona_nro_doc=$datosPersona['nroDoc'];
                    }
                }
            
        }
    }
     
    $idPersona=$persona->find()->select('max(persona_id)')->asArray()->one();
    $idPersona=$idPersona['max(persona_id)'];
    if($idPersona==null){
        $persona->persona_id=1;
    }else{
        $persona->persona_id=$idPersona+1;
    }
         
    return [$persona->insert(),$persona];

    }
}



?>