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

$msg_imp = 'Para que sea más seguro, será mejor que ingrese los datos manualmente para evitar revelar los datos de conexión con la base de datos!';

$pagina = $_GET["script"];

if($accion == 'crear'): ?>
<div class="row">
   <div class="col-xxl-8 col-xl-8 col-lg-8 col-md-10 col-sm-12 col-12 offset-xxl-2 offset-xl-2 offset-lg-2 offset-md-1 offset-sm-0">

   	<form method="POST" action="<?php echo "{$url_base}/{$pagina}"; ?>/seleccionar-tablas" autocomplete="OFF" id="cuenta-backup">
			<p><?php echo $msg_imp; ?></p>
			<div class="row rows-col-2">
				<div class="col">
					<div class="form-floating mb-3">
					  	<input type="text" class="form-control" value="" name="hostname" autocomplete="off" placeholder="Servidor" required>
					  	<label for="hostname">Servidor</label>
					</div>
				</div>
				<div class="col">
					<div class="form-floating mb-3">
					  	<input type="text" class="form-control" value="" name="username" autocomplete="off" placeholder="Usuario" required>
					  	<label for="username">Usuario</label>
					</div>
				</div>
			</div>
			<div class="row rows-col-2">
				<div class="col">
					<div class="form-floating mb-3">
					  	<input type="password" class="form-control" value="" name="password" autocomplete="off" placeholder="Contraseña">
					  	<label for="password">Contraseña</label>
					</div>
				</div>
				<div class="col">
					<div class="form-floating mb-3">
					  	<input type="text" class="form-control" value="" name="database" autocomplete="off" placeholder="Nombre de la base" required>
					  	<label for="database">Nombre de la base</label>
					</div>
				</div>
			</div>
			<div class="row rows-col-2">
				<div class="col">
					<div class="form-floating mb-3">
					  	<input type="text" class="form-control" name="newname" autocomplete="off" placeholder="Nuevo nombre del backup">
					  	<label for="newname">Nuevo nombre del backup</label>
					  	<small class="text-muted msga">Este paso es opcional, y es ponerle al backup.</small>
					</div>
				</div>
				<div class="col">
					<div class="form-floating mb-3">
					  	<select name="archive" id="archive" class="form-select">
					  		<option value="0">Seleccione el tipo de archivo</option>
					  		<option value="1">.sql</option>
					  		<option value="2">.sql.gz</option>
					  	</select>
					  	<label for="archive">Tipo de archivo</label>
					</div>
				</div>
			</div>
			<div class="buttons">
				<input type="hidden" value="create_backup" name="type_action">
				<input type="submit" class="btn btn-success" value="Continuar">
			</div>
		</form>

   </div>
</div>
<hr>
<a href="<?php echo "{$url_base}/{$pagina}"; ?>" class="btn btn-success">Regresar</a>
<a href="<?php echo "{$url_base}/{$pagina}"; ?>/eliminar" class="btn btn-danger">Eliminar copias</a>
<a href="<?php echo "{$url_base}/{$pagina}"; ?>/restaurar" class="btn btn-primary">Restaurar copias</a>
<?php 
else: 
	if(!empty($accion))
		include ROOT . "script/{$accion}.php"; 
 endif; 
 ?>