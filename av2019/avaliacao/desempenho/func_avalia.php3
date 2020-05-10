<?
include ("./config.inc");
#include ("$VAR_FCS1/functions.php3");
include ("/usr/local/www/data/intranet/nosso_ambiente/functions.php3");
##############CONSTANTES USADAS NAS ROTINAS######################
###VARIAM ANO A ANO#############################################
$ANO_REF=2019;
$ANO_AVAL=2020;
$MES_AVALIACAO="3";
$NUM_CLIENTES="6";
#Utilizado para desprezar os extremos
$NUM_CLIENTES_DESPR="2";
$RESP_SGP_EMAIL="cnpma.sgp@embrapa.br";
$RESP_SGP_LOGIN1="cristina";
##$RESP_SGP_LOGIN2="carlos";
$RESP_SGP_LOGIN2="paula";
$EXCEPCOES="(304554,321737,353232,351289,336574,335358,356341,350575,294590,353476,335114,349004,353501,350172,260748)"; 
#Numero de questoes dos formularios para os diversos cargos - usados para validar o numero de questoes avaliadas no mod avaliacao
$QUESTOES_AV_COMPLEMENTAR=12;
$LOTACAO="CNPMA";
$CIDADE="Jaguariuna-SP";
$REFERER="http://www.cnpma.embrapa.br/avaliacao/av2019/";

$LOCAL_SERVER="ouro.cnpma.embrapa.br";
$REFERER_SERVER="www.cnpma.embrapa.br";
$AMBIENTE="av2019";


#####FIXAS######################################################
$BD1 = "cnpma";
$BD2 = "intranet";
#$BD3 = "avaliacao";
$BD4 = "AvaliacaoDesemp";
$BD5 = "ponto";
#$BD6 = "AvaliacaoDesempProd";

function cabecalho($ano)
{
echo "<!DOCTYPE html>";
echo "<html lang=\"en\">";
    
echo "<head>";
echo "
    <meta charset=\"ISO-8859-1\">
    <meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">
    <title></title>

    <link rel=\"stylesheet\" href=\"../public/css/bootstrap.min.css\">
    <script src=\"../public/js/bootstrap.min.js\"></script>

</head>
<body>";
}

function XCabecalho()
{
global $VAR_IMAGEM;
global $VAR_WWW;
global $VAR_PROGS;
echo "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\">\n";
echo "<html>\n";
echo "<head>\n";
echo "<title>Bem-vindo ao Avaliação de Competencias</title>";
echo "<META HTTP-EQUIV=\"Content-Type\" CONTENT=\"text/html; charset=ISO-8859-1\">\n";
echo "<META HTTP-EQUIV=\"EXPIRES\" CONTENT=\"0\">\n";
echo "<meta http-equiv=\"Content-Language\" content=\"pt-BR\">\n";
echo "<META NAME=\"RESOURCE-TYPE\" CONTENT=\"DOCUMENT\">\n";
echo "<META NAME=\"DISTRIBUTION\" CONTENT=\"GLOBAL\">\n";
echo "<META NAME=\"REVISIT-AFTER\" CONTENT=\"1 DAYS\">\n";
echo "<META NAME=\"RATING\" CONTENT=\"GENERAL\">\n";
#echo "<LINK REL=\"StyleSheet\" HREF=\"http://www.cnpma.embrapa.br/avaliacao/style.css\" TYPE=\"text/css\">\n";
echo "<link rel=\"stylesheet\" href=\"/avaliacao/bootstrap/css/bootstrap.min.css\">\n";
echo "</head>\n";


#echo "<body class=c_body bgcolor=\"#FFFFFF\" text=\"#000000\" link=\"#035D8A\" vlink=\"#035D8A\" >\n";
echo "<body>\n";

echo "<center><table class=\"table\"><tr class=\"success\">\n";
echo "<td align=\"center\">\n";
echo "<b>A V A L I A Ç Ã O&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;D E&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; C O M P E T E N C I A S&nbsp;&nbsp;</b>\n";
echo "</td>\n";
echo "</tr>\n";
echo "</table></center>";
}


function cabecalho_inter()
{
echo "<center><a href=\><font class=corpo><img src=\"/$VAR_IMAGEM/logomeioambiente.gif\" alt=\"Início - Embrapa Meio Ambiente\" WIDTH=\"530\" HEIGHT=\"85\" border=\"0\"></font></a></center>\n";
echo "<br>\n";
}


function abre_quadro($larg,$cor)
{
echo "<center>\n";
echo  "<table width=\"100%\" border=\"0\" cellspacing=\" $larg \" cellpadding=\"0\" bgcolor=\" $cor\">\n";
echo "   <tr>\n";
echo "     <td>\n";
echo "       <table width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"5\" bgcolor=\"#FFFFFF\">\n";
echo "         <tr>\n";
echo "           <td align=left>\n";

}


function fecha_quadro()
{
echo "           </td>\n";
echo "         </tr>\n";
echo "       </table>\n";
echo "     </td>\n";
echo "   </tr>\n";
echo  "</table>\n";
echo "</center>\n";
}



function rodape()
{
   
echo "<br>\n";
echo "<br>\n";
echo "<center>\n";

echo "<table>\n";
echo "<tr>\n";
echo "<td WIDTH=\"100%\" HEIGHT=\"16\" align=\"center\"><font class=\"tiny\">Copyright \xa9 &nbsp;1997-".date('Y')." Embrapa Meio Ambiente. Todos direitos reservados. Nota Legal.<br> <b>Rodovia SP 340 - Km 127,5&nbsp;&nbsp; Caixa
Postal 69 &nbsp;&nbsp;Fone (0xx19)3311.2700<br> Cep 13820-000, Jaguari\xfana, SP</b></font>\n";
echo "</td>\n";
echo "</tr>\n";
echo "</table>\n";
echo "</center>\n";

echo"
<script src=\"./public/js/jquery.min.js\"></script>
<script src=\"./public/js/bootstrap.min.js\"></script>
<script src=\"./public/js/metisMenu.min.js\"></script>
<script src=\"./public/js/sb-admin-2.js\"></script>
";
      

echo "</body>\n";
echo "</html>\n";



}


function verifica_entrada($ano,$periodo,$matr_or)
{
global $BD4;

$res_verif=sql($BD4,"select notas.id from notas,avalia where avalia.id=notas.id_avalia and avalia.ano='$ano' and avalia.periodo='$periodo' and avalia.matr_or='$matr_or';");


   if (mysql_num_rows($res_verif)==0)
      {
        $res_incl=sql($BD4,"select id from avalia where ano='$ano' and periodo='$periodo' and matr_or='$matr_or';");
        while ($lista_res_incl=mysql_fetch_row($res_incl))
          {
            $res_perg=sql($BD4,"select id from perguntas where ano='$ano' and periodo='$periodo' ;");
           
              while ($lista=mysql_fetch_row($res_perg))
               {
                 $sql_string="insert into notas values('','".$lista_res_incl[0]."','".$lista[0]."','0');";

                 sql($BD4,$sql_string);
                }
           }

      }
}


function calc_per()
{

$mes=date(n);

if ($mes <=6)
    {
     //return 1;
     return 0;
    }
     else
          {
           //return 2;
           return 0;
          }

}

function busca_ano()
{
 //Retorna o ano referente a avaliacao
 return 2005;
}


function cor($num)
{
 switch($num)
 {
/*
   case 7:
   case 8:
           return "#ff3300";
           break;
*/  
   case 7:
   case 8:
           return "#cccc66";
           break;
  
   case 9: 
   case 10:
           return "#ffff00";
           break;
  
   case 11:
   case 12:
           return "#00ccff";
           break;
  
   case 13:
   case 14:
           return "#33ff00";
           break;
  
 }
}

function conv_4($rec)
{
#return (number_format($rec,4,',','.'));
return (substr($rec,0,6));
#return (round($rec,4));
} 


function verifica_ferias($matr,$mes,$ano)
 {
    global $BD5;
$hoje=date(Y)."-".date(m)."-".date(d);
$fim="2011-04-30";

    $str_sql="SELECT lic_ferias.dia_ini, lic_ferias.dia_fim, descr_alter.alteracao
                FROM lic_ferias, cnpma.empregados, descr_alter
                WHERE lic_ferias.matr ='$matr'
                AND descr_alter.tipo = '2'
                AND lic_ferias.motivo NOT IN ('41', '16', '43', '35', '40', '50', '51')
        #       AND ((MONTH( lic_ferias.dia_ini ) = '$mes' AND YEAR( lic_ferias.dia_ini ) = '$ano')
                AND ((lic_ferias.dia_ini ) <= '$fim')
                AND ((lic_ferias.dia_fim ) >= '$fim')
        #       AND (MONTH(lic_ferias.dia_fim ) = '03')
        #       OR (MONTH( lic_ferias.dia_fim ) = '$mes' AND YEAR( lic_ferias.dia_fim ) = '$ano'))
                AND lic_ferias.motivo = descr_alter.id";
   $res_str_sql=sql($BD5,$str_sql);
   $num_reg=mysql_num_rows($res_str_sql);
   if ($num_reg >= 1)
    {
       while ($lis=mysql_fetch_row($res_str_sql))
            {
             $str_res_dia_ini=$lis[0];
             $str_res_dia_fim=$lis[1];
             $str_res_descr=$lis[2];
             $str_retorna=$str_res_dia_ini.":::".$str_res_dia_fim.":::".$str_res_descr;
            }
    }
      else
           {
             $str_retorna=0;
           }
   return($str_retorna);
}

function verifica_matr_avaliador($matr,$ANO_REF)
  {
   global $BD4;
   $str_sql="SELECT count(matr_or) as quant FROM escolha
                                   WHERE ano='$ANO_REF'
                                   AND matr_or='$matr'
                                   AND status='e'";
    $res_str_sql=sql($BD4,$str_sql);
    $ret=mysql_result($res_str_sql,0,"quant");
    return $ret; 
  }

function verifica_comissionado($matr,$ANO_REF)
  {
   global $BD4;
   $str_sql="SELECT matr FROM comissionados 
                                   WHERE ano='$ANO_REF'
                                   AND matr='$matr'";
    $res_str_sql=sql($BD4,$str_sql);
    $num_reg=mysql_num_rows($res_str_sql);
    if ($num_reg >= 1)
       {
         $ret=1;
       } 
        else
            {
              $ret=0;
            }
    return $ret; 
  }


function verifica_matr_avaliador_avaliado($matr_da,$matr_or,$ANO_REF)
  {
   global $BD4;
   $str_sql="SELECT * FROM escolha
                                   WHERE ano='$ANO_REF'
                                   AND matr_da='$matr_da'
                                   AND matr_or='$matr_or'
                                   AND status='e'";
    $res_str_sql=sql($BD4,$str_sql);
    $ret=mysql_num_rows($res_str_sql);
    return $ret; 
  }

function verifica_fone($matr)
  {
   global $BD1;
   $str_sql="SELECT ramal1 FROM ramais
                                   WHERE matr='$matr'";
    $res_str_sql=sql($BD1,$str_sql);
    $ret=mysql_result($res_str_sql,0,"ramal1");
    return $ret; 

  }




function lista_nome($matr)
{
 $str_sql="SELECT nome
                  FROM cnpma.empregados
                  WHERE cnpma.empregados.matr='$matr'"; 

   $res_str_sql=sql($BD1,$str_sql);
   $num_reg=mysql_num_rows($res_str_sql);
   if ($num_reg >= 1)
    {
       while ($lis=mysql_fetch_row($res_str_sql))
            {
             $str_retorna=$lis[0];
            }
    }
      else
           {
             $str_retorna="Nao definido"; 
           }
   return($str_retorna); 
}
 
function busca_medias($codigo_aval,$matr,$ANO_BASE)
{
$str_rec="SELECT $BD4.Pesq_Satisfacao_Resp_Item.cod_pesq_satisfacao,
                     AVG($BD4.Pesq_Satisfacao_Resp_Item.cod_tipo_resposta),
                     $BD4.Pesq_Satisfacao_Resp_Item.cod_pergunta
                FROM $BD4.Pesq_Satisfacao_Resp_Item
                   WHERE $BD4.Pesq_Satisfacao_Resp_Item.codigo_pesquisa IN
                       (SELECT $BD4.Pesquisa_Opiniao.codigo_pesquisa
                             FROM $BD4.Pesquisa_Opiniao
                             WHERE $BD4.Pesquisa_Opiniao.ano_pesq='$ANO_BASE'
                             AND $BD4.Pesquisa_Opiniao.codigo_aval='$codigo_aval'
                             AND $BD4.Pesquisa_Opiniao.matricula IN
                                                                   (SELECT cnpma.empregados.matr
                                                                           FROM cnpma.empregados
                                                                           WHERE cnpma.empregados.tipo='e'
                                                                           AND cnpma.empregados.situacao='a'
                                                                           AND cnpma.empregados.matr='$matr'))
                   AND $BD4.Pesq_Satisfacao_Resp_Item.cod_tipo_resposta<>'5'
                   GROUP BY  $BD4.Pesq_Satisfacao_Resp_Item.cod_pesq_satisfacao";
     
return($str_rec);
}

function busca_medias_competencia($codigo_aval,$matr,$ano_base)
{
$str_rec="SELECT $BD4.Pesq_Satisfacao_Resp_Item.cod_pergunta,
                     AVG($BD4.Pesq_Satisfacao_Resp_Item.cod_tipo_resposta)
                   FROM $BD4.Pesq_Satisfacao_Resp_Item
                   WHERE $BD4.Pesq_Satisfacao_Resp_Item.codigo_pesquisa IN
                       (SELECT $BD4.Pesquisa_Opiniao.codigo_pesquisa
                             FROM $BD4.Pesquisa_Opiniao
                             WHERE $BD4.Pesquisa_Opiniao.ano_pesq='$ano_base'
                             AND $BD4.Pesquisa_Opiniao.codigo_aval='$codigo_aval'
                             AND $BD4.Pesquisa_Opiniao.matricula IN
                                                                   (SELECT cnpma.empregados.matr
                                                                           FROM cnpma.empregados
                                                                           WHERE cnpma.empregados.tipo='e'
                                                                           AND cnpma.empregados.situacao='a'
                                                                           AND cnpma.empregados.matr='$matr'))
                   AND $BD4.Pesq_Satisfacao_Resp_Item.cod_tipo_resposta<>'5'
                   GROUP BY  $BD4.Pesq_Satisfacao_Resp_Item.cod_pergunta";
     
return($str_rec);
}

function busca_pares($codigo_aval,$matr,$ANO_BASE)
{
$str_rec="SELECT $BD4.Pesq_Satisfacao_Resp_Item.cod_pesq_satisfacao,
                     $BD4.Pesq_Satisfacao_Resp_Item.cod_tipo_resposta,
                     $BD4.Pesq_Satisfacao_Resp_Item.cod_pergunta,
                     $BD4.Pesq_Satisfacao_Resp_Item.codigo_pesquisa
                FROM $BD4.Pesq_Satisfacao_Resp_Item
                   WHERE $BD4.Pesq_Satisfacao_Resp_Item.codigo_pesquisa IN
                       (SELECT $BD4.Pesquisa_Opiniao.codigo_pesquisa
                             FROM $BD4.Pesquisa_Opiniao
                             WHERE $BD4.Pesquisa_Opiniao.ano_pesq='$ANO_BASE'
                             AND $BD4.Pesquisa_Opiniao.codigo_aval='$codigo_aval'
                             AND $BD4.Pesquisa_Opiniao.matricula IN
                                                                   (SELECT cnpma.empregados.matr
                                                                           FROM cnpma.empregados
                                                                           WHERE cnpma.empregados.tipo='e'
                                                                           AND cnpma.empregados.situacao='a'
                                                                           AND cnpma.empregados.matr='$matr'))
                   AND $BD4.Pesq_Satisfacao_Resp_Item.cod_tipo_resposta<>'5'";
     
return($str_rec);
}

function busca_medias_competencia_pares($codigo_aval,$matr,$ANO_BASE)
{
$str_rec="SELECT $BD4.Pesq_Satisfacao_Resp_Item.cod_pergunta,
                     AVG($BD4.Pesq_Satisfacao_Resp_Item.cod_tipo_resposta)
                FROM $BD4.Pesq_Satisfacao_Resp_Item
                   WHERE $BD4.Pesq_Satisfacao_Resp_Item.codigo_pesquisa IN
                       (SELECT $BD4.Pesquisa_Opiniao.codigo_pesquisa
                             FROM $BD4.Pesquisa_Opiniao
                             WHERE $BD4.Pesquisa_Opiniao.ano_pesq='$ANO_BASE'
                             AND $BD4.Pesquisa_Opiniao.codigo_aval='$codigo_aval'
                             AND $BD4.Pesquisa_Opiniao.matricula IN
                                                                   (SELECT cnpma.empregados.matr
                                                                           FROM cnpma.empregados
                                                                           WHERE cnpma.empregados.tipo='e'
                                                                           AND cnpma.empregados.situacao='a'
                                                                           AND cnpma.empregados.matr='$matr'))
                   AND $BD4.Pesq_Satisfacao_Resp_Item.cod_tipo_resposta<>'5'
       		GROUP BY  $BD4.Pesq_Satisfacao_Resp_Item.cod_pesq_satisfacao";
   
return($str_rec);
}

function retorna_texto($id)
{
 global $BD4;
  $str_sql_perg="SELECT desc_pergunta_satisf
                                FROM Pesquisa_Satisfacao_Perguntas
                                WHERE Pesquisa_Satisfacao_Perguntas.cod_pesq_satisfacao='$id'";
          $rec_str_perg=sql($BD4,$str_sql_perg);
          $retorno= mysql_result($rec_str_perg,0,"desc_pergunta_satisf");
          return($retorno);
 
}

function retorna_texto_competencia($id)
{
 global $BD4;
  $str_sql_perg="SELECT desc_pergunta
                                FROM Pesquisa_Perguntas
                                WHERE Pesquisa_Perguntas.cod_pergunta='$id'";
          $rec_str_perg=sql($BD4,$str_sql_perg);
          $retorno= mysql_result($rec_str_perg,0,"desc_pergunta");
          return($retorno);
 
}


#FUNCOES ESTATISITICAS
function estat_medias($tipo_cliente,$codigo_aval,$ANO_BASE)
{
 global $BD4;
 $str_ret="SELECT Pesq_Satisfacao_Resp_Item.cod_pesq_satisfacao,
                  AVG(Pesq_Satisfacao_Resp_Item.cod_tipo_resposta)
             FROM Pesq_Satisfacao_Resp_Item,Pesquisa_Opiniao
             WHERE Pesquisa_Opiniao.codigo_pesquisa=Pesq_Satisfacao_Resp_Item.codigo_pesquisa
             AND Pesquisa_Opiniao.tipo_cliente='$tipo_cliente'
             AND Pesquisa_Opiniao.codigo_aval='$codigo_aval'
             AND Pesq_Satisfacao_Resp_Item.cod_tipo_resposta<>'5'
             AND Pesquisa_Opiniao.ano_pesq='$ANO_BASE'
             GROUP BY Pesq_Satisfacao_Resp_Item.cod_pesq_satisfacao";
$ret=sql($BD4,$str_ret);
return($ret);
}

function estat_geral_por_tipo_cliente($tipo_cliente,$ANO_BASE)
{
 global $BD4;
 $str_ret="SELECT Pesq_Satisfacao_Resp_Item.cod_pesq_satisfacao,
                 AVG(Pesq_Satisfacao_Resp_Item.cod_tipo_resposta)
                 FROM Pesq_Satisfacao_Resp_Item,Pesquisa_Opiniao
                 WHERE Pesq_Satisfacao_Resp_Item.cod_tipo_resposta<>'5'
                 AND Pesq_Satisfacao_Resp_Item.codigo_pesquisa=Pesquisa_Opiniao.codigo_pesquisa
                 AND Pesquisa_Opiniao.tipo_cliente='0'
                 AND Pesquisa_Opiniao.ano_pesq='$ANO_BASE'
                 GROUP BY Pesq_Satisfacao_Resp_Item.cod_pesq_satisfacao";
$ret=sql($BD4,$str_ret);
return($ret);
}

function estat_geral_geral($ANO_BASE)
{
 global $BD4;
 $str_ret="SELECT Pesq_Satisfacao_Resp_Item.cod_pesq_satisfacao,
                 AVG(Pesq_Satisfacao_Resp_Item.cod_tipo_resposta)
          FROM Pesq_Satisfacao_Resp_Item,Pesquisa_Opiniao
          WHERE Pesq_Satisfacao_Resp_Item.cod_tipo_resposta<>'5'
          AND Pesq_Satisfacao_Resp_Item.codigo_pesquisa=Pesquisa_Opiniao.codigo_pesquisa
          AND Pesquisa_Opiniao.ano_pesq='$ANO_BASE'
          GROUP BY Pesq_Satisfacao_Resp_Item.cod_pesq_satisfacao";
 $ret=sql($BD4,$str_ret);
 return($ret);
}

function busca_notas_por_formulario($codigo_aval,$matr,$ano_base)
{

$str_rec="SELECT TBL.A1,AVG(TBL.A3) AS B1  FROM
                   (SELECT $BD4.Pesq_Satisfacao_Resp_Item.codigo_pesquisa AS A1,$BD4.Pesq_Satisfacao_Resp_Item.cod_pergunta AS A2,
                   AVG($BD4.Pesq_Satisfacao_Resp_Item.cod_tipo_resposta) AS A3
                   FROM $BD4.Pesq_Satisfacao_Resp_Item
                   WHERE $BD4.Pesq_Satisfacao_Resp_Item.codigo_pesquisa IN
                       (SELECT $BD4.Pesquisa_Opiniao.codigo_pesquisa
                             FROM $BD4.Pesquisa_Opiniao
                             WHERE $BD4.Pesquisa_Opiniao.ano_pesq='$ano_base'
                             AND $BD4.Pesquisa_Opiniao.codigo_aval='$codigo_aval'
                             AND $BD4.Pesquisa_Opiniao.matricula IN
                                                                   (SELECT cnpma.empregados.matr
                                                                           FROM cnpma.empregados
                                                                           WHERE cnpma.empregados.tipo='e'
                                                                           AND cnpma.empregados.situacao='a'
                                                                           AND cnpma.empregados.matr='$matr'))
                   AND $BD4.Pesq_Satisfacao_Resp_Item.cod_tipo_resposta<>'5'
                   GROUP BY $BD4.Pesq_Satisfacao_Resp_Item.codigo_pesquisa, $BD4.Pesq_Satisfacao_Resp_Item.cod_pergunta) AS TBL
          GROUP BY TBL.A1 ORDER BY B1";

return($str_rec);
}

function ver_escala($num)
   {
    switch ($num)
       {
         case 1:
                $ret=" - Nao Apresenta";
                break;
         case 2:
                $ret=" - Apresenta Parcialmente";
                break;
         case 3:
                $ret=" - Apresenta Plenamente";
                break;
         case 4:
                $ret=" - Destaca-se";
                break;
       }
    return ($ret);
   }

function busca_media_por_codigo($codigo_aval)
{
$str_rec="SELECT $BD4.Pesq_Satisfacao_Resp_Item.cod_pesq_satisfacao,
                     AVG($BD4.Pesq_Satisfacao_Resp_Item.cod_tipo_resposta),
                     $BD4.Pesq_Satisfacao_Resp_Item.cod_pergunta
                     FROM $BD4.Pesq_Satisfacao_Resp_Item
                     WHERE $BD4.Pesq_Satisfacao_Resp_Item.codigo_pesquisa='$codigo_aval'
		     AND $BD4.Pesq_Satisfacao_Resp_Item.cod_tipo_resposta<>'5'
                     GROUP BY  $BD4.Pesq_Satisfacao_Resp_Item.cod_pesq_satisfacao";

return($str_rec);
}


function busca_medias_competencia_por_codigo($codigo_aval)
{
$str_rec="SELECT $BD4.Pesq_Satisfacao_Resp_Item.cod_pergunta,
                     AVG($BD4.Pesq_Satisfacao_Resp_Item.cod_tipo_resposta)
                     FROM $BD4.Pesq_Satisfacao_Resp_Item
                     WHERE $BD4.Pesq_Satisfacao_Resp_Item.codigo_pesquisa='$codigo_aval' 
                     AND $BD4.Pesq_Satisfacao_Resp_Item.cod_tipo_resposta<>'5'
                     GROUP BY  $BD4.Pesq_Satisfacao_Resp_Item.cod_pergunta";

return($str_rec);
}

function nome_agrupamento($codigo_agrupamento)
	{
		GLOBAL $BD4;
		$str_sql="select descricao from Agrupamento where cod_agrupamento='$codigo_agrupamento'";
		$ret=sql($BD4,$str_sql);
		$nome=mysql_result($ret,0,"descricao");
		return($nome);
	}

function busca_memorial($codigo){

                GLOBAL $BD4;
                $str_sql="select desc_memorial from Memorial where codigo_pesquisa='$codigo'";
                $ret=sql($BD4,$str_sql);
                $nome=mysql_result($ret,0,"desc_memorial");
                if (strlen(trim($nome)) == 0)
                        {
                                return(0);
                        } else {
                                        return(1);
                                }
}

function obtem_nfi($agrup, $id_fonte)
        {
                        global $BD4;
                        $str_sql_nfi="SELECT $BD4.z_indicador.peso, $BD4.z_itens.peso
                                        FROM $BD4.z_indicador, $BD4.z_itens
                                        WHERE $BD4.z_indicador.cod_agrupamento='$agrup'
                                        AND $BD4.z_indicador.id=$BD4.z_itens.id_indicador
                                        AND $BD4.z_itens.id_fonte='$id_fonte'";
                                        $res_nfi=sql($BD4, $str_sql_nfi);
                                        $peso_indic= mysql_result($res_nfi,0,0);
                                        $peso_fonte= mysql_result($res_nfi,0,1);
                                        return $peso_indic*$peso_fonte/10000;
        }


?>
