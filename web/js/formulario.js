

$("#enviarFormulario").click(function(){
  var res;
    if(confirm("¿Seguro de realizar la inscripción?")){
        $("#formInscripcion").find("input:disabled").prop('disabled',false);
        $("#formInscripcion").find("input:disabled").val('--');
        $("#formInscripcion").submit();
        res=true;
    }else{
        res=false;
    }
    //for(i;i<)
   return res;
});
/**Al presionar sobre el boton de cargar alumno se generan los inputs correspondientes
 *  (que luegon seran array al recibirlos) por post
 *  
*/
var primero = 0;
$("button[name='agregaAlumno']").click(function () {
    var confirmacion = confirm("¿Seguro desea agregarlo?. Una vez realizado no podra editar este alumno nuevamente");
    if (confirmacion) {
        var idDivision = $("select[name='alumno[seccion]']").val();
        var idNivel = $("select[name='alumno[nivel]']").val();
        var id = $("select[name='alumnos']").val();
        var nombre = $("input[name='alumno[nombre]']").val();
        var apellido = $("input[name='alumno[apellidos]']").val();
        var dni = $("input[name='alumno[dni]']").val();
        var sexo = $("select[name='alumno[sexo]']").val();
        var nivel = $("select[name='alumno[nivel]'] option:selected").text();
        var grado = $("select[name='alumno[grado]'] option:selected").text();
        var division = $("select[name='alumno[seccion]'] option:selected").text();
        var lugarNacimiento = $("input[name='alumno[lugarNacimiento]']").val();
        var fechaNacimiento = $("input[name='alumno[fechaNacimiento]']").val();
        var fechaIngreso = $("input[name='alumno[fechaIngreso]']").val();
        var fechaEgreso = $("input[name='alumno[fechaEgreso]']").val();
        var bautismo = $("select[name='alumno[bautismo]']").val();
        var lugarBautismo = $("input[name='alumno[lugarBautismo]']").val();
        var fechaBautismo = $("input[name='alumno[fechaBautismo]']").val();
        var diosecisBautismo = $("input[name='alumno[diosecisBautismo]']").val();
        var comunion = $("select[name='alumno[comunion]']").val();
        var lugarComunion = $("input[name='alumno[lugarComunion]']").val();
        var fechaComunion = $("input[name='alumno[fechaComunion]']").val();
        var diosecisComunion = $("input[name='alumno[diosecisComunion]']").val();
        var confirmacion = $("select[name='alumno[confirmacion]']").val();
        var lugarConfirmacion = $("input[name='alumno[lugarConfirmacion]']").val();
        var fechaConfirmacion = $("input[name='alumno[fechaConfirmacion]']").val();
        var diosecisConfirmacion = $("input[name='alumno[diosecisConfirmacion]']").val();
        var atributos = ['nivel_id','division_id', 'persona_id', 'nombre', 'apellido', 'dni', 'sexo', 'nivel', 'grado', 'division', 'lugarNacimiento', 'fechaNacimiento', 'fechaIngreso', 'fechaEgreso', 'bautismo', 'lugarBautismo', 'fechaBautismo', 'diosecisBautismo', 'comunion', 'lugarComunion', 'fechaComunion', 'diosecisComunion', 'confirmacion', 'lugarConfirmacion', 'fechaConfirmacion', 'diosecisConfirmacion'];
        var valores = [idNivel,idDivision, id, nombre, apellido, dni, sexo, nivel, grado, division, lugarNacimiento, fechaNacimiento, fechaIngreso, fechaEgreso, bautismo, lugarBautismo, fechaBautismo, diosecisBautismo, comunion, lugarComunion, fechaComunion, diosecisComunion, confirmacion, lugarConfirmacion, fechaConfirmacion, diosecisConfirmacion];
        var i;
        var pos;
        var size = Math.trunc($("input[name*='alumnosArray']").length / 26);


        verificarCamposVacios(valores)

        for (i = 0; i < 26; i++) {

            $("#cargaAlumnos").before("<input type='hidden' name='alumnosArray[" + size + "][" + atributos[i] + "]' value='" + valores[i] + "'>")

        }

        if ($("select[name='alumnos']").val() != "new") {
            $("select[name='alumnos']").find("option[value='" + id + "']").remove();
            $("select[name='alumnos']").val('');
        }
        datosAlumno("");
    }

})

/**
 * Esta funcion verifica si los valores dados son indefinidos en cuyo caso le 
 * asigna el valor -
 * @param {Array} valores
 */
function verificarCamposVacios(valores) {
    var j;
    for (j = 0; j < 26; j++) {
        if (typeof (valores[j]) == "undefined" || valores[j] == "") {
            valores[j] = "--";
        }
    }
    return valores;
}

/**
 * Esta función se encarga de traer las localidades 
 * cada vez que se cambia la provincia seleccionada (Respecto a la sección del responsable)
 * @param {String} baseYii 
 */
function traerLocalidades(baseYii) {
    $.ajax({
        type: 'POST',
        dataType: 'JSON',
        url: 'inscripcion/localidades',
        data: { 'idProvincia': +$("select[name='responsable[provincia]']").val() },
        success: function (response) {
            var array, elem;
            $('#cargaLocalidad').html('');
            $("select[name='responsable[localidad]']").html('');
            var l=0;
            for (elem in response) {
                if(l==0){
                   

                    $("select[name='responsable[localidad]']").append('<option selected='+"'selected'"+' value=' + response[elem].LocalidadKey + '>' + response[elem].Nombre + '</option>');
                    traerCP(baseYii)
                    //$("input[name='responsable[codigo_postal]']").val(response[elem].CodigoPostal);
            }else{
                $("input[name='responsable[codigo_postal]']").val(response[elem].CodigoPostal);

                $("select[name='responsable[localidad]']").append('<option value=' + response[elem].LocalidadKey + '>' + response[elem].Nombre + '</option>');
            }
            l=l+1;
            }
        }
        ,
        beforeSend: function () {
            $("#cargaLocalidad").html("<img src='" + baseYii + "/images/ajax-loader.gif' />Cargando,espere por favor...");
        }

    })
}

/**
 * Esta función se encarga de traer el codigo postal
 * cada vez que se cambia la localidad seleccionada (Respecto a la sección del responsable)
 * @param {String} baseYii 
 */
function traerCP(baseYii) {
    $.ajax({
        type: 'POST',
        dataType: 'JSON',
        url: 'inscripcion/traerlocalidad',
        data: { 'idLocalidad': +$("select[name='responsable[localidad]']").val() },
        success: function (response) {
            var array, elem;
            $("#cargaLocalidad").html('');
            for (elem in response) {
                $("input[name='responsable[codigo_postal]']").val(response[elem].CodigoPostal);
            }
        },
        beforeSend: function () {
            $("#cargaLocalidad").html("<img src='" + baseYii + "/images/ajax-loader.gif' />Cargando,espere por favor...");
        }
    })
}


////////////////////////////// Traer los datos del alumno seleccionado/////////////////////////////////////////

/**
 * Esta función se encarga de traer los datos del alumno seleccionado
 *  @param {String} baseYii
 */
function datosAlumno(baseYii) {

    if ($("select[name='alumnos']").val() == 'new') {//Caso en el que se ingresa un nuevo alumno (limpieza de datos alumno)
        $("#alumnos").show();
        $("input[name='alumno[nombre]']").val('');
        $("input[name='alumno[apellidos]']").val('');
        $("input[name='alumno[dni]']").val('');
        $("input[name='alumno[fechaIngreso]']").val('');
        $("input[name='alumno[fechaEgreso]']").val('');
        $("input[name='alumno[fechaBautismo]']").val('');
        $("input[name='alumno[fechaComunion]']").val('');
        $("input[name='alumno[fechaNacimiento]']").val('');
        $("input[name='alumno[fechaConfirmacion]']").val('');
        $("input[name='alumno[lugarNacimiento]']").val('');
    } else {
        if ($("select[name='alumnos']").val() == '') {
            $("[ id*=seleccionado]").hide();
        } else {
            var valor=$("select[name='alumnos']").val()
            $("[ id*=seleccionado]").hide();
            $("#seleccionado"+valor).show();
            //El alumno ya se encuentra cargado en la BD
            /*$.ajax({
                type: 'POST',
                dataType: 'JSON',
                url: 'inscripcion/traeralumnocompleto',
                data: { 'ODEO_alumnoKey': +$("select[name='alumnos']").val() },
                success: function (response) {//Traemos los datos y los volcamos en el formulario
                    var array, elem;
                    $("#cargaAlumnos").html("");
                    $("#alumnos").show();
                    cargaAlumnoAux(response);
                }
                , beforeSend: function () {
                    $("#cargaAlumnos").html("<img src='" + baseYii + "/images/ajax-loader.gif' />Cargando,espere por favor...");
                }
            })*/
        }
    }
}
/**
 * Esta es una funcion auxiliar que realiza la carga inicial de datos del alumno seleccionado
 * @param {JSON} arrayAlumno 
 */
function cargaAlumnoAux(arrayAlumno) {
    var sacramentos;
    for (elem in arrayAlumno) {
        var fechaNacimiento = new Date(arrayAlumno[elem].FechaNacimiento);
        var fechaIngreso = new Date(arrayAlumno[elem].FechaIngreso);
        //var fechaComunion=new Date(arrayAlumno[elem].FechaComunion);
        var options = { year: 'numeric', month: 'numeric', day: 'numeric' };
        var fechaEgreso = new Date(arrayAlumno[elem].FechaEgreso);
        var fechaBautismo = new Date(arrayAlumno[elem].FechaBautismo);
        var fechaConfirmacion = new Date(arrayAlumno[elem].FechaConfirmacion);
        $("input[name='alumno[fechaIngreso]']").val(fechaIngreso.toLocaleDateString("es-ES", options));
        $("input[name='alumno[dni]']").val(arrayAlumno[elem].NumeroDocumento);
        //$("input[name='alumno[fechaEgreso]']").val(arrayAlumno[elem].FechaEgreso);
        $("input[name='alumno[nombre]']").val(arrayAlumno[elem].Nombre);
        $("input[name='alumno[apellidos]']").val(arrayAlumno[elem].Apellido);
        $("select[name='alumno[nivel]']").val(arrayAlumno[elem].ODEO_NivelKey);
        $("select[name='alumno[nivel]'] option[value=" + arrayAlumno[elem].ODEO_NivelKey + "]").attr("selected", true);
        $("select[name='alumno[sexo]']").val(arrayAlumno[elem].Sexo);
        $("input[name='alumno[lugarNacimiento]']").val(arrayAlumno[elem].LugarNacimiento);
        $("input[name='alumno[fechaNacimiento]']").val(fechaNacimiento.toLocaleDateString("es-ES", options));
        nivelGradoDivision(arrayAlumno[elem].GradoKey, arrayAlumno[elem].ODEO_NivelKey, arrayAlumno[elem].DivisionKey);
        sacramentos = {
            "bautismo":
                { "valor": arrayAlumno[elem].Bautismo, "fecha": arrayAlumno[elem].FechaBautismo, "lugar": arrayAlumno[elem].LugarBautismo, "diosecis": arrayAlumno[elem].DiosecisBautismo }
            , "comunion": { "valor": arrayAlumno[elem].Comunion, "fecha": arrayAlumno[elem].FechaComunion, "lugar": arrayAlumno[elem].LugarComunion, "diosecis": arrayAlumno[elem].DiosecisComunion }
            , "confirmacion": { "valor": arrayAlumno[elem].Confirmacion, "fecha": arrayAlumno[elem].FechaConfirmacion, "lugar": arrayAlumno[elem].LugarConfirmacion, "diosecis": arrayAlumno[elem].DiosecisConfirmacion },
        };
       
    }
}
/**
 * Funcion auxiliar encargada de completar los select de nivel,grado,curso
 * @param {String} grado 
 * @param {String} nivel 
 */
function nivelGradoDivision(grado, nivel, division) {
    var elem, elemAux;

    $.ajax({
        type: 'GET',
        dataType: 'JSON',
        url: 'inscripcion/divisionasignada?grado=' + grado + '&nivel=' + nivel,
        success: function (response) {
            var divisiones = response.divisiones;
            var unaDivision, unGrado;
            var grados = response.grados;
            for (unaDivision in divisiones) {
                if (divisiones[unaDivision].ODEO_DivisionKey == division) {
                    $("select[name='alumno[seccion]']").append("<option value='" + divisiones[unaDivision].ODEO_DivisionKey + "' selected>" + divisiones[unaDivision].Nombre + "</option>");
                } else {
                    $("select[name='alumno[seccion]']").append("<option value='" + divisiones[unaDivision].ODEO_DivisionKey + "'>" + divisiones[unaDivision].Nombre + "</option>");
                }
            }
            for (unGrado in grados) {
                if (grados[unGrado].ODEO_GradoKey == grado) {
                    $("select[name='alumno[grado]']").append("<option value='" + grados[unGrado].ODEO_GradoKey + "' selected>" + grados[unGrado].DescripcionFacturacion + "</option>");
                } else {
                    $("select[name='alumno[grado]']").append("<option value='" + grados[unGrado].ODEO_GradoKey + "'>" + grados[unGrado].DescripcionFacturacion + "</option>");

                }
            }

        },
        error: function () {
            alert('Error en obtencion de nivel,grado y division');
        }

    });
}

////////////////////////////// Fin de traer los datos del alumno seleccionado/////////////////////////////////////////
/**
 * Dado algún sacramento verifica si se dispone de el , habilitando o deshabilitando según corresponda
 * @param {String} unSacramento 
 */
function deshabilitarSacramento(unSacramento,pos) {
    var sacramentoUpper = unSacramento.charAt(0).toUpperCase() + unSacramento.slice(1);
    if ($("select[name='alumnosArray["+pos+"][" + unSacramento + "]']").val() == "NO") {
        $("input[name='alumnosArray["+pos+"][lugar" + sacramentoUpper + "]']").val('');
        $("input[name='alumnosArray["+pos+"][fecha" + sacramentoUpper + "]']").val('');
        $("input[name='alumnosArray["+pos+"][diosecis" + sacramentoUpper + "]']").val('');
        $("input[name='alumnosArray["+pos+"][lugar" + sacramentoUpper + "]']").prop("disabled", true);
        $("input[name='alumnosArray["+pos+"][diosecis" + sacramentoUpper + "]']").prop("disabled", true);
        $("input[name='alumnosArray["+pos+"][fecha" + sacramentoUpper + "]']").prop("disabled", true);
      
    } else {
        $("input[name='alumnosArray["+pos+"][lugar" + sacramentoUpper + "]']").prop("disabled", false);
        $("input[name='alumnosArray["+pos+"][fecha" + sacramentoUpper + "]']").prop("disabled", false);
        $("input[name='alumnosArray["+pos+"][diosecis" + sacramentoUpper + "]']").prop("disabled", false);
       // $("input[name='alumnosArray["+pos+"][fecha" + sacramentoUpper + "]']").removeAttr("er");
    }
}

/**
 * Al hacer click en algun nivel autocompleta los grados que pertenecen al mismo
 */

function traerGrado(baseYii,pos) {
    $.ajax({
        type: 'POST',
        dataType: 'JSON',
        url: 'inscripcion/traergrado',
        data: { 'ODEO_nivelKey': +$("select[name='alumnosArray["+pos+"][nivel]']").val() },
        success: function (response) {
            $("#cargaAsignaAlumno").html('');
            $("select[name='alumnosArray["+pos+"][grado]']").html('');
            $("select[name='alumnosArray["+pos+"][seccion]']").html('');
            var i=0;
            for (elem in response) {
               if(i==0){
                $("select[name='alumnosArray["+pos+"][grado]']").append('<option selected='+"'selected'"+ 'value=' + response[elem].ODEO_GradoKey + '>' + response[elem].DescripcionFacturacion + '</option>');

               }else{
                    $("select[name='alumnosArray["+pos+"][grado]']").append('<option value=' + response[elem].ODEO_GradoKey + '>' + response[elem].DescripcionFacturacion + '</option>');
                }
                i=i+1;
                traerDivision(baseYii,pos);
            }
        },
        beforeSend: function () {
            $("#cargaAsignaAlumno").html("<img src='" + baseYii + "/images/ajax-loader.gif' />Cargando,espere por favor...");
        }
    });
}
/**
 * Al hacer click en algun grado autocompleta las divisiones que pertenecen al mismo
 */
function traerDivision(baseYii,pos) {
    $.ajax({
        type: 'POST',
        dataType: 'JSON',
        url: 'inscripcion/traerdivision',
        data: { 'ODEO_gradoKey': +$("select[name='alumnosArray["+pos+"]"+"[grado]']").val() },
        success: function (response) {
            $("select[name='alumnosArray["+pos+"][seccion]']").html('');
            $("#cargaAsignaAlumno").html('');
            for (elem in response) {

                $("select[name='alumnosArray["+pos+"][seccion]']").append('<option value=' + response[elem].ODEO_DivisionKey + '>' + response[elem].Nombre + '</option>');
            }
        },
        beforeSend: function () {
            $("#cargaAsignaAlumno").html("<img src='" + baseYii + "/images/ajax-loader.gif' />Cargando,espere por favor...");
        }
    })
}
