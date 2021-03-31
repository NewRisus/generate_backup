<?php if (!defined('BACKUP_DB')) exit('No se permite el acceso directo al script');

/**
 * Download :: Archivo para descargar el fichero
 *
 * @package New_Risus_Tools
 * @author Miguel92 
 * @copyright NewRisus 2021
 * @version v1.2.2 30-03-2021
 * @link https://newrisus.com
*/

if (empty($_GET["download"])) exit("No hay parámetro para la descarga.");

include __DIR__ . DIRECTORY_SEPARATOR . "script" . DIRECTORY_SEPARATOR . "mysqldump.php";
$tsMysql = new tsMysql();

# Obtenemos el archivo
$download = $tsMysql->download(0, str_replace(' ', '+', $_GET['download']));

# Ruta del archivo 
$backup_db = __DIR__ . DIRECTORY_SEPARATOR . "backup_db" . DIRECTORY_SEPARATOR;
if (!file_exists($backup_db . $download)) exit("Archivo no existente");

# Algunos encabezados que son justamente los que fuerzan la descarga
header("Content-Type: application/force-download");
header("Content-disposition: attachment; filename=$download");
header('Pragma: public');
# Leer el archivo y sacarlo al navegador
readfile($backup_db . $download);
