<?php
//lle arhivivo json
function leeArchivo(){
  $data_file = fopen('./data-1.json', 'r');
  $data = fread($data_file, filesize('./data-1.json'));//leer el archivo y guardar la inf en $data
  $data = json_decode($data, true); //arnmar la informacion en formato jsaon
  fclose($data_file);
  return ($data);
};




//con los que haya escogido el usario usando el formulario o no, encontrar los datos en el archivo json
function encontrarInmuebles($v_fciudad, $v_ftipo, $v_fprecio,$data){
  $listaDeInmuebles = Array(); //arreglo para guardar los tiposd de inmueble
  if($v_fciudad == "" and $v_ftipo=="" and $v_fprecio==""){ //este caso es para el manejo si se presiono el boton  mostrar todos los inmuebles
    foreach ($data as $index => $item) {
      array_push($listaDeInmuebles, $item); //Agregar los valores obtenidos al vector items
    }
  }else{ //Ebn caso de uso del formulario, y el boton de submit
     //manejo de ranfop de precios
    $menor = $v_fprecio[0];
    $mayor = $v_fprecio[1];

      if($v_fciudad == "" and $v_ftipo == ""){ //caso en que ciudad y tipo de inmueble no fue escogido
        foreach ($data as $items => $item) {
            $precio = precioNumero($item['Precio']);
        if ( $precio >= $menor and $precio <= $mayor){
            array_push($listaDeInmuebles,$item );
          }
        }
      }

      if($v_fciudad != "" and $v_ftipo == ""){
          foreach ($data as $index => $item) {
            $precio = precioNumero($item['Precio']);
            if ($v_fciudad == $item['Ciudad'] and $precio > $menor and $precio < $mayor){
              array_push($listaDeInmuebles,$item );
            }
        }
      }

      if($v_fciudad == "" and $v_ftipo != ""){
          foreach ($data as $index => $item) {
            $precio = precioNumero($item['Precio']);
            if ($v_ftipo == $item['Tipo'] and $precio > $menor and $precio < $mayor){
              array_push($listaDeInmuebles,$item );
            }
        }
      }

      if($v_fciudad != "" and $v_ftipo != ""){
          foreach ($data as $index => $item) {
            $precio = precioNumero($item['Precio']);
            if ($v_ftipo == $item['Tipo'] and $v_fciudad == $item['Ciudad'] and $precio > $menor and $precio < $mayor){
              array_push($listaDeInmuebles,$item );
            }
        }
      }


  }
  sort($listaDeInmuebles);
  echo json_encode($listaDeInmuebles);
};

//encuentraCiudad
function EncontrarCiudades($v_datosLeidos){
  $getCities = Array();
  foreach ($v_datosLeidos as $cities => $city) {
    if(in_array($city['Ciudad'], $getCities)){
      //Continuar
    }else{
      array_push($getCities, $city['Ciudad']);
    }
  }
  echo json_encode($getCities);
}



function precioNumero($itemPrecio){ //Convertir la cadena de caracteres en numero
  $precio = str_replace('$','',$itemPrecio); //Eliminar el símbolo Dolar
  $precio = str_replace(',','',$precio); //Eliminar la coma (separador de miles)
  return $precio; //Devolver el falor de tipo Numero
}

function EncontrarTiposInmuebles($v_datosLeidos){
  $getTipo = Array(); //arreglo para  guardar los valores de los tipos de inmueble.
  foreach ($v_datosLeidos as $tipos => $tipo) {
    if(in_array($tipo['Tipo'], $getTipo)){

    }else{
      array_push($getTipo, $tipo['Tipo']); //
    }
  }
  sort($getTipo);
  echo json_encode($getTipo); //Devolver el arreglo en tipo json
}


?>
