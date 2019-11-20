<?php 
    namespace app\controllers;

    use Yii;
    use yii\filters\AccessControl;
    use yii\web\Controller;
    use yii\web\Response;
    use yii\filters\VerbFilter;
    use app\models\LoginForm;
    use app\models\ContactForm;
    
    class InscripcionController extends Controller{

        function actionIndex(){
            $provincias=  
['Ninguna'=>'Seleccione una opcion',
'Neuquen'=>'Neuquen'      
,'Rio Negro'=>'Rio Negro',
'Jujuy'=>'Jujuy',
'Catamarca'=>'Catamarca',
'Chaco'=>'Chaco',
'Buenos Aires'=>'Buenos Aires',
'Cordoba'=>'Cordoba',
'Formosa'=>'Formosa',
'Entre Rios'=>'Entre Rios',
'San Juan'=>'San Juan',
'San Luis'=>'San Luis',
'Mendoza'=>'Mendoza',
'Formosa'=>'Formosa',
'La Rioja'=>'La Rioja',
'Misiones'=>'Misiones',
'Tierra del Fuego'=>'Tierra del Fuego',
'Chubut'=>'Chubut',
'Santa Cruz'=>'Santa Cruz',
'La Pampa'=>'La Pampa',
'Santiago del Estero'=>'Santiago del Estero',
'Tucuman'=>'Tucuman',
'Salta'=>'Salta',
'Santa Fe'=>'Santa Fe',
];
$localidades= 
    ['Neuquen'=>['Localidades'=>['Seleccione una opcion','Neuquen']]        
    ,'Jujuy'=>['Localidades'=>[]],
    'Catamarca'=>['Localidades'=>[]],
    'Chaco'=>['Localidades'=>[]],
    'Buenos Aires'=>['Localidades'=>[]],
    'Cordoba'=>['Localidades'=>[]],
    'Formosa'=>['Localidades'=>[]],
    'Entre Rios'=>['Localidades'=>[]],
    'San Juan'=>['Localidades'=>[]],
    'San Luis'=>['Localidades'=>[]],
    'Mendoza'=>['Localidades'=>[]],
    'Formosa'=>['Localidades'=>[]],
    'La Rioja'=>['Localidades'=>[]],
    'Misiones'=>['Localidades'=>[]],
    'Tierra del Fuego'=>['Localidades'=>[]],
    'Chubut'=>['Localidades'=>[]],
    'Santa Cruz'=>['Localidades'=>[]],
    'La Pampa'=>['Localidades'=>[]],
    'Santiago del Estero'=>['Localidades'=>[]],
    'Tucuman','Salta'=>['Localidades'=>[]],
    'Santa Fe'=>['Localidades'=>[]],
    'Rio Negro'=>['Localidades'=>[
    'Seleccione una opcion',
    'Cipolletti',
     'San Carlos de Bariloche',
    'General Roca',
    'Viedma (capital)',
    'Villa Regina',
    'Allen',
   ' Cinco Saltos',
    'San Antonio Oeste',
    'El Bolsón',
    'Catriel',
    'Río Colorado',
    'Choele Choel',
    'Sierra Grande',
   'Ingeniero Jacobacci',
    'Ingeniero Huergo',
    'General Fernández Oro',
    'Lamarque',
    'General Enrique Godoy',
    'Luis Beltrán',
    'Dina Huapi',
  	]]      
    ];
    ///////Array asociativo de localidades y barrios///////////////////////////////////////////////
$barrios=[
'Neuquen'=>
    ['Codigo postal'=>'8300','Barrios'=>['Ciudad Industrial Jaime de Nevares',
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
    ]
],
'Cipolletti'=>
    ['Codigo postal'=>'8324',
    'Barrios'=>[
        '150 viviendas',
        '190 viviendas',
        '1224 Viviendas',
        '12 de Septiembre',
        'Alanís',
        'Anai Mapu',
        'Anzanas del Sol',
        'Área Centro',
        'Arévalo',
        'Barri',
        'Belgrano',
        'Brentana',
        'Capellán',
        'C.G.T.',
        'Distrito noreste',
        'Del Trabajo',
        'Don Bosco',
        'El Gran Chaparral',
        'Ferri',
        'Filipussi',
        'Flamingo',
        'Hidronor',
        'Jorge Newbery',
        'La Escondida',
        'La Paz',
        'Las Viñas',
        'Los Pinos',
        'Los Tordos I',
        'Los Tordos II',
        'Loteo Landi',
        'Luis Piedra Buena',
        'Manzanares 7',
        'Manzanares 8',
        'Manzanares 9',
        'Mercantil',
        'Milenium',
        'Parque',
        'Parque Industrial',
        'Patricios I',
        'Patricios II',
        'Pichi Nahuel',
        'Policial',
        'Rincón Lindo I',
        'Rincón Lindo II',
        'Rosauer',
        'San Lorenzo',
        'San Pablo',
        'San Sebastián',
        'Santa Clara',
        'Santa Rosa',
        'Sausal Bonito',
        'Solares de la Falda',
        'Unter',
        'Villa Alicia',
        'Villarino',
        '2 de agosto',
        'Costa Norte',
        'Costa Sur',
        'Detrás de la cárcel',
        'Gorritti',
        'Labraña',
        'La Lor',
        'María Elvira',
        'Puente 83',
        'Puente de Madera',
        'Santa Marta',
        'Tres Luces',
        'Las Perlas'
        ]
    ]
];
            $js="$(document).ready(
                function(){
                    $(\"select[name='responsable[provincia]']\").click(
                        function(){
                            var provincia=$(\"select[name='responsable[provincia]']\");
                            var localidad=$(\"select[name='responsable[localidad]']\");
                            var codigo=$(\"input[name='responsable[codigo_postal]']\");
                            var barrio=$(\"select[name='responsable[barrio]']\");
                            barrio.html('');
                            codigo.html('');
                            localidad.html('');
                            
                            if (provincia.val()=='Neuquen'){
                                localidad.html('');
                                localidad.html('"; 
                                foreach($localidades['Neuquen']['Localidades'] as $unaLocalidad){
                                    $js=$js."<option value=\"".$unaLocalidad."\">".$unaLocalidad."</option>";
                                }
                            $js=$js."');

                            }
                            else{
                                localidad.html('');
                                if (provincia.val()=='Rio Negro'){
                                    
                                    localidad.html('"; 
                                    foreach($localidades['Rio Negro']['Localidades'] as $unaLocalidad){
                                        $js=$js."<option value=\"".$unaLocalidad."\">".$unaLocalidad."</option>";
                                    }
                                $js=$js."')
                                }

                            
                            }
                        });
                    $(\"select[name='responsable[localidad]']\").click(function(){
                        var barrio=$(\"select[name='responsable[barrio]']\");
                        var localidad=$(\"select[name='responsable[localidad]']\");
                        var codigo=$(\"input[name='responsable[codigo_postal]']\");
                        codigo.val('');
                        if (localidad.val()=='Cipolletti'){
                            barrio.html('');
                            barrio.html('"; 
                            foreach($barrios['Cipolletti']['Barrios'] as $unBarrio){
                                $js=$js."<option value=\"".$unBarrio."\">".$unBarrio."</option>";
                            }
                        $js=$js."');
                            codigo.val(";
                            $js=$js.$barrios['Cipolletti']['Codigo postal'];
                            $js=$js.");
                        }else{
                            barrio.html('');
                            if (localidad.val()=='Neuquen'){
                                barrio.html('"; 
                                foreach($barrios['Neuquen']['Barrios'] as $unBarrio){
                                    $js=$js."<option value=\"".$unBarrio."\">".$unBarrio."</option>";
                                }
                            $js=$js."');
                            codigo.val(";
                            $js=$js.$barrios['Neuquen']['Codigo postal'];
                            $js=$js.")
                            }

                        }

                    });

                    $(\"select[name='alumno[seccion]']\").click(
                        function(){
                            var seccion=$(\"select[name='alumno[seccion]']\");
                            var grado=$(\"select[name='alumno[grado]']\");
                            var nivel=$(\"select[name='alumno[nivel]']\");
                            grado.html('');
                            nivel.html('');
                            if(seccion.val()=='A' || seccion.val()=='B'){
                                nivel.html('<option value=\"Ninguno\">Seleccione una opcion</option><option value=\"Inicial\">Inicial</option><option value=\"Primaria\">Primaria</option>');
                               
                            }else{
                                if(seccion.val()=='C' || seccion.val()=='D' || seccion.val()=='E' ){
                                    nivel.html('<option value=\"Ninguno\">Seleccione una opcion</option><option value=\"Medio\">Medio</option>');
                                }
                            }
                        }
                    );
                    $(\"select[name='alumno[nivel]']\").click(
                        function(){
                            var seccion=$(\"select[name='alumno[seccion]']\");
                            var grado=$(\"select[name='alumno[grado]']\");
                            var nivel=$(\"select[name='alumno[nivel]']\");
                            
                            if( nivel.val()=='Inicial'){
                                grado.html('<option value=\"Ninguno\">Seleccione una opcion</option><option value=\"Salita de 3\">Salita de 3</option><option value=\"Salita de 4\">Salita de 4</option><option value=\"Salita de 5\">Salita de 5</option>');
                            }else{
                                if( nivel.val()=='Primaria'){
                                    grado.html('<option value=\"Ninguno\">Seleccione una opcion</option><option value=\"Primer grado\">Primer grado</option><option value=\"Segundo grado\">Segundo grado</option><option value=\"Tercer grado\">Tercer grado</option><option value=\"Cuarto grado\">Cuarto grado</option><option value=\"Quinto grado\">Quinto grado</option><option value=\"Sexto grado\">Sexto grado</option><option value=\"Septimo grado\">Septimo grado</option>');
                                }else{
                                    if( nivel.val()=='Medio'){
                                        grado.html('<option value=\"Ninguno\">Seleccione una opcion</option><option value=\"Primer año\">Primer año</option><option value=\"Segundo año\">Segundo año</option><option value=\"Tercer año\">Tercer año</option><option value=\"Cuarto año\">Cuarto año</option><option value=\"Quinto año\">Quinto año</option>');
                                    }

                                }
                            }
                        }
                    );
                    $(\"select[name='alumno[bautismo]']\").click(
                        function(){
                            var bautismo=$(\"select[name='alumno[bautismo]']\");
                            var fechaBautismo=$(\"input[name='alumno[fechaBautismo]']\");
                            var lugarBautismo=$(\"input[name='alumno[lugarBautismo]']\");
                            if(bautismo.val()=='No'){
                                fechaBautismo.attr('disabled',true);
                                lugarBautismo.prop('disabled',true);
                            }else{
                              
                                fechaBautismo.attr('disabled',false);
                                lugarBautismo.prop('disabled',false);
                            }

                    }
                );
                $(\"select[name='alumno[comunion]']\").click(
                    function(){
                        var comunion=$(\"select[name='alumno[comunion]']\");
                        var fechaComunion=$(\"input[name='alumno[fechaComunion]']\");
                        var lugarComunion=$(\"input[name='alumno[lugarComunion]']\");
                        if(comunion.val()=='No'){
                            fechaComunion.attr('disabled',true);
                            lugarComunion.prop('disabled',true);
                        }else{
                          
                            fechaComunion.attr('disabled',false);
                            lugarComunion.prop('disabled',false);
                        }
                }
            );

            $(\"select[name='alumno[confirmacion]']\").click(
                function(){
                    var confirmacion=$(\"select[name='alumno[confirmacion]']\");
                    var fechaConfirmacion=$(\"input[name='alumno[fechaConfirmacion]']\");
                    var lugarConfirmacion=$(\"input[name='alumno[lugarConfirmacion]']\");
                    if(confirmacion.val()=='No'){
                        fechaConfirmacion.attr('disabled',true);
                        lugarConfirmacion.prop('disabled',true);
                    }else{
                      
                        fechaConfirmacion.attr('disabled',false);
                        lugarConfirmacion.prop('disabled',false);
                    }
            }
        );
        $(\"input[name='Aceptar']\").click(function(){
             $(\"#modal\").modal();
        })
                        
                })";
           return $this->render('index',['js'=>$js,'provincias'=>$provincias,'localidades'=>$localidades,'barrios'=>$barrios]);
        }
    }
?>