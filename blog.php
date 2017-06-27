<!DOCTYPE html>
<html lang="pt">
<head>
	<title>Meu CMS</title>
	<link rel="stylesheet" type="text/css" href="_css\style.css" />
</head>
<body>
<?php
	include_once('_class\CMS.php');
	$obj = new CMS();

	//Mudar configuração para seu próprio banco de dados
	$obj->host = 'localhost';
	$obj->usuario = 'root';
	$obj->senha = '';
	$obj->bd  = 'acervo';

	$obj->conectar();

	if($_POST)
		$obj->gravar($_POST);

	echo ( $_GET['admin'] == 1 ) ? $obj->display_admin() : $obj->display_public();

?>
</body>
</html>