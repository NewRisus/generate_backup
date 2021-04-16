<?php 

/**
 * Index :: Aplicación para crear, borrar y restaurar db
 *
 * @package New_Risus_Tools
 * @author Miguel92 
 * @copyright NewRisus 2021
 * @version v1.2.3 16-05-2021
 * @link https://newrisus.com
*/

require_once 'app.php';
if(empty($_GET['download'])):
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
		<?php if(empty($GLOBALS['SCRIPT'])): ?>
			<div class="d-flex justify-content-center align-items-center">
				<div class="w-75 mx-auto mt-5">
					<p>Selecciona el script que estas utilizando:</p>
					<div class="row rows-3">
						<div class="col">
							<a href="<?php echo $url_base; ?>/index.php?script=phpost" class="text-decoration-none text-white box rounded shadow d-flex justify-content-center align-items-center flex-column py-5">
								<i class="bi bi-hdd-rack"></i>
								<span class="text-white text-uppercase">PHPost Risus</span>
							</a>
						</div>
						<div class="col">
							<a href="<?php echo $url_base; ?>/index.php?script=newrisus" class="text-decoration-none text-white box rounded shadow d-flex justify-content-center align-items-center flex-column py-5">
								<i class="bi bi-hdd-rack"></i>
								<span class="text-white text-uppercase">New Risus v1.x</span>
							</a>
						</div>
						<div class="col">
							<a href="<?php echo $url_base; ?>/index.php?script=newrisus2" class="text-decoration-none text-white box rounded shadow d-flex justify-content-center align-items-center flex-column py-5">
								<i class="bi bi-hdd-rack"></i>
								<span class="text-white text-uppercase">New Risus v2.x</span>
							</a>
						</div>
					</div>
				</div>
			</div>
		<?php else: ?>
			<?php include ROOT . "script/acciones.php"; ?>
		<?php endif; ?>
	</div>
	<footer class="text-center py-4">
      <p class="m-0 p-0 ">Copyright <?php echo date("Y"); ?> &copy; <a href="https://newrisus.com" class="text-decoration-none fw-bold" target="_blank">New Risus</a> <small class="d-block text-muted small">Versión <?php echo $version; ?> - <a href="<?php echo $url_base . '/changelog.txt?' . $fecha; ?>" class="text-decoration-none text-primary fst-italic" target="_blank">Historial de cambios</a></small></p> 
   </footer>
	<script src="<?php echo $url_base . '/assets/js/sweetalert.min.js?' . time(); ?>"></script>
	<script src="<?php echo $url_base . '/assets/js/newrisus_tools.js?' . time(); ?>"></script>
</body>
</html>
<?php 

else:
	include __DIR__ . "/download.php";
endif;

?>