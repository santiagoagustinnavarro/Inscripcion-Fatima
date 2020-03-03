<?php

  
  // agregue usuarios a modo de prueba
   use yii\helpers\Html;
    use yii\helpers\ArrayHelper;
    use yii\bootstrap\ActiveForm;
    use yii\jui\DatePicker;
    use yii\bootstrap\Modal;
    use yii\helpers\Url;
    

  $session[]= array("legajo"=> "admin","clave"=> 1234);

  $session[]= array("legajo"=> "1884","clave"=> "1234");





  $logico_legajo= 0;
  $logico_clave= 0;


  for($i=0;$i<count($session);$i++){

	   if($session[$i]['legajo']==$_POST['legajo']){
	      $logico_legajo= 1;
  	 }

  	 if($session[$i]['clave']==$_POST['clave']){
  	   $logico_clave= 1;
    	}
  }



    if( $logico_legajo==1 and $logico_clave==1 ) {
     
       $_SESSION['iniciado']=1;
     
    $this->redirect(Url::base().'/inscripcion?id=1884');

    }else{
      echo "no holis";
      $this->redirect(Url::base().'/inscripcion/session');
    
    }

?>
