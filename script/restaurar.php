<?php if (!defined('BACKUP_DB')) exit('No se permite el acceso directo al script');

/**
 * Restaurar :: Con este archivo podremos restaurar la base o descargarla
 *
 * @package New_Risus_Tools
 * @author Miguel92 
 * @copyright NewRisus 2021
 * @version v1.2.3 16-05-2021
 * @link https://newrisus.com
*/

# Debemos obtener todos los respaldos creados
$usuario = (isset($_POST['username']) ? $_POST['username'] : '');

include __DIR__ . DIRECTORY_SEPARATOR . "mysqldump.php";
$tsMysql = new tsMysql();

if(empty($usuario)): 

	if(empty($_GET["backup"])): 

		$carpeta = @scandir(dirname(__DIR__)."/backup_db");
		if (count($carpeta) < 2):
	?>
		<div class="py-3 text-info text-center">
	   	<span>Dentro del directorio "<b>backup_db</b>" no existe ninguna copia!</span>
	   	<div class="my-2">
	   		<a href="<?php echo "{$url_base}/index.php?script={$pagina}"; ?>" class="btn btn-sm btn-success">Regresar</a>
	   	</div>
	   </div>
	   
		<?php else: ?>

		<p>Ahora tu puedes seleccionar que base de datos quieres restarurar o descargar!</p>
		<table class="table table-striped table-dark">
			<thead>
				<tr>
					<th>ID</th>
					<th>Nombre</th>
					<th>Fecha</th>
					<th>Peso</th>
					<th>Tipo</th>
					<th>Acción</th>
				</tr>
			</thead>
			<tbody>
				<?php 
					$file_backup = $tsMysql->getBacks();
					$total = count($file_backup);
					foreach ($file_backup as $key => $value):
				?>
				<tr>
					<td><?php echo $file_backup[$key]['id']; ?></td>
					<td><?php echo $file_backup[$key]['nombre']; ?></td>
					<td><?php echo $file_backup[$key]['fecha']; ?></td>
					<td><?php echo $file_backup[$key]['peso']; ?></td>
					<td class="align-middle text-center text-uppercase"><?php echo $file_backup[$key]['tipo']; ?></td>
					<td>
						<div class="d-flex justify-content-around align-items-center">
							<a href="<?php echo "{$url_base}?download={$file_backup[$key]['descargar']}"; ?>" class="text-decoration-none text-info" title="Descargar" target="_blank"><i class="bi bi-cloud-download"></i></a>
							<a href="<?php echo "{$url_base}/index.php?script={$pagina}&accion=restaurar&backup={$file_backup[$key]['descargar']}"; ?>" class="text-decoration-none text-success" title="Restaurar"><i class="bi bi-journal-arrow-up"></i></a>
						</div>
					</td>
				</tr>
				<?php endforeach; ?>
				<tfoot>
					<tr>
						<td colspan="6">Total <?php echo $total; ?></td>
					</tr>
				</tfoot>
			</tbody>
		</table>
		<div class="py-2">
			<div class="d-flex justify-content-center align-items-center">
				<a href="<?php echo "{$url_base}/index.php?script={$pagina}"; ?>" class="btn btn-sm btn-success">Regresar</a>
				<a href="<?php echo "{$url_base}/index.php?script={$pagina}&accion=subir"; ?>" class="btn btn-sm btn-primary mx-3">Subir una copia</a>
				<a href="<?php echo "{$url_base}/index.php?script={$pagina}&accion=crear"; ?>" class="btn btn-sm btn-primary mx-3">Crear backup</a>
				<a href="<?php echo "{$url_base}/index.php?script={$pagina}&accion=eliminar"; ?>" class="btn btn-sm btn-danger">Eliminar backup</a>
			</div>
		</div>
		<?php endif; ?>
	<?php 
		else: 
			$file = $tsMysql->download(0, str_replace(' ', '+', $_GET['backup']));
	?>
		<p>La base que quieres restaurar es: <b><?php echo $file; ?></b></p>
		<form method="POST" action="<?php echo "{$url_base}/index.php?script={$pagina}"; ?>&accion=restaurar" autocomplete="OFF">
			<p>Para asegurar que sea correcto por favor ingresa el nombre del usuario de la base de datos.</p>
			<div class="form-floating mb-3">
			  	<input type="text" class="form-control" name="username" autocomplete="off" placeholder="Usuario" required>
			  	<label for="username">Usuario</label>
			</div>
			<input type="hidden" name="file" value="<?php echo $file; ?>">
			<input type="submit" class="btn btn-success" value="Continuar">
		</form>
	<?php endif;
else:
	if($usuario === $db['username']): 

	   $file_sql = [
      	dirname(__DIR__) . DIRECTORY_SEPARATOR . "backup_db" . DIRECTORY_SEPARATOR . $_POST['file'],
      	"{$url_base}/backup_db/{$_POST['file']}"
      ];
      # Datos de database
		$fileNameCmps = explode(".", $_POST['file']);
		$fileExtension = strtolower(end($fileNameCmps));
		$compress = ($fileExtension == 'sql') ? 0 : 1;
	   # Comando para ser ejecutado
	   $d = $tsMysql->mysql($db, $file_sql, $compress);
	   echo $d['message'];

   else: ?>
		<div class="w-25 mx-auto text-danger text-center">
			<i class="bi bi-exclamation-triangle h1 mb-3"></i>
			<span class="d-block my-3">Error...Tu quien eres?</span>
			<small class="d-block mt-2 text-muted">Eliminando tu sistema operativo XD! nah broma...</small>
		</div>

	<?php endif;
endif;