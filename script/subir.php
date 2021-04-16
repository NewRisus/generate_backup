<?php if (!defined('BACKUP_DB')) exit('No se permite el acceso directo al script');

/**
 * Subir :: Subir tu copia a tu servidor
 *
 * @package New_Risus_Tools
 * @author Miguel92 
 * @copyright NewRisus 2021
 * @version v1.2.3 16-05-2021
 * @link https://newrisus.com
*/

$upload = dirname(__DIR__) . DIRECTORY_SEPARATOR . "backup_db" . DIRECTORY_SEPARATOR;

if (isset($_POST['uploadBtn']) && $_POST['uploadBtn'] == 'Subir archivo'):

	$fileTmpPath = $_FILES['uploadedFile']['tmp_name'];
	$fileName = $_FILES['uploadedFile']['name'];
	$fileSize = $_FILES['uploadedFile']['size'];
	$fileType = $_FILES['uploadedFile']['type'];
	$fileNameCmps = explode(".", $fileName);
	$fileExtension = strtolower(end($fileNameCmps));

	$newFileName = "{$fileName}@".time().".{$fileExtension}";

	$dest_path = "{$upload}{$newFileName}";

	if(move_uploaded_file($fileTmpPath, $dest_path)) {
		echo '<div class="text-center text-success py-2">El archivo se cargó correctamente.</div>';
		$url_base = "{$_SERVER["REQUEST_SCHEME"]}://{$_SERVER["HTTP_HOST"]}" . dirname($_SERVER['REDIRECT_URL']);
		echo "<div class=\"text-center small fts-italic text-muted\">Se redireccionará en 5s...</div>";
		header("Refresh: 5; url={$url_base}/restaurar");
	} else {
		echo '<div class="text-center text-danger py-2">Hubo algún error al mover el archivo al directorio de carga. Asegúrese de que el servidor web pueda escribir en el directorio de carga.</div>';
	}

else:
?>
	<div class="w-50 mx-auto">
	<form method="POST" action="<?php echo "{$url_base}/{$pagina}/subir"; ?>" enctype="multipart/form-data">
		<p>Acá tu podrás seleccionar tu backup que deseas subir y poder restaurar tu base de datos!</p>
		<div class="input-group mb-3">
  			<input type="file" name="uploadedFile" class="form-control" id="uploadedFile">
		</div>
   
    	<input type="submit" name="uploadBtn" class="btn btn-primary" value="Subir archivo" />
  </form>
</div>

<?php 
endif;
