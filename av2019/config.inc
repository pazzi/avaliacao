<?
//
//	Estagio
//	Arquivo de configuracao do sistema
//
//
//	Banco de dados utilizados
//	$BD1 = BD usado para sistemas da Unidade
//	$BD2 = Segundo BD usado para sistemas da Unidade
//	$BD8 = BD onde esta a tabela de instituicoes
//

// Variaveis de Segurança - verificacao do login
//	$VAR_SERVIDOR_SAMBA = Servidor que roda a aplicacao SAMBA
//	$VAR_PGM_SMBCLIENT = Diretorio do servidor samba que contem o programa smbcliente 

#$VAR_SERVIDOR_SAMBA = "rubi";
$VAR_SERVIDOR_SAMBA = "radio2";
$VAR_PGM_SMBCLIENT =  "/usr/local/bin/smbclient";



//
//	Outras Variaveis
//
//	$VAR_SERVIDOR_SAMBA = Servidor que roda a aplicacao SAMBA
//	$VAR_PROGS = Diretorios dos programas
//	$VAR_FCS = Diretorio do arquivo de funcoes utilizada pelo sistema

//	$VAR_IMAGEM = Diretorio das figuras
//	$VAR_FCS1 = Diretorio do arquivo de funcoes utilizada pelo sistema
//	$VAR_EMAIL = Email para cancelamento de reservas
//	$VAR_RES = Diretório de arquivo de conexoes com banco de dados
//	$VAR_SIST_SEG = Diretório onde estah o controle de acessos. 
//

$VAR_SIST_SEG = "intranet/nosso_ambiente/admin/adm_seg";
$VAR_FCS1 = "/usr/local/www/data/intranet/nosso_ambiente/";
$VAR_IMAGEM = "imagens";
$VAR_PROGS = "desenv/avaliacao";
$VAR_EMAIL = "paula.almada@embrapa.br";
$VAR_RES = "intranet/config/conexao.inc";
$VAR_WWW = "www.cnpma.embrapa.br";

include ("$DOCUMENT_ROOT/$VAR_RES");

//Variaveis de programa

//Para 2004 -> $NOTA_INICIAL=1 e $NOTA_FINAL=10
$NOTA_INICIAL=7;
$NOTA_FINAL=14;
?>
