<?php

  require 'vendor/autoload.php';
  include("./lib/toaclient.php");

  $toaclient = new TOAClient();
  $ideses = $toaclient->check_plain($_GET['ideses']);
  $codser = $toaclient->check_plain($_GET['codser']);

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