<?php if (!defined('BACKUP_DB')) exit('No se permite el acceso directo al script');

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
 * @since      mysqldump.php 1.2.2
 * @date       30-03-2021
 * @purpose:   Crear copia de seguridad de la base de datos y usar las copias
 *
*/

class tsMysql {
   
   # Hacemos la variabes seguras
   public function Secure($string = NULL) {
   	$var = htmlspecialchars($string, ENT_NOQUOTES, 'UTF-8');
      return $var;
   }

   # Chequeamos nombre
   public function checkName($string = NULL) {
   	$string = htmlspecialchars(trim($string));
   	if (!preg_match('/^([A-Za-z0-9_]+)$/', $string)) return '0: Solo letras y números, sin espacios.';
      return '1: Este paso es opcional, y es ponerle al backup.';
   }

   # Se generá nuevo formato para fecha actual es: "25 Ene.", para más "25 Ene., 2020"
   function generateDate($date, $year = false, $short = false) {
      if(!empty($date)) {
         # Si es de este año no mostramos el "año", pero si es del año pasado si mostramos el "año"
         $y = (strftime('%Y', $date) === date('Y')) ? '' : strftime(', %Y', $date);
         # Concatenamos el año
         $dc = ($short) ? "%d, %b %y" : "%d.%m.%Y %T %p";
         $date = ucfirst(strftime(($year) ? $dc : "%B %d" . $y, $date));
      }
      return $date;
   }

   # Función para ejecutar el comando y crear el backup
   public function mysqldump($db, $file, $tables) {
      # Acción para crear el backup de la base de datos
      $format = ($db['extension'] == 2) ? "| gzip > {$file}.sql.gz" : "> {$file}.sql";
      # Comando que se debe ejecutar
      $dump = "mysqldump --opt --compact --host={$db['hostname']} --user={$db['username']} --password={$db['password']} {$db['database']} {$tables} {$format}";
      return $dump;
   }

   public function restore($db, $location){
      $conn = new mysqli($db['hostname'], $db['username'], $db['password'], $db['database']);
      $sql = '';
      $lines = file($location);
      $output = ['error'=>false];
      foreach ($lines as $line) {
         if(substr($line, 0, 2) == '--' || $line == '') continue;
         $sql .= $line;
         if (substr(trim($line), -1, 1) == ';'){
            $query = $conn->query($sql);
            if(!$query){
               $output['error'] = true;
               $output['message'] = $conn->error;
            } else $output['message'] = 'Base de datos restaurada con éxito';
            //reset our query variable
            $sql = '';
         }
      }
      return $output;
   }
   
   # Función para ejecutar el comando y restaurar el backup
   public function mysql($db, $file, $compress) {
      $h = $this->Secure($db['hostname']);
      $u = $this->Secure($db['username']);
      $p = $this->Secure(str_replace(' ', '+', $db['password']));
      $b = $this->Secure($db['database']);
      # 
      $mysql = "mysql --host={$h} --user={$u} --password=\"{$p}\" {$b}";
      # 
   	$command = ($compress) ? "gunzip < {$file} | {$mysql}" : $this->restore($db, $file[1]);
   	return $command;
   }

   # Obtenemo peso del archivo
   public function size($bytes, $decimals = 2) {
      $sz = 'BKMGTP';
      $factor = floor((strlen($bytes) - 1) / 3);
      return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) .' '. @$sz[$factor];
   }

   public function download($action, $data) {
      $key = Llave;
      $method = 'AES-128-ECB';
      return ($action) ? openssl_encrypt($data, $method, $key) : openssl_decrypt($data, $method, $key);
   }

   # Función para obtener todos los backups
   public function getBacks() {
      $directorio = opendir(dirname(__DIR__) . DIRECTORY_SEPARATOR . "backup_db");

      while ($archivo = readdir($directorio)) { 
         if(($archivo != '.')&&($archivo != '..')){
            # Separamos el archivo
            $file = explode('@', $archivo);
            $file_id = explode('.', $file[1]);
            $fichero = dirname(__DIR__) .  DIRECTORY_SEPARATOR . "backup_db" . DIRECTORY_SEPARATOR . $archivo;

            $datos[] = [
               "id" => intval($file_id[0]),
               "nombre" => $file[0],
               "fecha" => ucfirst(strftime("%d.%m.%y - %T", filemtime($fichero))), 
               "tipo" => pathinfo($fichero, PATHINFO_EXTENSION),  
               "peso" => $this->size(filesize($fichero), 2),
               "descargar" => $this->download(1, $archivo)
            ];
         }
      }
      return $datos;
   }

   # Función para eliminar uno o más backups
   public function delete() {
      $directorio = dirname(__DIR__) . DIRECTORY_SEPARATOR . "backup_db" . DIRECTORY_SEPARATOR ;

      foreach ($_POST["files"] as $key => $value) {
         $file_del = $this->Secure($this->download(0, $_POST["files"][$key]));
         if(unlink($directorio . $file_del)) return true;
         return false;
      }

   }

}