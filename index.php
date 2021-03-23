<?php 

/**
 * Index :: Aplicación para crear, borrar y restaurar db
 *
 * @package New_Risus_Tools
 * @author Miguel92 
 * @copyright NewRisus 2021
 * @version v1.1.0 23-02-2021
 * @link https://newrisus.com
*/

require_once 'app.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="es" xml:lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, user-scalable=no">
<link rel="shortcut icon" href="<?php echo $url_base . '/assets/images/favicon.ico'; ?>" type="image/x-icon" />
<link rel="stylesheet" href="<?php echo $url_base . '/assets/css/bootstrap.min.css?' . time(); ?>">
<link rel="stylesheet" href="<?php echo $url_base . '/assets/css/bootstrap-icons.min.css?' . time(); ?>">
<link rel="stylesheet" href="<?php echo $url_base . '/assets/css/style.css?' . time(); ?>">
<script src="<?php echo $url_base . '/assets/js/jquery.min.js?' . time(); ?>"></script>
<script>
var global = {
	url: '<?php echo $url_base; ?>',
	pagina: '<?php echo $pagina; ?>',
}
</script>
<title><?php echo $title; ?></title>
</head>
<body class="">
	<div class="py-3 text-center">
		<img src="<?php echo $url_base . '/assets/images/logo-complete.webp'; ?>" class="img-fluid nrlogo" alt="New Risus Tools">
	</div>
	<div class="container">
		<i id="boton" class="bi bi-palette"></i>
		<?php include ROOT . "steps/{$pagina}.php"; ?>
	</div>
	<footer class="text-center py-4">
      <p class="m-0 p-0 ">Copyright <?php echo date("Y"); ?> &copy; <a href="https://newrisus.com" target="_blank">New Risus</a> <small class="d-block text-muted">Versión <?php echo $version; ?></small></p> 
   </footer>
	<script src="<?php echo $url_base . '/assets/js/sweetalert.min.js?' . time(); ?>"></script>
	<script src="<?php echo $url_base . '/assets/js/newrisus_tools.js?' . time(); ?>"></script>
</body>
</html>