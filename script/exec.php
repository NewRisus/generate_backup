<?php if (!defined('BACKUP_DB')) exit('No se permite el acceso directo al script');

/**
 * Exec :: Archivo para ejecutar las funciones y acciones
 *
 * @package New_Risus_Tools
 * @author Miguel92 
 * @copyright NewRisus 2021
 * @version v1.2.2 31-03-2021
 * @link https://newrisus.com
*/

include __DIR__ . DIRECTORY_SEPARATOR . "mysqldump.php";
$tsMysql = new tsMysql();

$accion = isset($_GET["m"]) ? $_GET["m"] : (isset($_GET['accion']) ? $_GET['accion'] : '');
$check = isset($_GET["act"]) ? $_GET["act"] : '';

if($accion === "ejecutar") {
	
	$db = [
		'hostname' => $tsMysql->Secure($_POST["hostname"]),
		'username' => $tsMysql->Secure($_POST["username"]),
		'password' => $tsMysql->Secure($_POST["password"]),
		'database' => $tsMysql->Secure($_POST["database"]),
		'newname'  => (isset($_POST["newname"]) ? $tsMysql->Secure($_POST["newname"]) : $tsMysql->Secure($_POST["database"])),
		'extension' => isset($_POST["archive"]) ? intval($_POST["archive"]) : 0,
		'datetime' => time()
	];
		
	if($_POST["type_action"] === "create_backup") {
		# Si no existe la carpeta "backup_db", la crearemos
		$folder = dirname(__DIR__) . DIRECTORY_SEPARATOR . "backup_db";
		if(!is_dir($folder)):
			# Creamos la carpeta y asignamos los permisos
			mkdir($folder, 0777, true);
			# Forzamos los permisos
			chmod($folder, 0777);
		endif;
		# Creamos el nombre del archivo
		$file_sql = $folder . DIRECTORY_SEPARATOR . "{$db['newname']}@{$db['datetime']}";
		# Creamos el backup
		$dbase = (empty($_POST['base']['todos'])) ? implode(" ", $_POST['base']) : '';

		$d = $tsMysql->mysqldump($db, $file_sql, $dbase);
		system($d, $message);
		$msg = ($message == 0) ? "Se creó correctamente la copia <b>{$db['newname']}@{$db['datetime']}</b> de la base <u>{$db['database']}</u>" : ($message == 1 ? "Se ha producido un error al exportar <b>{$db['database']}</b> a {$file_sql}" : "Se ha producido un error de exportación, compruebe la siguiente información: <br/><br/><table><tr><td>Nombre de la base de datos:</td><td><b>{$db['database']}</b></td></tr><tr><td>Nombre de usuario MySQL:</td><td><b>{$db['username']}</b></td></tr><tr><td>Contraseña MySQL:</td><td><b>NOTSHOWN</b></td></tr><tr><td>Nombre de host MySQL:</td><td><b>{$db['hostname']}</b></td></tr></table>");

		$text = ($message == 0) ? "success" : ($message == 1 ? "danger" : "warning");

		echo "<div class=\"text-center py-4 text-{$text}\">{$msg}</div>";
		if($message == 0) {
			$url_base = "{$_SERVER["REQUEST_SCHEME"]}://{$_SERVER["HTTP_HOST"]}" . dirname($_SERVER['REDIRECT_URL']);
			echo "<div class=\"text-center small fts-italic text-muted\">Se redireccionará en 5s...</div>";
			header("Refresh: 5; url={$url_base}");
		}
		
	}
}

# Con esto verificamos que no tenga espacios, ni simbolos
if($check === "check") {
	echo $tsMysql->checkName($_POST['text']);
}