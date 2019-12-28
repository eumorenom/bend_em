<?php

  require('./prg_lib.php'); //Libreria requerida para el funcionamiento.
  
  $v_datosLeidos = leeArchivo(); //Lee los datos
  
  EncontrarCiudades($v_datosLeidos) //Ejecuta y obtiene la ciudad
 ?>
