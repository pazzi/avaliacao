<?php
/* Embrapa - Empresa Brasileira de Pesquisa Agropecu�ria
 * Embrapa Meio Ambiente 
 * Autor: Cl�udia Vaz Crecci
 * Data: 
 * Autor: Cl�udia Vaz Crecci
 * Data: 04/03/2013
 * Descri��o: tratamento para a tag <br />
 * 
 */
/**
 * @abstract Tratamento de injections em formul�rios.
 * @return string
 */
function antiInjection($str)
{
	// In�cio: tratamento para a tag <br /> - <enter>
	
	/*Este c�digo foi necess�rio porque a fun��o preg_replace abaixo estava tratando o \n e \r, os quais eram substitu�dos por
	por rn, n ou r, dependendo do sistema operacional. Quando o cidad�o digitava <enter> em um campo textarea, por exemplo, 
	os textos ficavam ligados por uma dessas tr�s op��es.*/

	// In�cio: Substitui o <br /> por caracteres em branco
	$order   = array("\r\n", "\n", "\r");
	$replace = ' ';
	$new_str = str_replace($order, $replace, $str);
	// Fim: Substitui o <br /> por caracteres em branco
	

	// Remove v�rias ocorr�ncias de caracteres em branco da string e os converte em espa�os simples
	// C�digo necess�rio para quando o usu�rio digitar v�rios <enter> no campo
	$new_str = preg_replace('/\s+/', ' ', $new_str);
	
	// Fim: tratamento para a tag <br /> - <enter>

	$str = preg_replace(sql_regcase("/(%0a|%0d|Content-Type:|bcc:|to:|cc:|Autoreply:|from|select|insert|delete|where|drop table|show tables|#|\*|--|onmouseover|onclick|prompt|\\\\)/"), "", $new_str);
	$str = trim($str); // Remove espa�os vazios.
	$str = strip_tags($str); // Remove tags HTML e PHP.
	$str = addslashes($str); // Adiciona barras invertidas � uma string.
	$str = mysql_escape_string($str);

	return $str;
}

// Fun��o para tratamento de XSS
function xssafe($data,$encoding='ISO-8859-15')
{
	$mystring = strtoupper($data);
	$findme   = strtoupper('script');
	$pos = strpos($mystring, $findme);

	// Note o uso de ===.  Simples == n�o funcionaria como esperado
	// por causa da posi��o de 'a' � 0 (primeiro) caractere.
	if ($pos === false) {
		//return "A string '$findme' n�o foi encontrada na string '$mystring'";
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