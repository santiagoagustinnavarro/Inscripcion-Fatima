$("#w0").submit(function(){
    var clave=$("#mysqlusuario-usuario_clave").val();
    var clave2=$("#usuario_clave2").val();
    var retorno;
    retorno=true;
    if(clave!=clave2){
        $("#difiere").show();
      $("#difiere").html("<span class='alert alert-danger col-md-3' >Las claves no coinciden</div>");
      $("#difiere").hide(1500);
       retorno=false;
    }
    return retorno;
})
