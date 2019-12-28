


function validarAr(validarAr, lista){
  try {
    var validarAr = JSON.parse(validarAr)
    return validarAr
  } catch (e) {
    obtnError('','SyntaxError '+lista);
    }
}

//busqueda de inmuebles
function buscaInmueble(tipoBusqueda){
  if($('.colContenido > .item') != 0){
    $('.colContenido > .item').detach()
  }
  var filtro = obtFiltros(tipoBusqueda)
  $.ajax({
    url:'./buscador.php',
	//url:'./index_01.php',
    type: 'GET',
    data:{filtro},
    success:function(items, textStatus, errorThrown ){

      try {
        item = JSON.parse(items);
      } catch (e) {
        obtnError(500,'SyntaxError');
      }

      $.each(item, function(index, item){
        $('.colContenido').append(
          '<div class="col s12 item">'+
            '<div class="card itemMostrado">'+
              '<img src="./img/home.jpg">'+

                  '<div class="card-content">'+
                    '<p><b>Direccion: </b>'+item.Direccion+'</p>'+ //mostrarDireccion
                    '<p><b>Ciudad: </b>'+item.Ciudad+'</p>'+ //mostrar la  Ciudad
                    '<p><b>Teléfono: </b>'+item.Telefono+'</p>'+ //mostrar el  Teléfono
                    '<p><b>Código postal: </b>'+item.Codigo_Postal+'</p>'+ //mostrar el  Código Postal
                    '<p><b>Tipo: </b>'+item.Tipo+'</p>'+ //mostrar el  Tipo
                    '<p><b>Precio: </b><span class="precioTexto">'+item.Precio+'</span></p>'+ //mostrar el  Precio
                  '</div>'+

                '</div>'+
            '</div>'+
          '</div>'
        )
      })
    },
  }).done(function(){
    var totalItems = $('.colContenido > .item').length
    //$('.tituloContenido.card > h5').text("Resultados de la búsqueda: "+ totalItems + " items" )
	$('.tituloContenido.card > h5').text("Nro de Inmuebles Econtrados: "+ totalItems + " items" )
  }).fail(function( jqXHR, textStatus, errorThrown ){
      obtnError(jqXHR, textStatus)
  })
}

//Manejo de los filtros
function obtFiltros(tipoBusqueda){
  var rango = $('#rangoPrecio').val(), //precio
  rango = rango.split(";")

  if (tipoBusqueda == false){ //si no  se uso el formulario
    var encontrarCiudad = '',
        encontrarTipo = '',
        encontrarPrecio = ''
  }else{//si se uso el formulario para escoger tipo de vivienda
    var encontrarPrecio = rango,
        encontrarCiudad = $('#selectCiudad option:selected').val(),
        encontrarTipo = $('#selectTipo option:selected').val()
  }

    var filtro = {
      Precio:encontrarPrecio,
      Ciudad: encontrarCiudad,
      Tipo: encontrarTipo
    }

  return filtro;
}

//busca los tipos de inmuebles.
function encontrarTipo(){
  $.ajax({
    url:'./prg_buscaTipoInmuebles.php',
    type: 'GET',
    data:{},
    success:function(tipoInmueble){
      tipoInmueble = validarAr(tipoInmueble, 'Tipo')
      $.each(tipoInmueble, function( index, value ) {
        $('#selectTipo').append('<option value="'+value+'">'+value+'</option>')
      });
    },
  }).done(function(){
    $('select').material_select(); //Funcion que habilita el select
  })
}

//busca las c¿idades
function encontrarCiudad(){
  $.ajax({
    url:'./prg_buscaCiudades.php',
    type: 'GET',
    data:{},
    success:function(infCiudades){
      infCiudades = validarAr(infCiudades, 'Ciudad')
      $.each(infCiudades, function( index, value ) {
        $('#selectCiudad').append('<option value="'+value+'">'+value+'</option>')
      });
    }
  })
}




//si el usario da click  en el boton  mostrar todos
$('#mostrarTodos').on('click', function(){
buscaInmueble(false);
})

//si el usario da click  en el boton  buscar del formiulario
$('#formulario').on('submit', function(event){
event.preventDefault();
buscaInmueble(true);
})

//inicio

  encontrarCiudad();
  encontrarTipo();
