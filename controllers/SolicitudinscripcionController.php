<?php

namespace app\controllers;
use app\models\MYSQLAlumno;
use app\models\MYSQLAlumnoCursaDivision;
use app\models\Localidad;
use app\models\MYSQLCiudad;
use app\models\MYSQLDomicilio;
use app\models\MYSQLFamilia;
use app\models\MYSQLNivel;
use app\models\MYSQLPersona;
use app\models\MYSQLPersonaFormaFamilia;
use app\models\MYSQLPostulante;
use app\models\MYSQLResponsable;
use app\models\MYSQLSolicitudOtorgada;
use app\models\MYSQLSolicitudInscripcion;
use app\models\MYSQLSolicitud_postula_postulante;
use app\models\ODEONivel;
use app\models\ODEOGrado;
use app\models\ODEODivision;
use app\models\Provincia;
use Yii;
use rudissaar\fpdf\FPDF;

use yii\web\Controller;

class SolicitudinscripcionController extends Controller
{
    public function actionSolicitarinscripcion()
    {$respuestaInscripcion=false;
        $responsable = Yii::$app->request->post('responsable'); // ok funciona
        $padre = Yii::$app->request->post('padre'); // ok funciona
        $madre = Yii::$app->request->post('madre'); // ok funciona
        $alumnos = Yii::$app->request->post('alumnosArray');

       //$dir_pdf = $this->pdfSolicitud($responsable, $padre, $madre, $alumnos);

        /// Envia un mail con el pdf adjunto
        /*Yii::$app->mailer->compose()
            ->setFrom('santiagoanavarro018@gmail.com')
            ->setTo($responsable['email'])
            ->setSubject('Formulario')
            ->setTextBody('adjuntamos archivo')
            ->setHtmlBody('Adjuntamos en formato <b>PDF</b> la inscripción') //// escribo el msj del correo
            ->attach("../registros_pdf/" . $dir_pdf)
            ->send();*/

        $datosResponsable = Yii::$app->request->post('responsable');
        if (isset($datosResponsable['legajo'])) { //El alumno esta en SQL
            $legajo = $datosResponsable['legajo'];
            $existe = MYSQLFamilia::find()->where(['familia_legajo' => $legajo])->one();
            if ($existe == null) { //El legajo no existe en MYSQL
                if (Yii::$app->request->post('alumno') != "new") { //El alumno no es nuevo
                    $personasGeneradas = $this->generaPersonas(Yii::$app->request->post());
                    $familiaPostulante = $this->generarFamilia($personasGeneradas['alumnos'], $personasGeneradas['padre'], $personasGeneradas['madre'], $legajo);
                    $responsable = new MYSQLResponsable();
                    $responsable->responsable_persona = $personasGeneradas['responsable']->persona_id;
                    $responsable->responsable_tel_contacto = $_POST['responsable']['telefonoFijo'];
                    $responsable->responsable_mail_contacto = $_POST['responsable']['email'];
                    $idResponsable = $this->idMaximo('responsable_id', 'responsable');
                    if ($idResponsable == "") {
                        $nro = 1;
                    } else {
                        $nro = $idResponsable + 1;
                    }
                    $responsable->responsable_id = $nro;
                    $responsable->insert(false);

                    //$idPost=$this->idMaximo('postulante_id','postulante');
                    //$idPost = Yii::$app->request->post('alumno');
                    //$idPost=$idPost['legajo'];
                    $postulante = $this->generarPostulante($personasGeneradas['alumnos'], $responsable, $familiaPostulante, $alumnos);

                    $solicitud = $this->generarSolicitud($postulante);
                    if (!$solicitud[0]) {
                        echo "Algo falló en la insercion del postulante y/o relacion postula";
                    } else {
                        //
                    }
                  
                    $alumnosGenerados=$this->generarAlumnos($postulante,$alumnos);
                    $solicitudesOtorgadas=$this->generarSolicitudesOtorgadas($solicitud[1]);
                    //return $this->render('generado');
                    $respuestaInscripcion=$respuestaInscripcio || $solicitudesOtorgadas[0];
                    $mensajes[]="Alumnos inscriptos correctamente";
                } else { //El alumno es nuevo
                    echo "Seccion en construccion";
                }

            } else { //El legajo esta en MYSQL
                if (Yii::$app->request->post('alumno') == "new") { //Se eligio crear un nuevo alumno
                    $postulante = new Postulante();
                    $postulantePersona = new Persona();
                    
                    
                    echo "Página para nuevo alumno en construccion";
                } else { //Actualización de datos

                    ////Comenzamos con las actualizaciones 
                    $familia = new MYSQLPersonaFormaFamilia();
                    //Buscamos al padre y lo actualizamos
                    $padre=$familia->find()->innerJoin('familia','persona_forma_familia.familia_id=familia.familia_id')->innerJoin('persona','persona.persona_id=persona_forma_familia.persona_id')->where(['familia.familia_legajo'=>$legajo,'persona_forma_familia.parentezco'=>'padre'])->one();
                    $padre=MYSQLPersona::findOne($padre->persona->persona_id);
                    $padre->persona_nombres=$_POST["padre"]["apellidoYNombre"];
                    $padre->persona_apellidos=$_POST["padre"]["apellidoYNombre"];
                    if ($_POST['padre']['tipoDoc'] == 'CUIT' || $_POST['padre']['tipoDoc'] == 'CUIL') {
                        $padre->persona_cuil = $_POST['padre']['cuil'];
                        $padre->persona_nro_doc = $this->obtenerDni($padre->persona_cuil);
                    } else {
                        $padre->persona_cuil = '';
                        $padre->persona_nro_doc = $_POST['padre']['cuil'];
                    }
                    $padre->persona_sexo = 2;
                    $padre->persona_tipodoc = 2;
                    $padre->setIsNewRecord(false);
                    $padre->update(false);//Actualizacion
                     /////Buscamos a la madre y la actualizamos
                       $madre=$familia->find()->innerJoin('familia','persona_forma_familia.familia_id=familia.familia_id')->innerJoin('persona','persona.persona_id=persona_forma_familia.persona_id')->where(['familia.familia_legajo'=>$legajo,'persona_forma_familia.parentezco'=>'madre'])->one();
                       $madre=MYSQLPersona::findOne($madre->persona->persona_id);
                       $madre->persona_nombres=$_POST["padre"]["apellidoYNombre"];
                       $madre->persona_apellidos=$_POST["madre"]["apellidoYNombre"];
                       if ($_POST['madre']['tipoDoc'] == 'CUIT' || $_POST['madre']['tipoDoc'] == 'CUIL') {
                           $madre->persona_cuil = $_POST['madre']['cuil'];
                           $madre->persona_nro_doc = $this->obtenerDni($madre->persona_cuil);
                       } else {
                           $madre->persona_cuil = '';
                           $madre->persona_nro_doc = $_POST['madre']['cuil'];
                       }
                       $madre->persona_sexo = 2;
                       $madre->persona_tipodoc = 2;
                       $madre->setIsNewRecord(false);
                       $madre->update(false);//Actualizacion
                       ///Buscamos al responsable y lo actualizamos
                       $responsableActualiza=$familia->find()->select('persona.persona_id as idResponsable')->innerJoin('familia','familia.familia_id=persona_forma_familia.familia_id')->innerJoin('postulante','postulante.postulante_familia=familia.familia_id')->innerJoin('responsable','responsable.responsable_id=postulante.postulante_responsable')->innerJoin('persona','persona.persona_id=responsable.responsable_persona')->where(['familia.familia_legajo'=>$legajo])->asArray()->one();
                       $responsableActualiza=MYSQLPersona::findOne($responsableActualiza['idResponsable']);
                       $domicilio = new MYSQLDomicilio();
                       $domicilio->domicilio_calle = $_POST['responsable']['domicilio'];
                       $localidadMYSQL = $this->traerLocalidadMYSQL($_POST['responsable']['localidad'], $_POST['responsable']['provincia']);
                       $domicilio->domicilio_ciudad = $localidadMYSQL->ciudad_id;
                       $idDomicilio = $this->idMaximo('domicilio_id', 'persona_domicilio');
                       if ($idDomicilio == '') { //No se ha insertado aun ningún domicilio
                           $domicilio->domicilio_id = 1;
                       } else {
                           $domicilio->domicilio_id = $idDomicilio + 1;
                       }
                       $insertarDomicilio = $domicilio->insert(false);
                       $responsableActualiza->persona_domicilio=$idDomicilio;
                       $responsableActualiza->persona_sexo = 3;
                       $responsableActualiza->persona_cuil = $_POST['responsable']['cuit'];
                       $auxDoc = str_replace('-', '', $responsableActualiza->persona_cuil); //Quitamos los guiones del cuit
                        $responsableActualiza->persona_nro_doc = substr($auxDoc, 2, strlen($auxDoc) - 3); //Quitamos los numeros particulares del cuit (2 al inicio y al final)
                     $responsableActualiza->persona_tipodoc = 2;
                     $responsableActualiza->setIsNewRecord(false);
                     $responsableActualiza->update(false);
                     ////Generamos nuevos postulantes vinculados al mismo alumno
                     $postulantes =array();
                     $j=0;
                     foreach($_POST['alumnosArray'] as $unAlumno){
                        
                        $alumnoCursaDivision=MYSQLAlumnoCursaDivision::find()->where(['cursa_alumno'=>$unAlumno['persona_id'],'cursa_anio'=>date("Y")])->one();
                        if(is_null($alumnoCursaDivision)){//Nuevo año aún no inscripto
                            $alumno=MYSQLAlumno::find()->innerJoin('postulante','postulante.postulante_id=alumno.alumno_postulante')->where('alumno.alumno_id='.$unAlumno['persona_id'])->one();
                            if(is_null($alumno)){//Alumno añadido recientemente(nunca estuvo)
                                $post=new MYSQLPostulante();
                                $responsableBuscado=Yii::$app->dbTwo->createCommand("select persona.persona_domicilio,responsable.responsable_id from familia inner join persona_forma_familia on familia.familia_id=persona_forma_familia.familia_id inner join persona on persona.persona_id=persona_forma_familia.persona_id inner join postulante on postulante.postulante_persona=persona.persona_id inner join responsable on postulante.postulante_responsable=responsable.responsable_id ")->queryOne();
                                $id=$this->idMaximo('postulante_id','postulante');
                                if($id==""){
                                    $id=1;
                                }else{
                                    $id=$id+1;
                                }
                               
                                $post->postulante_id=$id;
                                $alumnoP = new MYSQLPersona();
                                $alumnoP->persona_apellidos = $unAlumno['apellidos'];
                                $alumnoP->persona_nombres = $unAlumno['nombre'];
                                if ($unAlumno['sexo'] == "F") {
                                    $alumnoP->persona_sexo = 1;
                                } else {
                                    $alumnoP->persona_sexo = 2;
                                }
                                $alumnoP->persona_cuil = '';
                                $alumnoP->persona_tipodoc = 2;
                                $alumnoP->persona_nro_doc = $unAlumno['dni'];
                                
                                $alumnoP->persona_domicilio = $responsableBuscado['persona_domicilio'];
                                $idPersona = $this->idMaximo('persona_id', 'persona');
                    
                                if ($idPersona == "") {
                                    $alumnoP->persona_id = 1;
                                } else {
                                    $alumnoP->persona_id = $idPersona + 1;
                                }
                                $alumnoP->insert(false);
                               $post->postulante_persona=$alumnoP->persona_id;
                                $familiaPost=MYSQLFamilia::find()->where(['familia_legajo'=>$_POST['responsable']['legajo']])->one();
                                $post->postulante_familia=$familiaPost->familia_id;
                                $post->postulante_confirmado=1;
                                $post->postulante_nivel=$unAlumno['nivel'];
                                $post->postulante_responsable=$responsableBuscado['responsable_id'];
                              
                                $post->insert(false);
                                $alumno=new MYSQLAlumno();
                                //$id=$this->idMaximo('alumno_id','alumno');
                                $id=$unAlumno['persona_id'];
                                $alumno->alumno_id=$id;
                                $alumno->alumno_postulante=$post->postulante_id;
                                $alumno->insert(false);
                                $posts[]=$post;
                                $alumnosGenerados[]=$alumno;
                               
                            }else{
                                $post=new MYSQLPostulante();
                                $id=$this->idMaximo('postulante_id','postulante');
                                if($id==""){
                                    $id=1;
                                }else{
                                    $id=$id+1;
                                }
                                $post->postulante_id=$id;
                                $post->postulante_persona=$alumno->postulante->postulante_persona;
                                $familiaPost=MYSQLFamilia::find()->where(['familia_legajo'=>$_POST['responsable']['legajo']])->one();
                                $post->postulante_familia=$familiaPost->familia_id;
                                $post->postulante_confirmado=1;
                                $post->postulante_nivel=$unAlumno['nivel'];
                                $post->postulante_responsable=$responsable['legajo'];
                                $post->insert(false);
                                $personaPostulante=MYSQLPersona::findOne($alumno->postulante->persona->persona_id);
                                $personaPostulante->persona_nombres=$unAlumno['nombre'];
                                $personaPostulante->persona_apellidos=$unAlumno['apellidos'];
                                $personaPostulante->persona_nro_doc=$unAlumno['dni'];
                                $personaPostulante->persona_cuil = '';
                                $personaPostulante->persona_tipodoc = 2;
                                if ($unAlumno['sexo'] == "F") {
                                    $personaPostulante->persona_sexo = 1;
                                } else {
                                    $personaPostulante->persona_sexo = 2;
                                }
                               
                                $personaPostulante->update(false);
    
                                // $alumnos[]=$alumno;
                              
                                $posts[]=$post;
                                $alumno->alumno_postulante=$post->postulante_id;
                                $alumno->update(false);
                               
                                  
                            /*if($solicitudesOtorgadas[0]){
                               // return $this->render('generado');
                            }*/
                            }
                            $relacionCursa=new MYSQLAlumnoCursaDivision();
                            $relacionCursa->cursa_anio=date("Y");
                            $relacionCursa->cursa_alumno=$alumno->alumno_id;
                            $relacionCursa->cursa_division=$unAlumno['seccion'];
                            $relacionCursa->insert(false);
                                $solicitud=$this->generarSolicitud($posts);
                                //$alumnosGenerados=$this->generarAlumnos($posts,$alumnos);
                                $solicitudesOtorgadas=$this->generarSolicitudesOtorgadas($solicitud[1]);
                                $j++;
                                $respuestaInscripcion=$respuestaInscripcion || $solicitudesOtorgadas[0];
                                $mensajes=["Alumno ".$unAlumno['nombre']." ".$unAlumno['apellidos']." Inscripto"];//return $this->render('generado');
                    
                    }else{
                        $mensajes[]="El alumno/a ".$unAlumno['nombre']." ".$unAlumno['apellidos']."  ya se encontraba inscripto para el año ".date("Y");
                    }
                      

                     }
                     


                 /*    //Generamos los nuevos postulantes 
                    foreach($alumnos as $unAlumno){
                       
                     
                        $post=$alumnoN->find()->where(['alumno_id'=>$id]);
                        $alumnoN->cursa_division=$unAlumno['division_id'];
                        $alumnoN->cursa_anio=date("Y");
                        $alumnoN->update(false);
                    }*/
                    
                   

                         
                     
                }

                //$this->generarSolicitud($existe);
                //echo "su solicitud ha sido enviada espere a que un administrador la confirme";
            }
            if($respuestaInscripcion){
                $responsable = Yii::$app->request->post('responsable'); // ok funciona
                $padre = Yii::$app->request->post('padre'); // ok funciona
                $madre = Yii::$app->request->post('madre'); // ok funciona
                $alumnos = Yii::$app->request->post('alumnosArray');
        
               $dir_pdf = $this->pdfSolicitud($responsable, $padre, $madre, $alumnos);
        
                /// Envia un mail con el pdf adjunto
                Yii::$app->mailer->compose()
                    ->setFrom('santiagoanavarro018@gmail.com')
                    ->setTo($responsable['email'])
                    ->setSubject('Formulario')
                    ->setTextBody('adjuntamos archivo')
                    ->setHtmlBody('Adjuntamos en formato <b>PDF</b> la inscripción') //// escribo el msj del correo
                    ->attach("../registros_pdf/" . $dir_pdf)
                    ->send();
            }
            return $this->render('generado',['mensajes'=>$mensajes]);
        } else {
            echo "Seccion de legajos nuevos en construccion";
        }
    }

    function generarAlumnos($postulantes,$datosForm){
        $res=true;
        $i=0;
        foreach($postulantes as $unPostulante){
            $alumno=new MYSQLAlumno();
            //$id=$this->idMaximo('alumno_id','alumno');
            $id=$datosForm[$i]['persona_id'];
            $alumno->alumno_id=$id;
            $alumno->alumno_postulante=$unPostulante->postulante_id;
            $res=$res && $alumno->insert(false);
            $alumnos[]=$alumno;
            $relacionCursa=new MYSQLAlumnoCursaDivision();
           $relacionCursa->cursa_anio=date("Y");
           $relacionCursa->cursa_alumno=$alumno->alumno_id;
           $relacionCursa->cursa_division=$datosForm[$i]['seccion'];
            $res=$res && $relacionCursa->insert(false);
            $alumnosGenerados[]=$alumno;
            $i++;
        }
        return [$res,$alumnosGenerados];
    }

    function generarSolicitudesOtorgadas($solicitudes){
        $res=true;
        foreach($solicitudes as $unaSolicitud){
            $solicitudOtorgada=new MYSQLSolicitudOtorgada();
            $solicitudOtorgada->solicitud_otorga_solic=$unaSolicitud->solicitud_id;
            $solicitudOtorgada->solicitud_otorga_fecha=date("Y") . "-" . date("m") . "-" . date("d")." ".date("G").":".date("i").":".date("s");
            $idSolicitud = $this->idMaximo('solicitud_otorga_id', 'solicitud_otorgada');

            if ($idSolicitud == "") {

                $nro = 1;
            } else {
                $nro = $idSolicitud + 1;
            }
            $solicitudOtorgada->solicitud_otorga_id=$nro;
            $solicitudOtorgada->solicitud_otorga_nro = (int) $nro . date("Y");
            $res=$res && $solicitudOtorgada->insert(false);
            $solicitudesOtorgadas[]=$solicitudOtorgada;

        }
        return [$res,$solicitudesOtorgadas];

    }

    /**
     * Esta función recibe los datos del formulario , realiza las inserciones
     * en la entidad de persona y retorna el array con las 3 personas (responsable,padre,madre,alumno)
     * no se utilizó repetición ya que cada rol tiene o le faltan datos respecto de los otros
     * @param Array $_POST
     */
    public function generaPersonas($datosForm)
    {
        $arrPersonas = array();
        /////////////Registramos al responsable como persona/////////////////////
        $responsableP = new MYSQLPersona(); //La letra P equivale a decir que es de la entidad Persona
        $responsableP->persona_nombres = $datosForm['responsable']['apellidoYNombre'];
        $responsableP->persona_apellidos = $datosForm['responsable']['apellidoYNombre'];
        $domicilio = new MYSQLDomicilio();
        $domicilio->domicilio_calle = $datosForm['responsable']['domicilio'];
        //$responsableP->domicilio->domicilio_calle=$datosForm['responsable']['domicilio'];
        //$responsableP->domicilio->domicilio_ciudad=$datosForm['responsable']['localidad'];
        //Convertimos la ciudad de SQL a la correspondiente en MYSQL
        $localidadMYSQL = $this->traerLocalidadMYSQL($datosForm['responsable']['localidad'], $datosForm['responsable']['provincia']);
        $domicilio->domicilio_ciudad = $localidadMYSQL->ciudad_id;
        //$domicilio->domicilio_ciudad=$localidad->ciudad_id;
        $idDomicilio = $this->idMaximo('domicilio_id', 'persona_domicilio');

        if ($idDomicilio == '') { //No se ha insertado aun ningún domicilio
            $domicilio->domicilio_id = 1;
        } else {
            $domicilio->domicilio_id = $idDomicilio + 1;
        }
        $insertarDomicilio = $domicilio->insert(false);
        $responsableP->persona_domicilio = $domicilio->domicilio_id;
        $idPersona = $this->idMaximo('persona_id', 'persona');
        if ($idPersona == '') {
            $responsableP->persona_id = 1;
        } else {
            $responsableP->persona_id = $idPersona + 1;
        }

        $responsableP->persona_sexo = 3;
        $responsableP->persona_cuil = $datosForm['responsable']['cuit'];
        $auxDoc = str_replace('-', '', $responsableP->persona_cuil); //Quitamos los guiones del cuit
        $responsableP->persona_nro_doc = substr($auxDoc, 2, strlen($auxDoc) - 3); //Quitamos los numeros particulares del cuit (2 al inicio y al final)
        $responsableP->persona_tipodoc = 2;
        $responsableP->insert(false); //Insercion de la persona responsable
        $arrPersonas["responsable"] = $responsableP;
        ////////////////Registramos al padre como persona//////////////////////
        $padreP = new MYSQLPersona();
        $padreP->persona_nombres = $datosForm['padre']['apellidoYNombre'];
        $padreP->persona_apellidos = $datosForm['padre']['apellidoYNombre'];
        if ($datosForm['padre']['tipoDoc'] == 'CUIT' || $datosForm['padre']['tipoDoc'] == 'CUIL') {
            $padreP->persona_cuil = $datosForm['padre']['cuil'];
            $padreP->persona_nro_doc = $this->obtenerDni($padreP->persona_cuil);
        } else {
            $padreP->persona_cuil = '';
            $padreP->persona_nro_doc = $datosForm['padre']['cuil'];
        }
        $padreP->persona_sexo = 2;
        $padreP->persona_tipodoc = 2;
        //$padreP->persona_domicilio=$responsableP->persona_domicilio;
        $idPersona = $this->idMaximo('persona_id', 'persona');
        if ($idPersona == "") {
            $padreP->persona_id = 1;
        } else {

            $padreP->persona_id = $idPersona + 1;
        }

        $padreP->persona_domicilio = $domicilio->domicilio_id;
        $insercion = $padreP->insert(false);

        $arrPersonas["padre"] = $padreP;
        //////////////////////Registramos a la madre como persona/////////////////////
        $madreP = new MYSQLPersona();
        $madreP->persona_nombres = $datosForm['madre']['apellidoYNombre'];
        $madreP->persona_apellidos = $datosForm['madre']['apellidoYNombre'];
        if ($datosForm['madre']['tipoDoc'] == 'CUIT' || $datosForm['madre']['tipoDoc'] == 'CUIL') {
            $madreP->persona_cuil = $datosForm['madre']['cuil'];
            $madreP->persona_nro_doc = $this->obtenerDni($madreP->persona_cuil); //Quita los primeros dos caracteres y el ultimo (queda el documento)
        } else {
            $madreP->persona_cuil = '';
            $madreP->persona_nro_doc = $datosForm['madre']['cuil'];
        }
        $madreP->persona_sexo = 2;
        $madreP->persona_tipodoc = 2;
        $madreP->persona_domicilio = $domicilio->domicilio_id;
        $idPersona = $this->idMaximo('persona_id', 'persona');
        if ($idPersona == '') {
            $madreP->persona_id = 1;
        } else {

            $madreP->persona_id = $idPersona + 1;
        }

        // $madreP->persona_domicilio=$responsableP->domicilio;
        $madreP->insert(false);
        $arrPersonas["madre"] = $madreP;
        //////Registramos al alumno como una persona///////

        foreach ($datosForm['alumnosArray'] as $unAlumno) {
            $alumnoP = new MYSQLPersona();
            $alumnoP->persona_apellidos = $unAlumno['apellidos'];
            $alumnoP->persona_nombres = $unAlumno['nombre'];
            if ($unAlumno['sexo'] == "F") {
                $alumnoP->persona_sexo = 1;
            } else {
                $alumnoP->persona_sexo = 2;
            }
            $alumnoP->persona_cuil = '';
            $alumnoP->persona_tipodoc = 2;
            $alumnoP->persona_nro_doc = $unAlumno['dni'];
            $alumnoP->persona_domicilio = $responsableP->persona_domicilio;
            $idPersona = $this->idMaximo('persona_id', 'persona');

            if ($idPersona == "") {
                $alumnoP->persona_id = 1;
            } else {
                $alumnoP->persona_id = $idPersona + 1;
            }
            $alumnoP->insert(false);
            $arrPersonas["alumnos"][] = $alumnoP;
        }

        //$alumnoP->domicilio=$responsableP->domicilio;

     

        return $arrPersonas;
    }

    /**
     * Dado nombre de atributo  y de la tabla a la que pertenece devuelve el id maximo
     * en BD de MYSQL
     * @param string $nombreId
     * @param string $nombreTabla
     * @return integer
     */
    public function idMaximo($nombreId, $nombreTabla, $db = "dbTwo")
    {
        if ($db == "dbTwo") {
            $obtenerObjetoArray = Yii::$app->dbTwo->createCommand('select max(' . $nombreId . ') from ' . $nombreTabla)->queryOne();
            $idMaximo = $obtenerObjetoArray['max(' . $nombreId . ')'];
        } else {
            $obtenerObjetoArray = Yii::$app->db->createCommand('select max(' . $nombreId . ') from ' . $nombreTabla)->queryOne();
            $idMaximo = $obtenerObjetoArray['max(' . $nombreId . ')'];
        }
        return $idMaximo;

    }
/**
 * Dado un cuil esta funcion retorna el numero de dni
 */
    public function obtenerDni($cuil)
    {
        $auxDoc = str_replace('-', '', $cuil); //Quitamos los guiones del cuit
        $nroDoc = substr($auxDoc, 2, strlen($auxDoc) - 3); //Quitamos los primeros dos numeros y el ultimo
        return $nroDoc;
    }
    /**
     * Esta funcion obtiene los ids de localidad y provincia de
     * la BD SQL Server y devuelve la localidad que corresponde en MYSQL (pues tienen ids distintos en la BD)
     * @param number $idLocalidadSQL
     * @param number $idProvinciaSQL
     * @return MYSQLCiudad
     */
    public function traerLocalidadMYSQL($idLocalidadSQL, $idProvinciaSQL)
    {
        $provincia = new Provincia();
        $localidad = Localidad::find()->where(['LocalidadKey' => $idLocalidadSQL])->one();
        $provincia = $provincia->find()->where(["ProvinciaKey" => $idProvinciaSQL])->one();
        $localidad = MYSQLCiudad::find()->select("*")->innerJoin('provincia', 'ciudad.ciudad_provincia=provincia.provincia_id')->where(["ciudad.ciudad_nombre" => $localidad->Nombre, 'provincia.provincia_nombre' => $provincia->Nombre])->one();
        return $localidad;
    }
/**
 * Dadas las personas del hijo ,padre y madre genera la union familiar

 */
    public function generarFamilia($alumnos, $padre, $madre, $legajo = "")
    {
        $familia = new MYSQLFamilia();
        $idFamilia = $this->idMaximo('familia_id', 'familia');
        if ($idFamilia == '') {
            $id = 1;
        } else {
            $id = $idFamilia + 1;
        }

        $familia->familia_id = $id;
        if ($legajo == "") {
            $legajo = $this->idMaximo('legajo', 'ODEO_alumno', 'db');
        }

        $familia->familia_legajo = $legajo;
        $familia->insert(false);
        foreach($alumnos as $unAlumno){//Insertamos los distintos hijos
            $relacionFamiliaHijo = new MYSQLPersonaFormaFamilia();
            $relacionFamiliaHijo->persona_id = $unAlumno->persona_id;
            $relacionFamiliaHijo->familia_id = $familia->familia_id;
            $relacionFamiliaHijo->parentezco = "Hijo";
            $relacionFamiliaHijo->insert(false);
    
         }
        
        $relacionFamiliaPadre = new MYSQLPersonaFormaFamilia();
        $relacionFamiliaPadre->persona_id = $padre->persona_id;
        $relacionFamiliaPadre->familia_id = $familia->familia_id;
        $relacionFamiliaPadre->parentezco = "Padre";
        $relacionFamiliaPadre->insert(false);
        $relacionFamiliaMadre = new MYSQLPersonaFormaFamilia();
        $relacionFamiliaMadre->persona_id = $madre->persona_id;
        $relacionFamiliaMadre->familia_id = $familia->familia_id;
        $relacionFamiliaMadre->parentezco = "Madre";
        $relacionFamiliaMadre->insert(false);
        return $relacionFamiliaHijo;

    }

    public function generarPostulante($alumnos, $responsable, $familia, $antNivel)
    {
        $i=0;
        foreach($alumnos as $unAlumno){
           $id= $this->idMaximo('postulante_id','postulante');
           if($id==""){
               $id=1;
           }else{
               $id=$id+1;
           }
             $postulante = new MYSQLPostulante();
        $nivelAct = new ODEONivel();
        $nivelAct = $nivelAct->findOne($antNivel[$i]['nivel']);
        $nivel = new MYSQLNivel();
        $nivel = $nivel->find()->where(['nivel_nombre' => $nivelAct->Nombre])->one();
        $postulante->postulante_id = $id;
        $postulante->postulante_persona = $unAlumno->persona_id;
        $postulante->postulante_confirmado = 0;
        $postulante->postulante_familia = $familia->familia_id;
        $postulante->postulante_nivel = $nivel->nivel_id;
        $postulante->postulante_responsable = $responsable->responsable_id;
        if ($postulante->insert(false)) {
            //echo "Postulante insertado";
        } else {
            //echo "Ocurrio un fallo al insertar al postulante";
        }
        $arrPost[]=$postulante;
        $i++;
        }
        
       
        return $arrPost;

    }

    public function generarSolicitud($postulantes)
    {$aRetornar=true;
        foreach($postulantes as $unPostulante){ 
        $relacionPostula = new MYSQLSolicitud_postula_postulante();
        $solicitudInscripcion = new MYSQLSolicitudInscripcion();
        $idSolicitud = $this->idMaximo('solicitud_id', 'solicitud_inscripcion');

        if ($idSolicitud == "") {

            $nro = 1;
        } else {
            $nro = $idSolicitud + 1;
        }

        $solicitudInscripcion->solicitud_nro = (int) $nro . date("Y");
        $solicitudInscripcion->solicitud_id = $nro;
        $solicitudInscripcion->solicitud_fecha = date("Y") . "-" . date("m") . "-" . date("d");
        $solicitudInscripcion->solicitud_estado = 0;
        $solicitudInscripcion->solicitud_establecimiento = 1;
        if ($insercionSI = $solicitudInscripcion->insert(false)) {
           // echo "Solicitud insertada";
        } else {
            echo "solicitud NO insertada";
        }
        $relacionPostula->postulante_id = $unPostulante->postulante_id;
        $relacionPostula->solicitud_id = $solicitudInscripcion->solicitud_id;
        $insercionRP = $relacionPostula->insert(false);
        $aRetornar =$aRetornar && $insercionRP && $insercionSI;
        $solicitudes[]=$solicitudInscripcion;

            
        }
       

        return [$aRetornar,$solicitudes];

    }
    public function pdfSolicitud($responsable, $padre, $madre, $alumnos)
    { // Marcos

        ////////////////// CREACION DE PDF ///////////////////////////

        $pdf = new FPDF('P', 'mm', 'Legal'); //A3, A4, A5, Letter y Legal.

        ob_end_clean();
        $pdf->AddPage();

        $pdf->SetFont('Arial', 'B', 12);
        $pdf->SetXY(20, 10);
        $pdf->Cell(220, 10, utf8_decode('FICHA DE INTENCIÓN DE CONFIRMACIÓN DE VACANTES'), 0, 1, '');

        $pdf->Image('../imagenes/fatima.jpg', 20, 20, 50);
        ////////////////////////////   Titulo ///////////////////////////
        $pdf->SetFont('Arial', '', 10);
        $pdf->SetXY(80, 30);
        $pdf->Cell(220, 10, utf8_decode('FECHA DE RECEPCIÓN: ' . date('d/m/Y')), 0, 1, '');

        /// Encabezado del formulario
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->SetXY(20, 45);
        $pdf->Cell(220, 10, utf8_decode('RESPONSABLE'), 0, 1, '');

        ///////////////////// Datos del RESPONSABLE del grupo familiar /////////////////

        $provincia = Provincia::find()->where(["ProvinciaKey" => $responsable['provincia']])->one();
        $localidad = Localidad::find()->where(['LocalidadKey' => $responsable['localidad']])->one();

        $pdf->SetFont('Arial', '', 10);
        $pdf->SetXY(30, 50);
        $pdf->Cell(260, 10, utf8_decode('LEGAJO: ' . $responsable['legajo']), 0, 1, '');
        $pdf->SetXY(140, 50);
        $pdf->Cell(260, 10, utf8_decode('CUIT/CUIL: ' . $responsable['cuit']), 0, 1, '');

        $pdf->SetXY(30, 55);
        $pdf->Cell(260, 10, utf8_decode('APELLIDO Y NOMBRE: ' . $responsable['apellidoYNombre']), 0, 1, '');

        $pdf->SetXY(30, 60);
        $pdf->Cell(260, 10, utf8_decode('CÓDIGO POSTAL: ' . $responsable['codigo_postal']), 0, 1, '');
        $pdf->SetXY(90, 60);
        $pdf->Cell(260, 10, utf8_decode('PROVINCIA: ' . $provincia->Nombre), 0, 1, '');
        $pdf->SetXY(140, 60);
        $pdf->Cell(260, 10, utf8_decode('LOCALIDAD: ' . $localidad->Nombre), 0, 1, '');

        $pdf->SetXY(30, 65);
        $pdf->Cell(260, 10, utf8_decode('DOMICILIO: ' . $responsable['domicilio']), 0, 1, '');
        $pdf->SetXY(30, 70);
        $pdf->Cell(260, 10, utf8_decode('TELÉFONO   FIJO: ' . $responsable['telefonoFijo'] . '   MÓVIL: ' . $responsable['telefonoMovil']), 0, 1, '');
        $pdf->SetXY(30, 75);
        $pdf->Cell(260, 10, utf8_decode('E-MAIL: ' . $responsable['email']), 0, 1, '');

        $pdf->SetXY(20, 80);
        $pdf->Cell(260, 10, utf8_decode('--------------------------------------------------------------------------------------------------------------------------------------------------------'), 0, 1, '');
        ///////////////////// Datos del PADRE /////////////////

        $pdf->SetFont('Arial', 'B', 12);
        $pdf->SetXY(20, 90);
        $pdf->Cell(220, 10, utf8_decode('PADRE'), 0, 1, '');

        $pdf->SetFont('Arial', '', 10);
        $pdf->SetXY(30, 95);
        $pdf->Cell(100, 10, utf8_decode('APELLIDO Y NOMBRE: ' . $padre['apellidoYNombre']), 0, 1, '');
        $pdf->SetXY(30, 100);
        $pdf->Cell(100, 10, utf8_decode('OCUPACIÓN: ' . $padre['ocupacion']), 0, 1, '');
        $pdf->SetXY(140, 100);
        $pdf->Cell(100, 10, utf8_decode('CUIT/CUIL: ' . $padre['cuil']), 0, 1, '');
        $pdf->SetXY(30, 105);
        $pdf->Cell(100, 10, utf8_decode('TELÉFONO:   FIJO : ' . $padre['telefonoFijo'] . '   MÓVIL ' . $padre['telefonoMovil']), 0, 1, '');

        $pdf->SetXY(30, 110);
        $pdf->Cell(100, 10, utf8_decode('LUGAR DE TRABAJO: ' . $padre['lugarTrabajo']), 0, 1, '');
        $pdf->SetXY(140, 110);
        $pdf->Cell(250, 10, utf8_decode('TELÉFONO  LABORAL: ' . $madre['telefonoLaboral']), 0, 1, '');
        $pdf->SetXY(30, 115);
        $pdf->Cell(100, 10, utf8_decode('FECHA DE NACIMIENTO: ' . $padre['fechaNacimiento']), 0, 1, '');
        $pdf->SetXY(140, 115);
        $pdf->Cell(100, 10, utf8_decode('NACIONALIDAD: ' . $padre['nacionalidad']), 0, 1, '');

        $pdf->SetXY(30, 120);
        $pdf->Cell(150, 10, utf8_decode('EGRESO DE NIVEL PRIMARIO DE ESTE INSTITUTO? : ' . $padre['escuelaPrimaria']), 0, 1, '');
        $pdf->SetXY(30, 125);
        $pdf->Cell(150, 10, utf8_decode('EGRESO DE NIVEL SECUNDARIO DE ESTE INSTITUTO? : ' . $padre['escuelaSecundaria']), 0, 1, '');

        $pdf->SetXY(30, 130);
        $pdf->Cell(150, 10, utf8_decode('BAUTISMO: ' . $padre['bautismo']), 0, 1, '');
        $pdf->SetXY(80, 130);
        $pdf->Cell(150, 10, utf8_decode('COMUNIÓN: ' . $padre['comunion']), 0, 1, '');
        $pdf->SetXY(130, 130);
        $pdf->Cell(150, 10, utf8_decode('CONFIRMACIÓN: ' . $padre['confirmacion']), 0, 1, '');

        $pdf->SetXY(20, 135);
        $pdf->Cell(260, 10, utf8_decode('--------------------------------------------------------------------------------------------------------------------------------------------------------'), 0, 1, '');

        ///////////////////// Datos del MADRE /////////////////

        $pdf->SetFont('Arial', 'B', 12);
        $pdf->SetXY(20, 145);
        $pdf->Cell(220, 10, utf8_decode('MADRE'), 0, 1, '');

        $pdf->SetFont('Arial', '', 10);
        $pdf->SetXY(30, 150);
        $pdf->Cell(100, 10, utf8_decode('APELLIDO Y NOMBRE: ' . $madre['apellidoYNombre']), 0, 1, '');
        $pdf->SetXY(30, 155);
        $pdf->Cell(100, 10, utf8_decode('OCUPACIÓN: ' . $madre['ocupacion']), 0, 1, '');
        $pdf->SetXY(140, 155);
        $pdf->Cell(100, 10, utf8_decode('CUIT/CUIL: ' . $madre['cuil']), 0, 1, '');
        $pdf->SetXY(30, 160);
        $pdf->Cell(100, 10, utf8_decode('TELÉFONO:   FIJO : ' . $madre['telefonoFijo'] . '   MÓVIL ' . $madre['telefonoMovil']), 0, 1, '');

        $pdf->SetXY(30, 165);
        $pdf->Cell(100, 10, utf8_decode('LUGAR DE TRABAJO: ' . $madre['lugarTrabajo']), 0, 1, '');
        $pdf->SetXY(140, 165);
        $pdf->Cell(250, 10, utf8_decode('TELÉFONO  LABORAL: ' . $madre['telefonoLaboral']), 0, 1, '');
        $pdf->SetXY(30, 170);
        $pdf->Cell(100, 10, utf8_decode('FECHA DE NACIMIENTO: ' . $madre['fechaNacimiento']), 0, 1, '');
        $pdf->SetXY(140, 170);
        $pdf->Cell(100, 10, utf8_decode('NACIONALIDAD: ' . $madre['nacionalidad']), 0, 1, '');

        $pdf->SetXY(30, 175);
        $pdf->Cell(150, 10, utf8_decode('EGRESO DE NIVEL PRIMARIO DE ESTE INSTITUTO? : ' . $madre['escuelaPrimaria']), 0, 1, '');
        $pdf->SetXY(30, 180);
        $pdf->Cell(150, 10, utf8_decode('EGRESO DE NIVEL SECUNDARIO DE ESTE INSTITUTO? : ' . $madre['escuelaSecundaria']), 0, 1, '');

        $pdf->SetXY(30, 185);
        $pdf->Cell(150, 10, utf8_decode('BAUTISMO: ' . $madre['bautismo']), 0, 1, '');
        $pdf->SetXY(80, 185);
        $pdf->Cell(150, 10, utf8_decode('COMUNIÓN: ' . $madre['comunion']), 0, 1, '');
        $pdf->SetXY(130, 185);
        $pdf->Cell(150, 10, utf8_decode('CONFIRMACIÓN: ' . $madre['confirmacion']), 0, 1, '');

        $pdf->SetXY(20, 190);
        $pdf->Cell(260, 10, utf8_decode('--------------------------------------------------------------------------------------------------------------------------------------------------------'), 0, 1, '');

        //////////////////////  Datos del/de los  ALUMNO/S  /////////////////
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->SetXY(20, 200);
        $pdf->Cell(220, 10, utf8_decode('ALUMNO/S'), 0, 1, '');

        $linea = 200;
        for ($i = 0; $i < count($alumnos); $i++) {
            $pdf->SetFont('Arial', '', 10);
            $pdf->SetXY(30, $linea = $linea + 5);
            $pdf->Cell(150, 10, utf8_decode('APELLIDO Y NOMBRE: ' . $alumnos[$i]['apellidos'] . ' ' . $alumnos[$i]['nombre']), 0, 1, '');
            $pdf->SetXY(140, $linea);
            $pdf->Cell(150, 10, utf8_decode('DNI: ' . $alumnos[$i]['dni']), 0, 1, '');

            $pdf->SetXY(30, $linea = $linea + 5);
            $nombreNivel=ODEONivel::findOne($alumnos[$i]['nivel']);
            $pdf->Cell(250, 10, utf8_decode('NIVEL: ' . $nombreNivel->Nombre), 0, 1, '');
            $pdf->SetXY(70, $linea);
            $nombreGrado=ODEOGrado::findOne($alumnos[$i]['grado']);
            $pdf->Cell(250, 10, utf8_decode('SALA/GRADO/CURSO: ' . $nombreGrado->DescripcionFacturacion), 0, 1, '');
            $pdf->SetXY(140, $linea);
            $nombreSeccion=ODEODivision::findOne($alumnos[$i]['seccion']);
            $pdf->Cell(250, 10, utf8_decode('SECCIÓN: ' . $nombreSeccion->Nombre), 0, 1, '');
            $pdf->SetXY(30, $linea = $linea + 5);
            $pdf->Cell(150, 10, utf8_decode('LUGAR DE NACIMIENTO: ' . $alumnos[$i]['lugarNacimiento']), 0, 1, '');
            $pdf->SetXY(140, $linea);
            $pdf->Cell(150, 10, utf8_decode('FECHA DE NACIMIENTO: ' . $alumnos[$i]['fechaNacimiento']), 0, 1, '');
            $pdf->SetXY(30, $linea = $linea + 5);
            $pdf->Cell(150, 10, utf8_decode('FECHA DE INGRESO: ' . $alumnos[$i]['fechaIngreso']), 0, 1, '');
            $pdf->SetXY(140, $linea);
            $pdf->Cell(150, 10, utf8_decode('FECHA DE EGRESO: ' . $alumnos[$i]['fechaEgreso']), 0, 1, '');

            $pdf->SetXY(30, $linea = $linea + 5);
            $pdf->Cell(150, 10, utf8_decode('BAUTISMO: ' . $alumnos[$i]['bautismo']), 0, 1, '');
            $pdf->SetXY(70, $linea);
            $pdf->Cell(150, 10, utf8_decode('LUGAR: ' . $alumnos[$i]['lugarBautismo']), 0, 1, '');
            $pdf->SetXY(140, $linea);
            $pdf->Cell(150, 10, utf8_decode('DIOCESIS: ' . $alumnos[$i]['diosecisBautismo']), 0, 1, '');

            $pdf->SetXY(30, $linea = $linea + 5);
            $pdf->Cell(150, 10, utf8_decode('COMUNION: ' . $alumnos[$i]['comunion']), 0, 1, '');
            $pdf->SetXY(70, $linea);
            $pdf->Cell(150, 10, utf8_decode('LUGAR: ' . $alumnos[$i]['lugarComunion']), 0, 1, '');
            $pdf->SetXY(140, $linea);
            $pdf->Cell(150, 10, utf8_decode('DIOCESIS: ' . $alumnos[$i]['diosecisComunion']), 0, 1, '');

            $pdf->SetXY(30, $linea = $linea + 5);
            $pdf->Cell(150, 10, utf8_decode('CONFIRMACIÓN: ' . $alumnos[$i]['confirmacion']), 0, 1, '');
            $pdf->SetXY(70, $linea);
            $pdf->Cell(150, 10, utf8_decode('LUGAR: ' . $alumnos[$i]['lugarConfirmacion']), 0, 1, '');
            $pdf->SetXY(140, $linea);
            $pdf->Cell(150, 10, utf8_decode('DIOCESIS: ' . $alumnos[$i]['diosecisConfirmacion']), 0, 1, '');

            $linea = $linea + 5;
        }

        ///$pdf->Output();

        ///////// salida a formato pdf ///$responsable['legajo']

        $nombre = time() . '_' . $responsable['legajo'] . '.pdf';
        $filename = "../registros_pdf/$nombre";
        $pdf->Output($filename, 'F');

        return $filename;
    }

}