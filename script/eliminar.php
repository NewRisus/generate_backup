<?php 

/**
 * Borrar :: Aplicación para borrar la/s copia/s de seguridad
 *
 * @package New_Risus_Tools
 * @author Miguel92 
 * @copyright NewRisus 2021
 * @version v1.2.3 16-05-2021
 * @link https://newrisus.com
*/

include __DIR__ . DIRECTORY_SEPARATOR . "mysqldump.php";
$tsMysql = new tsMysql();


$carpeta = @scandir(dirname(__DIR__)."/backup_db");
if (count($carpeta) < 2): ?>

   <div class="py-3 text-info text-center">
   	<span>Dentro del directorio "<b>backup_db</b>" no existe ninguna copia!</span>
   	<div class="my-2">
   		<a href="<?php echo "{$url_base}/index.php?script={$pagina}"; ?>" class="btn btn-sm btn-success">Regresar</a>
   	</div>
   </div>

<?php 
else:

	$file_backup = $tsMysql->getBacks();
	$total = count($file_backup);

	# En el caso que quiera cambiar
	if(!empty($_POST['back'])) {
		header("Location: {$url_base}/{$pagina}/eliminar");
	}
	# Avanzamos para borrar los elementos
	if(!empty($_POST['avaced'])) {
		if($tsMysql->delete()) {
			header("Location: {$url_base}/{$pagina}/eliminar");
		}
	} else {
		if(empty($_POST['deleted'])) { ?>
			<p>Ahora tu puedes seleccionar las base de datos quieres eliminar!</p>
			<form action="<?php echo "{$url_base}/index.php?script={$pagina}"; ?>&accion=eliminar" method="POST">
				<div class="row">
					<?php foreach ($file_backup as $key => $value): ?>
						<div class="col-3 mb-3">
							<div class="d-flex justify-content-start align-items-center">
								<input type="checkbox" class="me-2" name="files[]" value="<?php echo $file_backup[$key]['descargar']; ?>" id="<?php echo $file_backup[$key]['id']; ?>">
								<label for="<?php echo $file_backup[$key]['id']; ?>">
									<span class="d-block text-capitalize"><?php echo ($file_backup[$key]['tipo'] == 'sql' ? '<i class="bi bi-file-earmark-text me-2"></i>' : '<i class="bi bi-file-earmark-zip me-2"></i>') . $file_backup[$key]['nombre']; ?></span>
									<small class="d-block text-muted"><?php echo $file_backup[$key]['fecha']; ?></small>
								</label>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
				<input type="submit" value="Borrar copias" class="btn btn-danger" name="deleted">
			</form>
		<?php 
		} else { 
		?>
			<p>¿Seguro que <?php echo (count($_POST['files']) == 1 ? 'desea eliminar esta copia' : 'deseas estas copias'); ?>?</p>
			<form action="<?php echo "{$url_base}/index.php?script={$pagina}"; ?>&accion=eliminar" method="POST">
				<ul>
					<?php foreach ($_POST['files'] as $key => $value): ?>
						<li><?php echo $tsMysql->download(0, $_POST['files'][$key]); ?></li>
						<input type="hidden" name="files[]" value="<?php echo $_POST['files'][$key]; ?>">
					<?php endforeach; ?>
				</ul>
				<input type="submit" value="Si, quiero continuar" class="btn btn-danger" name="avaced">
				<input type="button" value="No, quiero cambiar" class="btn btn-primary ms-2" name="back">
			</form>
		<?php 
		}
	} 
endif;