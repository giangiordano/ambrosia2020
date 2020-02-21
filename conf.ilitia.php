<?php 

# ARCHIVO DE CONFIGURACION DE ILITIA V1.0
# AUTOR: GIANFRANCO GIORDANO
# FECHA: 25 DICIEMBRE 2016

#==============================================================================
#						MOSTAR ERRORES PHP ( 0 => NO, 1 => SI )
#==============================================================================

ini_set("display_errors", 1);

#==============================================================================
#						USAR PROTOCOLO HTTPS O HTTP
#==============================================================================

define('FORCE_PROTOCOL', false);
define('PROTOCOL',"https");

#==============================================================================
#								MYSQL CONFIG
#==============================================================================

define('MySQL_U', 'ggiordano');
define('MySQL_P', 'g576huh6');
define('MySQL_S', 'localhost');
define('MySQL_DB', 'ambrosia_2019');

#==============================================================================
#								MULTI-IDIOMAS
#==============================================================================

define('USE_LANG', false);
define('LANG','es');

#==============================================================================
#								CONFIGURACION DEL SITIO
#==============================================================================

define('URL',PROTOCOL.'://localhost/ambrosia/');
define('NEED_LOGIN', true);

#==============================================================================
#								CONFIGURACION DEL PATH
#==============================================================================

define('MODULOS', 'modulos/');
define('VISTAS', 'vistas/');
define('MODALES', 'vistas/modales/');
define('LOGS', 'ilitia/logs');
define('PLUGINS', 'plugins/');

#==============================================================================
#								SEGURIDAD
#==============================================================================

define('SECURITY_SALT','SOm@sC0l0m6e1@'); 

#==============================================================================
#								OTRAS CONFIGURACIONES
#==============================================================================

define('HORA_DEFAULT','12h');
define('TIME_ZONE_DEFAULT','America/Bogota');
define('EDITABLE',true);
define('FULLROWS',true);
define('DEFAULT_LIMIT_PAGINATION',30);

#==============================================================================
#								LOGS
#==============================================================================

define('MYSQL_LOG', LOGS.'mysql.log');
define('ERROR_LOG', LOGS.'error.log');
define('WARNING_LOG', LOGS.'warning.log');
define('CORE_LOG', LOGS.'core.log');
define('PLUGIN_LOG', LOGS.'plugin.log');

#==============================================================================
#								ARCHIVOS DEFINIDOS
#==============================================================================

define('LOGIN', MODULOS.'login.php');   //Direccion del formulario de login.
define('ACTUALIZADO',"?actualizado"); //esta constante es el $this->okRedir por defecto al actualizar datos.
define('INSERTADO',"?insertado");
define('REGISTRO',"register.php");
define('ACTUALIZADO_MSG',"Se ha actualizado la informacion correctamente");
define('INSERTADO_MSG',"Se ha guardado la informacion correctamente");

#==============================================================================
#								ARCHIVOS IMPORTANTES
#==============================================================================

define('INDEX_MODULO', MODULOS.'inicio.php');
define('ESTRUCTURA',VISTAS.'estructura/'.'_estructura.php');

#==============================================================================
#							PROTOCOLO A USAR HTTPS / HTTP
#==============================================================================

if( FORCE_PROTOCOL ) {

    if(PROTOCOL == "https" && !((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || $_SERVER['SERVER_PORT'] == 443)){

		header("location:".URL);
	}
    elseif(PROTOCOL == "http" && ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || $_SERVER['SERVER_PORT'] == 443)){

		header("location:".URL);
	}
}

#==============================================================================
#							CLASES Y FUNCIONES DE ILITIA V1.0
#==============================================================================

date_default_timezone_set(TIME_ZONE_DEFAULT);

include_once('ilitia/nucleo.php');
include_once('ilitia/mysql.php');
include_once('ilitia/sesiones.php');
include_once('ilitia/helpers.php');
include_once('ilitia/_init.php');

