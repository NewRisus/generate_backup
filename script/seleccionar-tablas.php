<?php if (!defined('BACKUP_DB')) exit('No se permite el acceso directo al script');

/**
 * Seleccionar tablas :: Es para seleccionar la tablas que queremos salvar
 *
 * @package New_Risus_Tools
 * @author Miguel92 
 * @copyright NewRisus 2021
 * @version v1.2.2 31-03-2021
 * @link https://newrisus.com
*/

if($db['hostname'] != $_POST['hostname'] || $db['username'] != $_POST['username'] || $db['password'] != $_POST['password'] || $db['database'] != $_POST['database']):
	echo "<div class=\"text-danger py-2 text-center\">Por favor, verifica que todos tus datos sean correctos!</div>";
else:
	$flsql = (empty($_POST['newname']) ? $_POST['database'] : $_POST['newname']) . ($_POST['archive'] == 1 ? '.sql' : '.sql.gz');
	echo '<div class="fs-5">Selecciona las tablas que deseas crear la copia de seguridad:</div>';
	echo "<p>Todo se guardará en <b>{$flsql}</b></p>";

	$db_link = new mysqli($_POST['hostname'], $_POST['username'], $_POST['password'], $_POST['database']);
	if (mysqli_connect_errno()):
	   printf("Falló la conexión: %s\n", mysqli_connect_error());
	else:
	   if (!$db_link->set_charset('utf8mb4')):
	      printf("No se pudo establecer la codificaci&oacute;n de caracteres: %s\n", $db_link->error);
	   endif;
	endif;

	$resultado = mysqli_query($db_link, "SHOW TABLES FROM {$_POST['database']}");

	if (!$resultado) {
	   echo "Error de BD, no se pudieron listar las tablas\n";
	   echo 'Error MySQL: ' . mysqli_error();
	   exit();
	}
	$row_cnt = mysqli_num_rows($resultado);

?>
	<form method="POST" action="<?php echo "{$url_base}/{$pagina}"; ?>/ejecutar" autocomplete="OFF">
	
		<span id="saveAllTables" class="d-block mb-2"><input type="checkbox" class="me-2" name="base[todos]" id="todos" value="todos"><label for="todos">Guardar todas las tablas</label></span>
		<div class="row" id="all">
			<p class="col-12">Selecciona algunas de las <b class="text-success"><?php echo $row_cnt; ?> tablas</b> que desees:</p>
			<?php	
				$i = 0;

				while ($fila = mysqli_fetch_row($resultado)) {
					$id = $i++;
				   echo "<div class=\"col-3 mb-2\"><input type=\"checkbox\" class=\"me-2\" id=\"{$id}\" name=\"base[{$fila[0]}]\" value=\"{$fila[0]}\"><label for=\"{$id}\">{$fila[0]}</label></div>";
				}
			?>
		</div>
		<input type="hidden" name="hostname" value="<?php echo $_POST['hostname']; ?>">
		<input type="hidden" name="username" value="<?php echo $_POST['username']; ?>">
		<input type="hidden" name="password" value="<?php echo $_POST['password']; ?>">
		<input type="hidden" name="database" value="<?php echo $_POST['database']; ?>">
		<input type="hidden" name="newname" value="<?php echo $_POST['newname']; ?>">
		<input type="hidden" name="archive" value="<?php echo $_POST['archive']; ?>">
		<input type="hidden" name="type_action" value="<?php echo $_POST['type_action']; ?>">

		<input type="submit" name="start" value="Generar copia..." class="btn btn-success mt-2">
	</form>
	<script>
		$("input#todos").on('click', function(h) {
		   $('#all').toggle();
		});
	</script>	

<?php 
endif;