<!DOCTYPE html>
<?php
    //session_start(); // al volver al index si existe una session, esta sera destruida, existen formas de conservarlas como con un if(session_start()!= NULL). Pero por el momento para el ejemplo no es valido.
    session_destroy();// Se destruye la session existente de esta forma no permite el duplicado.

    use yii\helpers\Html;
    use yii\helpers\ArrayHelper;
    use yii\bootstrap\ActiveForm;
    use yii\jui\DatePicker;
    use yii\bootstrap\Modal;
    use yii\helpers\Url;
    $this->title="Iniciar Sesión";
?>

<html lang="es">
    <head>
            <title>OPTIK</title>
            <style type="text/css">

            .input_personalizado{
              padding: 10px; font-weight: 600; font-size: 12px;
              border-radius: 8px;
              width:278px;
              border: 2px solid #0016b0;
            }
            .active_input:hover {
              color: black;
              border: 2px solid black;
            }

            .boton_ingresar{
              text-decoration: none; padding: 10px; font-weight: 600; font-size: 15px;
              color: #ffffff; background-color: #6699ff;
              border-radius: 8px; width:280px; border: 2px solid #0016b0;
              text-shadow: black 0.05em 0.05em 0.05em;
            }
            .active_ingresar:hover {
            background-color: #1743ba;
               border: 2px solid black;

            }

            .sesion{
            color: #ffffff;  padding: 20px; font-weight: 100; font-size: 28px;  text-shadow: black 0.03em 0.03em 0.03em;

            }
            .input{
            color: #ffffff;  padding: 20px; font-weight: 100; font-size: 35x;  text-shadow: black 0.03em 0.03em 0.03em;

            }



          </style>
    </head>

    <body style="background:#b3ccff;">

      <center>
      <div  style="position:relative; left:0px;top:150px;width:650px;" >
            <text class="sesion">Iniciar Sesión</text>
            <?php $form=ActiveForm::begin(['method' => 'post','class'=>'input','action' => ['inscripcion/iniciado'],]);?>
                  <input type="number" name="legajo" class=" input_personalizado active_input"  placeholder="legajo.."/><br><br>
                  <input type="password" name="clave" class=" input_personalizado active_input"  placeholder=" clave..."/><br><br>
                  <input type="submit" name="ingresar" value="ingresar"  class="boton_ingresar active_ingresar" /><br><br>
                  <?php
                    ActiveForm::end();
                  ?>
        </div>
          </center>
    </body>
</html>
