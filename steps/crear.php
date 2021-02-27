<?php 
/**
 * Crear :: Archivo para crear el backup
 *
 * @package New_Risus_Tools
 * @author Miguel92 
 * @copyright NewRisus 2021
 * @version v1.0.33 22-02-2021
 * @link https://newrisus.com
*/
?>
<div class="row">
   <div class="col-xxl-8 col-xl-8 col-lg-8 col-md-10 col-sm-12 col-12 offset-xxl-2 offset-xl-2 offset-lg-2 offset-md-1 offset-sm-0">

   	<form method="POST" autocomplete="OFF" id="cuenta-backup">
			<p><?php echo $msg_imp; ?></p>
			<div class="row rows-col-2">
				<div class="col">
					<div class="form-floating mb-3">
					  	<input type="text" class="form-control" value="<?php echo (empty($db['hostname'])) ? '' : $db['hostname']; ?>" name="hostname" autocomplete="off" placeholder="Servidor" required>
					  	<label for="hostname">Servidor</label>
					</div>
				</div>
				<div class="col">
					<div class="form-floating mb-3">
					  	<input type="text" class="form-control" value="<?php echo (empty($db['username'])) ? '' : $db['username']; ?>" name="username" autocomplete="off" placeholder="Usuario" required>
					  	<label for="username">Usuario</label>
					</div>
				</div>
			</div>
			<div class="row rows-col-2">
				<div class="col">
					<div class="form-floating mb-3">
					  	<input type="password" class="form-control" value="<?php echo (empty($db['password'])) ? '' : $db['password']; ?>" name="password" autocomplete="off" placeholder="Contraseña">
					  	<label for="password">Contraseña</label>
					</div>
				</div>
				<div class="col">
					<div class="form-floating mb-3">
					  	<input type="text" class="form-control" value="<?php echo (empty($db['database'])) ? '' : $db['database']; ?>" name="database" autocomplete="off" placeholder="Nombre de la base" required>
					  	<label for="database">Nombre de la base</label>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-8 offset-2">
					<div class="form-floating mb-3">
					  	<input type="text" class="form-control" name="newname" autocomplete="off" placeholder="Nuevo nombre del backup">
					  	<label for="newname">Nuevo nombre del backup</label>
					  	<small class="text-muted msga">Este paso es opcional, y es ponerle al backup.</small>
					</div>
				</div>
			</div>
		</form>
		<div class="buttons">
		   <a href="javascript:generator.crear()" class="btn btn-success generated">Guardar</a>
		</div>

   </div>
</div>
<hr>
<a href="<?php echo $url_base; ?>" class="btn btn-success">Regresar</a>
<a href="<?php echo $url_base; ?>?accion=eliminar" class="btn btn-danger">Eliminar copias</a>
<a href="<?php echo $url_base; ?>?accion=restaurar" class="btn btn-primary">Restaurar copias</a>