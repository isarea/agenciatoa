<?php

  session_start();
  
  require 'vendor/autoload.php';
  include("./lib/toaclient.php");

  $toaclient = new TOAClient();
  $ideses = $_SESSION['ideses'];
  $codser = $_GET['codser'];

  $info = $toaclient->informacionServicio($ideses, $codser);
  //var_dump($info);
  $template_loader = new Twig_Loader_Filesystem('public');
  $twig = new Twig_Environment($template_loader);

  $html = $twig->render('fichahotel.html', array(
    "info" => $info,
  ));

  echo $html;
  exit;
?>