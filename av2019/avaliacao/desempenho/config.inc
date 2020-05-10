<?
/*
 * Formulários para Avaliação de Competências
 * Arquivo de configuracao do sistema
 * Banco de dados utilizados
 * $BD1 = BD usado para sistemas da Unidade
 * $BD2 = Segundo BD usado para sistemas da Unidade
 * Atualização: Cláudia Vaz Crecci
 * Data: 31/01/2020
 * $AGP = Código do Agrupamento da Pesquisa para o ano de referência - utilizado para a exibição dos memoriais dos pesquisadores 
 * para a avaliação do Chefe de P&D em /export1/var_www/html/avaliacao/av2019/avaliacao/desempenho/memorial
 */

$BD1 = "cnpma";
$BD2 = "intranet";
$BD3 = "AvaliacaoDesemp";
$ANO_ANT = 2018;
$ANO_REF = 2019;
$ANO_AVAL = 2020; // Utilizado no /export1/var_www/html/avaliacao/av2019/avaliacao/desempenho/memorial.php
// Utilizados no export1/var_www/html/avaliacao/av2019/avaliacao/desempenho/memorial_pesquisador.php
$AGP = 59; 
$APP = 55; 

/* $VAR_SIST_SEG = "intranet/nosso_ambiente/admin/adm_seg";
 * $VAR_FCS1 = "/var/www/html/intranet";
  $VAR_IMAGEM = "imagens";
  $VAR_PROGS = "intranet/clientes";
  $VAR_EMAIL = "claudia@cnpma.embrapa.br";
  $VAR_RES = "intranet/config/conexao.inc";
  $VAR_WWW = "www.cnpma.embrapa.br";
  include ("$DOCUMENT_ROOT/$VAR_RES");
  include ("$VAR_FCS1/functions.php3"); */

$VAR_FCS1 = "$DOCUMENT_ROOT/intranet/nosso_ambiente/functions.php3";
$VAR_RES = "$DOCUMENT_ROOT/intranet/config/conexao.inc";
$VAR_WWW = "www.cnpma.embrapa.br";

include ("$VAR_RES");
include ("$VAR_FCS1");
?>
