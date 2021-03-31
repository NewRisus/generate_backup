<?php if (!defined('BACKUP_DB')) exit('No se permite el acceso directo al script');

/**
 * New Risus 2 :: Es para el script New Risus 2
 *
 * @package New_Risus_Tools
 * @author Miguel92 
 * @copyright NewRisus 2021
 * @version v1.2.2 31-03-2021
 * @link https://newrisus.com
*/

$dir = __DIR__;
$ds = DIRECTORY_SEPARATOR;
$file = "config.inc.php";
$location = dirname( dirname($dir) ) . ($pagina == 'newrisus2' ? "{$ds}lib{$ds}" : "{$ds}");

define(($pagina == 'newrisus2' ? "NR__ACCESS" : "TS_HEADER"), TRUE);

# Obtenemos la acción deseada por el usuario
$accion = isset($_GET["accion"]) ? htmlentities($_GET["accion"]) : '';

if(is_file($location . $file)): 
	include "{$location}{$file}";
	if(empty($accion)):
?>
	<p>Con esta herramienta podrás <b>crear</b>, <b>borrar</b> y <b>restaurar backup</b> de tu base de datos, de esta forma al estar completamente desvinculado del sitio, no tendrás problemas para poder ejecutar esta herramienta, ya que no depende del sitio web.</p>
	<div class="mt-4">
		<div class="row rows-3">
			<div class="col">
				<a href="<?php echo "{$url_base}/{$pagina}"; ?>/crear" class="box crear text-white d-block text-decoration-none rounded shadow d-flex justify-content-center align-items-center flex-column py-5">
					<i class="bi bi-hdd-rack"></i>
					<span class="text-white text-uppercase mt-3">Crear backup</span>
				</a>
			</div>
			<div class="col">
				<a href="<?php echo "{$url_base}/{$pagina}"; ?>/restaurar" class="box restaurar text-white d-block text-decoration-none rounded shadow d-flex justify-content-center align-items-center flex-column py-5">
					<i class="bi bi-folder-symlink"></i>
					<span class="text-white text-uppercase mt-3">Restaurar backup</span>
				</a>
			</div>
			<div class="col">
				<a href="<?php echo "{$url_base}/{$pagina}"; ?>/eliminar" class="box eliminar text-white d-block text-decoration-none rounded shadow d-flex justify-content-center align-items-center flex-column py-5">
					<i class="bi bi-trash"></i>
					<span class="text-white text-uppercase mt-3">Eliminar backup</span>
				</a>
			</div>
		</div>
	</div>

<?php	
	endif;
	$act = isset($_GET["accion"]) ? htmlentities($_GET["accion"]) : '';
	$load_file = ($act == 'ejecutar') ? 'exec' : 'scripts';
	# Si existe el archivo de conexión, continuamos!
	include "{$dir}{$ds}{$load_file}.php";
else: 
	echo "<div class=\"text-danger text-center py-5\">No se pudo encontrar el archivo <b>{$file}</b> en tu sitio, asegurate de tenerlo en {$location}</div>";
endif;