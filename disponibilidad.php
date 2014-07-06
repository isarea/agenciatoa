<?php

  require 'vendor/autoload.php';
  include("./lib/toaclient.php");

  $toaclient = new TOAClient();
  $ideses = $toaclient->sesionAbrir();

  $fecini = date_create($_POST['fecini'])->format('d/m/Y');
  $fecfin = date_create($_POST['fecfin'])->format('d/m/Y');

  $disponibilidad = $toaclient->disponibilidadHotel($ideses, 
    $fecini, $fecfin, // Fechas
    $_POST['codzge'], // Destino
    $_POST['numuni'], $_POST['numadl'], $_POST['numnin'] // Pasajeros
  );

  $hoteles = array();
  $habitaciones = array();
  $fechas = array (
    "fecini" => $fecini,
    "fecfin" => $fecfin
  );

  foreach ($disponibilidad->infhot as $elem) {
    $info = $toaclient->informacionServicio($disponibilidad->ideses, $elem->codser);
    
    $hotel = array();
    $hotel["disp"] = $elem;
    $hotel["info"] = $info;
    $hotel["img"] = $info->xpath("/InformacionServicioRespuesta/servic/desser[@id='2']/descdo/urlimg")[0];
    $hotel["habs"] = $elem->infhab;
    array_push($hoteles, $hotel);
  }

  $template_loader = new Twig_Loader_Filesystem('public');
  $twig = new Twig_Environment($template_loader);

  $html = $twig->render('disponibilidad.html', array(
    "hoteles" => $hoteles,
    "fechas" => array ("fecini" => $fecini, "fecfin" => $fecfin),
    "sesion" => urlencode($ideses)
  ));

  echo $html;
  exit;
?>