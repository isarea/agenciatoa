<?php 
	require 'vendor/autoload.php';

	class TOAException extends Exception {
	  public function __construct($message, $code=0, Exception $previous = null) {
	   	parent::__construct($message,$code,$previous);
	  }

	  public function __toString() {
	  	return __CLASS__. ":[{$this->code}]:{$this->message}\n";
	  }
	}

  class TOAClient {

	  private function doRequest($xmlReq) {
			$servic = 'http://xml.development.hotetec.com/publisher/xmlservice.srv';
			$response_xml = \Httpful\Request::post($servic)
			  ->body($xmlReq)
			  ->sendsXml()
			  ->send();

			return new SimpleXMLElement($response_xml);
	  }

	  public function sesionAbrir() {
			include("./lib/config.php");

			$template_loader = new Twig_Loader_Filesystem('lib/xmlreqs');
			$twig = new Twig_Environment($template_loader);

			$request = $twig->render('sesionabrir.xml', array(
			  'codage' => $codage, 
			  'idtusu' => $idtusu,
			  'pasusu' => $pasusu
			));

			$result = $this->doRequest($request);
			if (property_exists($result, "coderr")) {
			  throw new TOAException($result->txterr, 1);
			} else {
			  return $result->ideses;
			}
	  }

	  public function disponibilidadHotel($ideses, $fecini, $fecfin, $codzge, $numuni=1, $numadl=1, $numnin=0) {
			$template_loader = new Twig_Loader_Filesystem('lib/xmlreqs');
			$twig = new Twig_Environment($template_loader);

			$request = $twig->render('disponibilidadhotel.xml', array(
			  'ideses' => $ideses, 
			  'fecini' => $fecini,
			  'fecfin' => $fecfin,
			  'codzge' => $codzge,
			  'numuni' => $numuni,
			  'numadl' => $numadl,
			  'numnin' => $numnin,
			));

			$result = $this->doRequest($request);
			if (property_exists($result, "coderr")) {
			  throw new TOAException($result->txterr, 2);
			} else {
			  return $result;
			}
	  }

	  public function disponibilidadDestino($ideses, $tipzge, $zgesup) {
			$template_loader = new Twig_Loader_Filesystem('lib/xmlreqs');
			$twig = new Twig_Environment($template_loader);

			$request = $twig->render('disponibilidaddestino.xml', array(
			  'ideses' => $ideses, 
			  'tipzge' => $tipzge,
			  'zgesup' => $zgesup
			));

			$result = $this->doRequest($request);
			if (property_exists($result, "coderr")) {
			  throw new TOAException($result->txterr, 2);
			} else {
			  return $result;
			}
	  }

	  public function informacionServicio($ideses, $codser) {
			$template_loader = new Twig_Loader_Filesystem('lib/xmlreqs');
			$twig = new Twig_Environment($template_loader);

			$request = $twig->render('informacionServicio.xml', array(
			  'ideses' => $ideses, 
			  'codser' => $codser
			));

			$result = $this->doRequest($request);
			if (property_exists($result, "coderr")) {
			  throw new TOAException($result->txterr, 2);
			} else {
			  return $result;
			}
	  }

  }
?>