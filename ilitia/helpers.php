<?php

# FUNCIONES HELPERS
# AUTOR: GIANFRANCO GIORDANO
# FECHA: 26 DICIEMBRE 2016

class Helpers extends Sesiones {


#==============================================================================
#					Redirecciona al url indicado
#==============================================================================

	function redirect( $url, $modo = "php" ) {

		if($modo == "php") {

			header("location:".$url);

		}
		elseif($modo == "js"){

			echo '<script>window.location.href="'.$url.'";</script>';

		}
	}

	function encrypt( $string ) {

		$key = 'Som0SCl1ck2019';
	   	$result = '';
	   	for($i=0; $i<strlen($string); $i++) {

	     $char = substr($string, $i, 1);
	     $keychar = substr($key, ($i % strlen($key))-1, 1);
	     $char = chr(ord($char)+ord($keychar));
	     $result.=$char;

	   }
	   return base64_encode($result);
	}

	function decrypt( $string ) {

		$key = 'Som0SCl1ck2019';
		$result = '';
		$string = base64_decode($string);
		for($i=0; $i<strlen($string); $i++) {
		  $char = substr($string, $i, 1);
		  $keychar = substr($key, ($i % strlen($key))-1, 1);
		  $char = chr(ord($char)-ord($keychar));
		  $result.=$char;
		}
		return $result;
	}

	function getIp() {

		$ip = '';
		if (!empty($_SERVER['HTTP_CLIENT_IP'])) {

		  $ip = $_SERVER['HTTP_CLIENT_IP'];
		  
	    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {

		  $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
		  
	    } else {

	      $i=$_SERVER['REMOTE_ADDR'];
		}
		
	    return $ip;
	}

	function hora( $format = "",$timezone = "" ) {

		date_default_timezone_set(($timezone==""?TIME_ZONE_DEFAULT:$timezone));
		if ( $format == "" ) { $format=HORA_DEFAULT; }

		switch (strtolower($format)) {
			case 'mysql':
				$format = "Y-m-d H:i:s";
				break;
			case '12h':
				$format = "h:i:sa";
				break;
			case '24h':
				$format = "H:i:s";
				break;
			case 'min':
				$format = "H:i";
				break;
			case 'sec':
				$format = "H:i:s";
				break;
			default:
				$format = $format;
				break;
		}
		return date( $format );
	}

}

