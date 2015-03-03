<?php

  require 'vendor/autoload.php';
  include("./lib/toaclient.php");

  $toaclient = new TOAClient();
  $ideses = $toaclient->sesionAbrir();

  $fecini = date_create($toaclient->check_plain($_POST['fecini']))->format('d/m/Y');
  $fecfin = date_create($toaclient->check_plain($_POST['fecfin']))->format('d/m/Y');

  $disponibilidad = $toaclient->disponibilidadHotel($ideses, 
    $fecini,
    $fecfin, // Fechas
    $toaclient->check_plain($_POST['codzge']), // Destino
    $toaclient->check_plain($_POST['numuni']),
    $toaclient->check_plain($_POST['numadl']),
    $toaclient->check_plain($_POST['numnin']) // Pasajeros
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