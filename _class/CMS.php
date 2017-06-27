<?php

class CMS{

	var $host;
	var $usuario;
	var $senha;
	var $bd;
	
public function display_public() {
    $q = "SELECT * FROM artigos ORDER BY data DESC LIMIT 3";
    $r = mysqli_query(mysqli_connect($this->host, $this->usuario, $this->senha),$q);
    if ( $r !== false && mysql_num_rows($r) > 0 ) {
        while ( $a = mysql_fetch_assoc($r) ) {
            $titulo = stripslashes($a['titulo']);
            $conteudo = stripslashes($a['conteudo']);
            $entry_display .= <<<ENTRY_DISPLAY
            <div class="post">
                <h2>
                $titulo
                </h2>
                <p>
                $conteudo
                </p>
            </div>
ENTRY_DISPLAY;
        }
    } else {
        $entry_display = <<<ENTRY_DISPLAY
        <h2> Este Site está em Construção </h2>
        <p>
        Clique no link para adicionar novos posts!
        </p>
ENTRY_DISPLAY;
    }
    $entry_display .= <<<ADMIN_OPTION
        <p class="admin_link">
        <a href="{$_SERVER['PHP_SELF']}?admin=1">Add Novo Post</a>
        </p>
ADMIN_OPTION;
    return $entry_display;
}

	public function display_admin(){
		return <<<ADMIN_FORM
			<form action="{$_SERVER['PHP_SELF']}" method="post">

			<label for="titulo">Título:</label><br />
			<input name="titulo" id="titulo" type="text" maxlength="150" />
			<div class="clear"></div>

			<label for="conteudo">Conteúdo:</label><br />
			<textarea name="conteudo" id="conteudo"></textarea>
			<div class="clear"></div>

			<input type="submit" value="Criar Post!" />
			</form>
			<br />
			<a href="blog.php">Voltar para Home</a>
ADMIN_FORM;
	}

	public function gravar($p){
		if($_POST['titulo'])
			$titulo = mysqli_real_escape_string(mysqli_connect($this->host, $this->usuario, $this->senha),$_POST['titulo']);
		if($_POST['conteudo'])
			$conteudo = mysqli_real_escape_string(mysqli_connect($this->host, $this->usuario, $this->senha),$_POST['conteudo']);
		if($titulo && $conteudo){
			$data = time();
			$sql = "INSERT INTO artigos (titulo,conteudo,data) VALUES('$titulo','$conteudo','$data')";
			return mysqli_query(mysqli_connect($this->host, $this->usuario, $this->senha),$sql);
		} else{
			return false;
		}
	}
	public function conectar(){
		mysqli_connect($this->host, $this->usuario, $this->senha)
			or die("Não foi possível conectar. ".mysql_error());
		mysqli_select_db(mysqli_connect($this->host, $this->usuario, $this->senha),$this->bd)
			or die("Não foi possível selecionar o BD. ".mysql_error());
			return $this->criaBD();
	}
	
	//verifica se a tabela 'artigos' existe, caso contrario, cria a tabela
	public function criaBD(){
		$sql = <<<MySQL_QUERY
			CREATE TABLE IF NOT EXISTS artigos(
			id INT(11) NOT NULL AUTO_INCREMENT,
			titulo VARCHAR(150),
			conteudo TEXT,
			data VARCHAR(100),
			PRIMARY KEY (id)
			)
MySQL_QUERY;
		return mysqli_query(mysqli_connect($this->host, $this->usuario, $this->senha),$sql);	
	}
}

?>