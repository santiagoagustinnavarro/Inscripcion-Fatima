<?php

namespace app\controllers;
use app\models\ODEOCliente;
use app\models\MYSQLUsuario;
use app\models\MYSQLUsuarioSearch;
use Yii;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Session;

/**
 * MYSQLUsuarioController implements the CRUD actions for MYSQLUsuario model.
 */
class UsuarioController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all MYSQLUsuario models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MYSQLUsuarioSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single MYSQLUsuario model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new MYSQLUsuario model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new MYSQLUsuario();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->usuario_id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing MYSQLUsuario model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
   
    
    {
        $model = $this->findModel($id);
        $session = Yii::$app->session;
        $session->open();
        if($model->usuario_nombre==$session->get('username')){
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                echo "enviano mail por favor espere...";
                $responsable = ODEOCliente::find()->select(['loc.localidadkey', 'cliente.numeroDocumento', 'cliente.clientekey', 'cliente.codigo', 'cliente.razonsocial as titular', 'cliente.cuit', 'cliente.domicilio as domiciliotitular', 'isNull(cliente.CodigoPostal, \'\') + \' - \' + cliente.Localidad as LocalidadTitular', 'prov.nombre as provinciatitular', 'loc.codigopostal as cptitular', 'prov.provinciakey', 'cliente.telefono as teltitular', 'cliente.telefonomovil as celtitular', 'cliente.email as emailtitular'])->innerJoin('localidad as loc', 'cliente.localidadkey=loc.localidadkey')->innerJoin('provincia as prov', 'prov.provinciakey=loc.provinciakey')->where(['cliente.codigo' => $model->usuario_nombre])->andWhere('cliente.clientekey in (select clientekey from V_ODEO_TitularesVigentes)')->OrderBy('cliente.clientekey', 'desc')->asArray()->one();
                Yii::$app->mailer->compose()
        ->setFrom('santiagoanavarro018@gmail.com')
        ->setTo($responsable['emailtitular'])
        ->setSubject('Cambio de clave')
        ->setTextBody('Le enviamos sus datos')
        ->setHtmlBody('Su usuario es: '.$model->usuario_nombre.' y su clave es: '.$model->usuario_clave)//// escribo el msj del correo
        ->send();
                return $this->redirect(Url::base() . '/inscripcion?id=' . $model->usuario_nombre);
            }

            return $this->render('update', [
                'model' => $model,
            ]);
        }else{
            echo "Por agun motivo no funciona lo de sesion";
            echo $model->usuario_nombre;
            echo $session->get('username');
           return $this->redirect(Url::base() . '/usuario/sesion');
        }
    }

    /**
     * Deletes an existing MYSQLUsuario model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the MYSQLUsuario model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return MYSQLUsuario the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MYSQLUsuario::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionIniciado()
    {
        $session = Yii::$app->session;
        $session->open();
        $activo = false;
        // Variables pasada por POST desde el formulario
        $legajo = Yii::$app->request->post('legajo');
        $clave = Yii::$app->request->post('clave');
        if ($legajo != null) {
            $activo = $this->esActivoLegajo($legajo,$clave);
        }

        /*if($activo) {
    $session->set('iniciado',1);
    $session->set('username',$legajo);

    return $this->redirect(Url::base().'/inscripcion?id='.$legajo);
    }else{
    return  $this->redirect(['usuario/sesion']);
    }*/
    }

    public function actionSesion()
    {
        $session = Yii::$app->session;
        $session->open();
        if ($session->get('iniciado') != null) {
            $session->remove('iniciado');
        }
        $session->destroy();
        return $this->render('formSesion');
    }

    public function esActivoLegajo($legajo,$clave)
    {
        $session = Yii::$app->session;
        $consulta = $this->listarAlumnosActivos($legajo);
        $activo = false;

        if ($consulta != null) {
            $activo = true;

            $objUsuario = MYSQLUsuario::find()->where(["usuario_nombre" => $legajo])->one();

            if ($objUsuario != null) {
               
                $session->set('iniciado', 1);
                $session->set('idAlumno',$objUsuario->usuario_id);
                $session->set('username', $legajo);
                if($clave==$objUsuario->usuario_clave){//Verifica la igualdad de las claves
                    
                
                    if ($objUsuario->usuario_creado == 0) {
                        // direcciona al formulario de Usuario para modificar  solamente la clave(el legajo no se modifica)
                        // hacer un ajax para verificar que la clave no sea 1234
                        
                        return $this->redirect(Url::base() .'/usuario/update?id='.$objUsuario->usuario_id);

                    } else {
                        return $this->redirect(Url::base() . '/inscripcion?id=' . $legajo); // ir a   reinscripcion
                    }
                }else{
                    return $this->redirect(Url::base() .'/usuario/sesion');
                }
            } else { // si no existe el legajo en la tabla usuario
                $session->set('iniciado', 1);
                $session->set('username', $legajo);
                $nuevoUsuario = new MYSQLUsuario();
                $nuevoUsuario->usuario_nombre = $legajo;
                $nuevoUsuario->usuario_clave = "1234";
                $nuevoUsuario->usuario_activo = 1;
                $nuevoUsuario->usuario_creado=0;
                $nuevoUsuario->usuario_nick = $legajo;
                if($clave==$nuevoUsuario->usuario_clave){
                    if($nuevoUsuario->insert(false)){
                    //echo "El usuario se ah insertado";
                    $objUsuario = MYSQLUsuario::find()->where(["usuario_nombre" => $legajo])->one();
                    $session->set('idAlumno',$objUsuario->usuario_id);
                    return $this->redirect(Url::base() .'/usuario/update?id='.$objUsuario->usuario_id);
                    }else{
                    echo "Ocurrio un fallo";
                    print_r($nuevoUsuario->getErrors());

                    }
                }else{
                    return $this->redirect(Url::base() .'/usuario/sesion');
                }
                 
                // esta acciòn queda pendiente para desarrollar
            }
        }

        return $activo;
    }
    public function listarAlumnosActivos($legajo)
    {
        $consulta = Yii::$app->db->createCommand("select a.ODEO_AlumnoKey,c.ClienteKey, a.Apellido, a.Nombre,
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
    where a.vigente = 1 and legajo=$legajo  order by c.ClienteKey")->queryAll();

        return $consulta;
    }
}