<?php 
/**
 * Restaurar :: Archivo para restaurar la base de datos
 *
 * @package New_Risus_Tools
 * @author Miguel92 
 * @copyright NewRisus 2021
 * @version v1.1.0 23-02-2021
 * @link https://newrisus.com
*/

# Incluimos el archivo de configuración

$sql = $tsDBackup->getBackup();
# Contamos todos los array
$total = count($sql);

if($sql):
?>
<div id="alerta"></div>
<table class="table table-dark table-striped table-hover table-borderless">
  <caption id="total">Backup creado: <b><?php echo $total; ?></b></caption>
  	<thead>
   	<tr>
   	  <th scope="col">Nombre</th>
   	  <th scope="col">Fecha</th>
      <th scope="col">Extensión</th>
   	  <th scope="col">Peso</th>
   	  <th scope="col">Acción</th>
   	</tr>
  	</thead>
  	<tbody>
  		<?php foreach ($sql as $key => $value):?>
    	<tr id="<?php echo $sql[$key]['id']; ?>">
      	<td scope="row"><?php echo $sql[$key]['file']; ?></td>
      	<td><?php echo $sql[$key]['time']; ?></td>
        <td class="text-uppercase"><?php echo $sql[$key]['type']; ?></td>
      	<td class="text-uppercase"><?php echo $sql[$key]['size']; ?></td>
      	<td>
      		<div class="d-flex justify-content-around align-items-center">
					<a href="javascript:generator.restaurar(<?php echo $sql[$key]['id']; ?>, '<?php echo $sql[$key]['file']; ?>', '<?php echo $sql[$key]['type']; ?>')" class="id_<?php echo $sql[$key]['id']; ?> text-primary">Restaurar</a>
				</div>
      	</td>
    	</tr>
    	<?php endforeach; ?>
  	</tbody>
</table>
<hr>
<div class="mt-2 mb-4">
  <a href="<?php echo $url_base; ?>/index.php" class="btn btn-success">Regresar</a>
  <a href="<?php echo $url_base; ?>/index.php?accion=eliminar" class="btn btn-danger">Eliminar copias</a>
  <a href="<?php echo $url_base; ?>/index.php?accion=crear" class="btn btn-warning">Crear una copia</a>
</div>
<?php else: ?>
   <div class="alert alert-primary">
      <h5>No hay backup:</h5>
      <p>No existe ningún backup para restaurar tu sitio, en el caso que sea la primera vez, por favor debes crear uno <a href="<?php echo $url_base; ?>/index.php?accion=crear">Crear backup</a></p>
   </div>
<?php endif; ?>