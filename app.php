<?php

/**
 * App :: Archivo con algunas configuraciones globales
 *
 * @package New_Risus_Tools
 * @author Miguel92 
 * @copyright NewRisus 2021
 * @version v1.2.3 16-05-2021
 * @link https://newrisus.com
*/

# 
define("BACKUP_DB", TRUE);

# Defino algunas variables
define('ROOT', __DIR__ . DIRECTORY_SEPARATOR);

date_default_timezone_set('America/Argentina/Buenos_Aires');
# Configuramos el idioma
setlocale(LC_TIME, 'spanish');

# Máximo de tiempo 5 Min.
set_time_limit(300);

# Creamos una ruta "url"
$url_base = "{$_SERVER["REQUEST_SCHEME"]}://{$_SERVER["HTTP_HOST"]}" . dirname($_SERVER["PHP_SELF"]);
$version = "v1.2.3";
$fecha = date('dmY');

$GLOBALS['SCRIPT'] = isset($_GET['script']) ? htmlentities($_GET['script']) : '';
$pagina = $GLOBALS['SCRIPT'];
$accion = isset($_GET['accion']) ? $_GET['accion'] : '';

define("Llave", base64_encode($version.$fecha));

# Hacemos que el titulo sea dinamico.
$title = isset($pagina) ? 'NR2: ' . ucfirst($pagina) . ' base de datos!' : 'New Risus: Tools';