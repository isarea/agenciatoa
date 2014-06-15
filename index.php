<?php

  require 'vendor/autoload.php';
  include("./lib/toaclient.php");

  $toaclient = new TOAClient();
  $ideses = $toaclient->sesionAbrir();

  // Sólo regiones en Valencia
  $destinos = $toaclient->disponibilidadDestino($ideses, "SRG", "ESVAL")
    ->xpath("/DisponibilidadDestinoRespuesta/infzge");

  $template_loader = new Twig_Loader_Filesystem('public');
  $twig = new Twig_Environment($template_loader);

  $html = $twig->render('landing.html', array('destinos' => $destinos));

  echo $html;
  exit;
?>