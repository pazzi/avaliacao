<?php
/* Embrapa - Empresa Brasileira de Pesquisa Agropecuária
 * Embrapa Meio Ambiente 
 * Autor: Cláudia Vaz Crecci
 * Data: 
 * Autor: Cláudia Vaz Crecci
 * Data: 04/03/2013
 * Descrição: tratamento para a tag <br />
 * 
 */
/**
 * @abstract Tratamento de injections em formulários.
 * @return string
 */
function antiInjection($str)
{
	// Início: tratamento para a tag <br /> - <enter>
	
	/*Este código foi necessário porque a função preg_replace abaixo estava tratando o \n e \r, os quais eram substituídos por
	por rn, n ou r, dependendo do sistema operacional. Quando o cidadão digitava <enter> em um campo textarea, por exemplo, 
	os textos ficavam ligados por uma dessas três opções.*/

	// Início: Substitui o <br /> por caracteres em branco
	$order   = array("\r\n", "\n", "\r");
	$replace = ' ';
	$new_str = str_replace($order, $replace, $str);
	// Fim: Substitui o <br /> por caracteres em branco
	

	// Remove várias ocorrências de caracteres em branco da string e os converte em espaços simples
	// Código necessário para quando o usuário digitar vários <enter> no campo
	$new_str = preg_replace('/\s+/', ' ', $new_str);
	
	// Fim: tratamento para a tag <br /> - <enter>

	$str = preg_replace(sql_regcase("/(%0a|%0d|Content-Type:|bcc:|to:|cc:|Autoreply:|from|select|insert|delete|where|drop table|show tables|#|\*|--|onmouseover|onclick|prompt|\\\\)/"), "", $new_str);
	$str = trim($str); // Remove espaços vazios.
	$str = strip_tags($str); // Remove tags HTML e PHP.
	$str = addslashes($str); // Adiciona barras invertidas à uma string.
	$str = mysql_escape_string($str);

	return $str;
}

// Função para tratamento de XSS
function xssafe($data,$encoding='ISO-8859-15')
{
	$mystring = strtoupper($data);
	$findme   = strtoupper('script');
	$pos = strpos($mystring, $findme);

	// Note o uso de ===.  Simples == não funcionaria como esperado
	// por causa da posição de 'a' é 0 (primeiro) caractere.
	if ($pos === false) {
		//return "A string '$findme' não foi encontrada na string '$mystring'";
		return antiInjection(htmlspecialchars($data,ENT_QUOTES | ENT_HTML401,$encoding));
	} else {
		// return vazio porque a palavra script foi encontrada
		return "";
	}
}

function xecho($data)
{
	echo xssafe($data);
}
?>