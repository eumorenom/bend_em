<?php

  require('./prg_lib.php');
 
  $v_fciudad = $_GET['filtro']['Ciudad'];
  $v_ftipo = $_GET['filtro']['Tipo'];
  $v_fprecio =  $_GET['filtro']['Precio'];
  $v_datosLeidos = leeArchivo(); //Leer los datos json

  encontrarInmuebles($v_fciudad, $v_ftipo, $v_fprecio,$v_datosLeidos);
 ?>
