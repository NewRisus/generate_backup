<?php 
/**
 * Eliminar :: Archivo para eliminar los backups
 *
 * @package New_Risus_Tools
 * @author Miguel92 
 * @copyright NewRisus 2021
 * @version v1.0.32 22-02-2021
 * @link https://newrisus.com
*/

$sql = $tsDBackup->getBackup();
# Contamos todos los array
$total = count($sql);

if($sql):
?>
<table class="table table-dark table-striped table-hover table-borderless">
  <caption id="total">Backup creado: <b><?php echo $total; ?></b></caption>
  	<thead>
   	<tr>
   	  <th scope="col">Backup</th>
   	  <th scope="col">Fecha</th>
   	  <th scope="col">Acción</th>
   	</tr>
  	</thead>
  	<tbody>
  		<?php foreach ($sql as $key => $value):?>
    	<tr id="<?php echo $sql[$key]['id']; ?>">
      	<td><?php echo $sql[$key]['file']; ?>-<?php echo $sql[$key]['id']; ?>.<?php echo $sql[$key]['type']; ?></td>
      	<td><?php echo $sql[$key]['time']; ?></td>
      	<td>
      		<div class="d-flex justify-content-around align-items-center">
					<a href="javascript:generator.eliminar(<?php echo $sql[$key]['id']; ?>, '<?php echo $sql[$key]['file']; ?>', '<?php echo $sql[$key]['type']; ?>')" class="text-danger">Eliminar</a>
				</div>
      	</td>
    	</tr>
    	<?php endforeach; ?>
  	</tbody>
</table>
<hr>
<?php else: ?>
   <div class="alert alert-danger">
      <h5>No hay backup:</h5>
      <p>No puedes eliminar lo que no existe, así que...vete de aquí.</p>
   </div>
<?php endif; ?>
<div class="mt-2 mb-4">
  <a href="<?php echo $url_base; ?>" class="btn btn-success">Regresar</a>
  <a href="<?php echo $url_base; ?>?accion=restaurar" class="btn btn-primary">Restaurar copias</a>
  <a href="<?php echo $url_base; ?>?accion=crear" class="btn btn-warning">Crear una copia</a>
</div>