<?php

/**
 * App :: Archivo con algunas configuraciones globales
 *
 * @package New_Risus_Tools
 * @author Miguel92 
 * @copyright NewRisus 2021
 * @version v1.1.0 23-02-2021
 * @link https://newrisus.com
*/


date_default_timezone_set('America/Argentina/Buenos_Aires');
setlocale(LC_TIME, 'spanish');

# Máximo de tiempo 5 Min.
set_time_limit(300);

# Creamos una ruta "url"
$url_base = "{$_SERVER["REQUEST_SCHEME"]}://{$_SERVER["HTTP_HOST"]}" . dirname($_SERVER["PHP_SELF"]);
$version = "v1.1.0";
# Definimos la ruta de "CrearBackup"
define('ROOT', __DIR__ . DIRECTORY_SEPARATOR);

# Definimos la carpeta donde se guardan los backups
define('FOLDER', __DIR__ . DIRECTORY_SEPARATOR . "back-up-sql");

# Este es para el script normal
define('TS_HEADER', TRUE);

# Este es para New Risus 2
define('NR__ACCESS', TRUE);

# Asignamos la ulr creada
define('TS_URL', $url_base);

# Crearemos la carpeta en caso que no exista
if(!is_dir(FOLDER)) {
	mkdir(FOLDER, 0777, true);
} else {
	chmod(FOLDER, 0777);
}

# Incluimos el archivo para el control de los backup
include __DIR__ . "/generator-backup.php";
$tsDBackup = new BackUpDB();

# Variable para el manejo de algunas acciones 
$pagina = isset($_GET['accion']) ? htmlentities($_GET['accion']) : 'home';
$action = isset($_GET['act']) ? htmlentities($_GET['act']) : '';

if(file_exists(dirname(__DIR__) . "/config.inc.php")) {
	include dirname(__DIR__) . "/config.inc.php";
	$msg_imp = "Verifica que tus datos sean correctos.";
} else $msg_imp = "Ingresa los datos para conectar con tu base de datos, para poder generar el backup correspondiente.";

switch ($action) {
	# Crea backup
	case 'create':
		foreach ($_POST as $key => $value) {
		   if($key == 'save') continue;
		   $db[$key] = $_POST[$key];
		}
		echo $tsDBackup->CreateBackup($db, $url_base);
	break;
	# Restaura backup
	case 'restore':
		if(file_exists(dirname(__DIR__) . "/config.inc.php")) {
			include dirname(__DIR__) . "/config.inc.php";
		} else {
			include dirname(__DIR__) . "/lib/config.inc.php";
		}
		echo $tsDBackup->RestoreBackup($db);
	break;
	# Elimina backup
	case 'delete':
		echo $tsDBackup->DeleteBackup();
	break;
	# Comprobando nuevo nombre
	case 'check':
		echo $tsDBackup->checkName();
	break;
}

# Hacemos que el titulo sea dinamico.
$title = isset($_GET['accion']) ? 'NR2: ' . ucfirst($_GET['accion']) . ' base de datos!' : 'New Risus: Tools';