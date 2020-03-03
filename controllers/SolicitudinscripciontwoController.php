<?php

namespace app\controllers;

use Yii;
use app\models\MYSQLSolicitudInscripcion;
use app\models\MYSQLSolicitudInscripcionSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * SolicitudinscripciontwoController implements the CRUD actions for MYSQLSolicitudInscripcion model.
 */
class SolicitudinscripciontwoController extends Controller
{
    public function actionSolicitarinscripcion()
    {
        $responsable = Yii::$app->request->post('responsable'); // ok funciona
        $padre = Yii::$app->request->post('padre'); // ok funciona
        $madre = Yii::$app->request->post('madre'); // ok funciona
        $alumnos = Yii::$app->request->post('alumnosArray');

       $dir_pdf = $this->pdfSolicitud($responsable, $padre, $madre, $alumnos);

        /// Envia un mail con el pdf adjunto
       /* Yii::$app->mailer->compose()
            ->setFrom('santiagoanavarro018@gmail.com')
            ->setTo($responsable['email'])
            ->setSubject('Formulario')
            ->setTextBody('adjuntamos archivo')
            ->setHtmlBody('Adjuntamos en formato <b>PDF</b> la inscripción') //// escribo el msj del correo
            ->attach("../registros_pdf/" . $dir_pdf)
            ->send();*/
            $familia=MYSQLFamilia::find()->where("legajo=".$responsable['legajo'])->one();
            if($familia!=null){//Ya esta en MYSQL

            }else{//Nuevo en nuestra BD
                $personaPost=new MYSQLPersona();
                $idPost=$this->idMaximo('persona_id','persona');
                for($i=0;$i<count($alumnos);$i++){
                    $datos=['nombres'=>$alumnos[$i]['nombre'],'apellidos'=>$alumnos[$i]['apellidos'],'nroDoc'=>$alumnos[$i]['dni'],'cuil'=>'','sexo'=>$alumnos[$i]['sexo'],'nivel'=>$alumnos[$i]['nivel'],'grado'=>$alumnos[$i]['grado'],'seccion'=>$alumnos[$i]['seccion'],'lugarNacimiento'=>$alumnos[$i]['lugarNacimiento'],'fechaNacimiento'=>$alumnos[$i]['fechaNacimiento'],'fechaIngreso'=>$alumnos[$i]['fechaIngreso']];
                   $nuevaPersona=$this->nuevaPersona($datos,$idPost);
                }

            }


    
}
function nuevaPersona($arrInfo,$idMax=""){

}
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
public function pdfSolicitud($responsable, $padre, $madre, $alumnos)
    { // Marcos

        ////////////////// CREACION DE PDF ///////////////////////////

        $pdf = new FPDF('P', 'mm', 'Legal'); //A3, A4, A5, Letter y Legal.

        ob_end_clean();
        $pdf->AddPage();

        $pdf->SetFont('Arial', 'B', 12);
        $pdf->SetXY(20, 10);
        $pdf->Cell(220, 10, utf8_decode('FICHA DE INTENCIÓN DE INSCRIPCIÓN ALUMNOS NUEVOS'), 0, 1, '');

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
            $pdf->Cell(250, 10, utf8_decode('NIVEL: ' . $alumnos[$i]['nivel']), 0, 1, '');
            $pdf->SetXY(70, $linea);
            $pdf->Cell(250, 10, utf8_decode('SALA/GRADO/CURSO: ' . $alumnos[$i]['grado']), 0, 1, '');
            $pdf->SetXY(140, $linea);
            $pdf->Cell(250, 10, utf8_decode('SECCIÓN: ' . $alumnos[$i]['seccion']), 0, 1, '');
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