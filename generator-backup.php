<?php 

/**
 * Create backup database
 *
 * PHP version 7.x
 *
 * @package    NewRisus2
 * @author     newrisus.com <joel92 [at] live.com>
 * @copyright  2021 Team New Risus
 * @version    v1.2
 * @link       https://newrisus.com
 * @since      generator-backup.php 1.2
 * @date       22-02-2021
 * @purpose:   Crear copia de seguridad de la base de datos y usar las copias
 *
*/

class BackUpDB {

   public function secure($var) {
      $var = htmlspecialchars($var, ENT_NOQUOTES, 'UTF-8');
      return $var;
   }

   public function checkName() {
      $string = htmlspecialchars(trim($_POST['text']));
      if (!preg_match('/^([A-Za-z0-9_]+)$/', $string)) {
         return '0: Solo letras y números, sin espacios.';
      }
      return '1: Este paso es opcional, y es ponerle al backup.';
   }

   # Se generá nuevo formato para fecha actual es: "25 Ene.", para más "25 Ene., 2020"
   function generateDate($date, $year = false, $short = false) {
      if(!empty($date)) {
         # Si es de este año no mostramos el "año", pero si es del año pasado si mostramos el "año"
         $y = (strftime('%Y', $date) === date('Y')) ? '' : strftime(', %Y', $date);
         # Concatenamos el año
         $dc = ($short) ? "%m, %b %y" : "%d.%m.%Y %T %p";
         $date = ucfirst(strftime(($year) ? $dc : "%B %d" . $y, $date));
      }
      return $date;
   }
   # Función para ejecutar el comando
   public function msqldump($host, $user, $pass, $base, $action, $file) {
      $act = ($action == 'backup') ? '>' : '<';
      $dump = ($action == 'backup') ? 'mysqldump --opt' : 'mysql';
      return "{$dump} --host={$host} --user={$user} --password={$pass} {$base} {$act} {$file}";
   }

	# Función para crear backup
   public function CreateBackup($db, $url_base) {
   	# Datos de database
   	$base = $this->secure($db['database']);
   	$user = $this->secure($db['username']);
   	$pass = $this->secure($db['password']);
      $host = $this->secure($db['hostname']);
   	$newname = $this->secure($db['newname']);
   	
   	# Creamos dato para el archivo backup
   	$fecha = time();
   	$file = (empty($newname)) ? "{$base}" : "{$newname}" . "-{$fecha}.sql";
   	$SQL = FOLDER . DIRECTORY_SEPARATOR . "{$file}";
   	# Comando para ser ejecutado
   	$d = $this->msqldump($host, $user, $pass, $base, 'backup', $SQL);
   	# Usamos system, por que exec no lo hace!
   	system($d, $salida);
   	# Mostramos el mensaje dependiendo de la salida que tenga
   	if($salida == 0) return "1: La base de datos <b>{$base}</b> se ha almacenado correctamente en <b>{$SQL}</b>";
		elseif($salida == 1) return "0: Se ha producido un error al exportar <b>{$base}</b> a {$file}";
		elseif($salida == 2) return "0: Se ha producido un error de exportación, compruebe la siguiente información: <br/><br/><table><tr><td>Nombre de la base de datos:</td><td><b>{$base}</b></td></tr><tr><td>Nombre de usuario MySQL:</td><td><b>{$user}</b></td></tr><tr><td>Contraseña MySQL:</td><td><b>NOTSHOWN</b></td></tr><tr><td>Nombre de host MySQL:</td><td><b>{$host}</b></td></tr></table>";
   }
   # Obtenemo peso del archivo
   public function size($bytes, $decimals = 2) {
      $sz = 'BKMGTP';
      $factor = floor((strlen($bytes) - 1) / 3);
      return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) .' '. @$sz[$factor];
   }
   # Función para obtener todos los backups
   public function getBackup() {
   	$directorio = opendir(FOLDER . DIRECTORY_SEPARATOR);
   	$datos = [];
   	while ($archivo = readdir($directorio)) { 
  			if(($archivo != '.')&&($archivo != '..')){
  				$file = explode('-', $archivo);
  				$id = explode('.', $file[1]);
            $fichero = FOLDER . DIRECTORY_SEPARATOR . $archivo;

     			$datos[] = [
               "file" => $file[0], 
               "time" => $this->generateDate(filemtime($fichero), true, true), 
               "type" => pathinfo($fichero, PATHINFO_EXTENSION), 
               "id" => $id[0],
               "size" => $this->size(filesize($fichero), 2)
            ];
            //$datos['total'] = count($datos);
  			}
		}
   	return $datos;
   }
   # Función para restaurar la base de datos
   public function RestoreBackup() {
      $file = "{$_POST['file']}-{$_POST['id']}.{$_POST['ext']}";
      $database = FOLDER . DIRECTORY_SEPARATOR . "{$file}";
      include dirname(ROOT) . "/config.inc.php";
      # Datos de database
      $base = $this->secure($db['database']);
      $user = $this->secure($db['username']);
      $pass = $this->secure($db['password']);
      $host = $this->secure($db['hostname']);
      # Comando para ser ejecutado
      $d = $this->msqldump($host, $user, $pass, $base, 'restore', $database);
      # Usamos system, por que exec no lo hace!
      system($d, $salida);
      if($salida == 0) return "1: Los datos del archivo <b>{$file}</b> se han importado correctamente a la base de datos.";
      else return "0: Se ha producido un error durante la importación. Por favor, compruebe si el archivo está en la misma carpeta que este script. Compruebe también los siguientes datos de nuevo: <br/><br/><table><tr><td>Nombre de la base de datos:</td><td><b>{$base}</b></td></tr><tr><td>Nombre de usuario MySQL:</td><td><b>{$user}</b></td></tr><tr><td>Contraseña MySQL:</td><td><b>NOTSHOWN</b></td></tr><tr><td>Nombre de host MySQL:</td><td><b>{$host}</b></td></tr></table>";
   }
   # Buscamos el backup para eliminar
   public function DeleteBackup() { 
      $ext = ($_POST['ext'] == 'sql') ? 'sql' : 'sql.gz';
      $database = "{$_POST['file']}-{$_POST['id']}.{$ext}";
      # Hacemos un recorrido para buscar el archivo
      return (unlink(FOLDER . DIRECTORY_SEPARATOR . "{$database}")) ? "1: Se ha eliminado <b>{$database}</b>" : "0: No se puede eliminar o no existe el backup!";   
   }  

# END CLASS
}