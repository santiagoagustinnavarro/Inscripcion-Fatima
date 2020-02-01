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
            for (elem in response) {
                $("input[name='responsable[codigo_postal]']").val(response[elem].CodigoPostal);

                $("select[name='responsable[localidad]']").append('<option value=' + response[elem].LocalidadKey + '>' + response[elem].Nombre + '</option>');
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
            $("#alumnos").hide();
        } else {
            //El alumno ya se encuentra cargado en la BD
            $.ajax({
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
            })
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
        cargaSacramentos(sacramentos);
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
/**
 *  Esta función se encarga de la carga inicial de sacramentos del alumno al seleccionarlo 
 * @param {Array} datosSacramento 
 */
function cargaSacramentos(datosSacramento) {
    $("select[name='alumno[bautismo]']").val(datosSacramento["bautismo"]["valor"]);
    $("select[name='alumno[comunion]']").val(datosSacramento["comunion"]["valor"]);
    $("select[name='alumno[confirmacion]']").val(datosSacramento["confirmacion"]["valor"]);
    $("input[name='alumno[diosecisBautismo]']").val(datosSacramento['bautismo']['diosecis']);
    $("input[name='alumno[diosecisComunion]']").val(datosSacramento['comunion']['diosecis']);
    $("input[name='alumno[diosecisConfirmacion]']").val(datosSacramento['confirmacion']['diosecis']);
    $("input[name='alumno[lugarBautismo]']").val(datosSacramento['bautismo']['lugar']);
    $("input[name='alumno[lugarComunion]']").val(datosSacramento['comunion']['lugar']);
    $("input[name='alumno[lugarConfirmacion]']").val(datosSacramento['confirmacion']['lugar']);
    $("input[name='alumno[fechaBautismo]']").val(datosSacramento['bautismo']['fecha']);
    $("input[name='alumno[fechaComunion]']").val(datosSacramento['comunion']['fecha']);
    $("input[name='alumno[fechaConfirmacion]']").val(datosSacramento['confirmacion']['fecha']);
    deshabilitarSacramento("bautismo")
    deshabilitarSacramento("comunion");
    deshabilitarSacramento("confirmacion");

}
////////////////////////////// Fin de traer los datos del alumno seleccionado/////////////////////////////////////////
/**
 * Dado algún sacramento verifica si se dispone de el , habilitando o deshabilitando según corresponda
 * @param {String} unSacramento 
 */
function deshabilitarSacramento(unSacramento) {
    var sacramentoUpper = unSacramento.charAt(0).toUpperCase() + unSacramento.slice(1);
    if ($("select[name='alumno[" + unSacramento + "]']").val() == "NO") {
        $("input[name='alumno[lugar" + sacramentoUpper + "]']").val('');
        $("input[name='alumno[fecha" + sacramentoUpper + "]']").val('');
        $("input[name='alumno[diosecis" + sacramentoUpper + "]']").val('');
        $("input[name='alumno[lugar" + sacramentoUpper + "]']").prop("disabled", true);
        $("input[name='alumno[diosecis" + sacramentoUpper + "]']").prop("disabled", true);
        $("input[name='alumno[fecha" + sacramentoUpper + "]']").prop("disabled", true);
    } else {
        $("input[name='alumno[lugar" + sacramentoUpper + "]']").prop("disabled", false);
        $("input[name='alumno[fecha" + sacramentoUpper + "]']").prop("disabled", false);
        $("input[name='alumno[diosecis" + sacramentoUpper + "]']").prop("disabled", false);
    }
}

/**
 * Al hacer click en algun nivel autocompleta los grados que pertenecen al mismo
 */

function traerGrado(baseYii) {
    $.ajax({
        type: 'POST',
        dataType: 'JSON',
        url: 'inscripcion/traergrado',
        data: { 'ODEO_nivelKey': +$("select[name='alumno[nivel]']").val() },
        success: function (response) {
            $("#cargaAsignaAlumno").html('');
            $("select[name='alumno[grado]']").html('');
            $("select[name='alumno[seccion]']").html('');
            for (elem in response) {
                $("select[name='alumno[grado]']").append('<option value=' + response[elem].ODEO_GradoKey + '>' + response[elem].DescripcionFacturacion + '</option>');
            }
        },
        beforeSend:$("#cargaAsignaAlumno").html("<img src='" + baseYii + "/images/ajax-loader.gif' />Cargando,espere por favor...")
    });
}
/**
 * Al hacer click en algun grado autocompleta las divisiones que pertenecen al mismo
 */
function traerDivision(baseYii) {
    $.ajax({
        type: 'POST',
        dataType: 'JSON',
        url: 'inscripcion/traerdivision',
        data: { 'ODEO_gradoKey': +$("select[name='alumno[grado]']").val() },
        success: function (response) {
            $("select[name='alumno[seccion]']").html('');
            for (elem in response) {

                $("select[name='alumno[seccion]']").append('<option value=' + response[elem].ODEO_DivisionKey + '>' + response[elem].Nombre + '</option>');
            }
        },
        beforeSend:$("#cargaAsignaAlumno").html("<img src='" + baseYii + "/images/ajax-loader.gif' />Cargando,espere por favor...")
    })
}