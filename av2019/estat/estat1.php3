<?php
include ("../../func_avalia.php3");
cabecalho();

function le_empregados()
{
 global $BD1;
 $sql_matr="select matr,nome from empregados where tipo='e' and situacao='a' order by nome";
 $ret=sql($BD1,$sql_matr);
 return($ret);
}

function busca_itens($ANO_REF)
{

$str_rec= "SELECT AvaliacaoComp.Pesq_Satisfacao_Resp_Item.cod_tipo_resposta AS A2,
                           COUNT(AvaliacaoComp.Pesq_Satisfacao_Resp_Item.cod_tipo_resposta) AS A3
                           FROM AvaliacaoComp.Pesq_Satisfacao_Resp_Item
                           WHERE AvaliacaoComp.Pesq_Satisfacao_Resp_Item.codigo_pesquisa IN
                                           (SELECT AvaliacaoComp.Pesquisa_Opiniao_Clientes2006.codigo_pesquisa
                                                      FROM AvaliacaoComp.Pesquisa_Opiniao_Clientes2006
                                                      WHERE AvaliacaoComp.Pesquisa_Opiniao_Clientes2006.ano_pesq='$ANO_REF')
                          AND AvaliacaoComp.Pesq_Satisfacao_Resp_Item.cod_tipo_resposta<>'5'
                          GROUP BY  AvaliacaoComp.Pesq_Satisfacao_Resp_Item.cod_tipo_resposta";

return($str_rec);
}

function busca_estat_geral($ANO_REF)
{

$str_rec= "SELECT AvaliacaoComp.Pesq_Satisfacao_Resp_Item.cod_pergunta AS A2,
                           AVG(AvaliacaoComp.Pesq_Satisfacao_Resp_Item.cod_tipo_resposta) AS A3
                           FROM AvaliacaoComp.Pesq_Satisfacao_Resp_Item
                           WHERE AvaliacaoComp.Pesq_Satisfacao_Resp_Item.codigo_pesquisa IN
                                           (SELECT AvaliacaoComp.Pesquisa_Opiniao_Clientes2006.codigo_pesquisa
                                                      FROM AvaliacaoComp.Pesquisa_Opiniao_Clientes2006
                                                      WHERE AvaliacaoComp.Pesquisa_Opiniao_Clientes2006.ano_pesq='$ANO_REF')
                          AND AvaliacaoComp.Pesq_Satisfacao_Resp_Item.cod_tipo_resposta<>'5'
                          GROUP BY  AvaliacaoComp.Pesq_Satisfacao_Resp_Item.cod_pergunta";

return($str_rec);
}

function busca_estat($codigo_aval,$ANO_REF)
{

$str_rec= "SELECT AvaliacaoComp.Pesq_Satisfacao_Resp_Item.cod_pergunta AS A2,
                           AVG(AvaliacaoComp.Pesq_Satisfacao_Resp_Item.cod_tipo_resposta) AS A3
                           FROM AvaliacaoComp.Pesq_Satisfacao_Resp_Item
                           WHERE AvaliacaoComp.Pesq_Satisfacao_Resp_Item.codigo_pesquisa IN
                                           (SELECT AvaliacaoComp.Pesquisa_Opiniao_Clientes2006.codigo_pesquisa
                                                      FROM AvaliacaoComp.Pesquisa_Opiniao_Clientes2006
                                                      WHERE AvaliacaoComp.Pesquisa_Opiniao_Clientes2006.ano_pesq='$ANO_REF'
                                                      AND AvaliacaoComp.Pesquisa_Opiniao_Clientes2006.codigo_aval='$codigo_aval')
                          AND AvaliacaoComp.Pesq_Satisfacao_Resp_Item.cod_tipo_resposta<>'5'
                          GROUP BY  AvaliacaoComp.Pesq_Satisfacao_Resp_Item.cod_pergunta";

return($str_rec);
}

function busca_estat_agrup($codigo_aval,$ANOO_REF,$agrup_saad)
{

$str_rec= "SELECT AvaliacaoComp.Pesq_Satisfacao_Resp_Item.cod_pergunta AS A2,
                           AVG(AvaliacaoComp.Pesq_Satisfacao_Resp_Item.cod_tipo_resposta) AS A3
                           FROM AvaliacaoComp.Pesq_Satisfacao_Resp_Item
                           WHERE AvaliacaoComp.Pesq_Satisfacao_Resp_Item.codigo_pesquisa IN
                                           (SELECT AvaliacaoComp.Pesquisa_Opiniao_Clientes2006.codigo_pesquisa
                                                      FROM AvaliacaoComp.Pesquisa_Opiniao_Clientes2006,avaliacao.2010_elegiveis
                                                      WHERE AvaliacaoComp.Pesquisa_Opiniao_Clientes2006.ano_pesq='$ANO_REF'
                                                      AND AvaliacaoComp.Pesquisa_Opiniao_Clientes2006.codigo_aval='$codigo_aval'
                                                      AND AvaliacaoComp.Pesquisa_Opiniao_Clientes2006.matricula=avaliacao.2010_elegiveis.matr
                                                      AND avaliacao.2010_elegiveis.agrup_saad='$agrup_saad')
                          AND AvaliacaoComp.Pesq_Satisfacao_Resp_Item.cod_tipo_resposta<>'5'
                          GROUP BY  AvaliacaoComp.Pesq_Satisfacao_Resp_Item.cod_pergunta";

return($str_rec);
}


 $str_ret="select distinct ano_pesq from Pesquisa_Opiniao_Clientes2006";
 $ret=sql($BD4,$str_ret);
echo "<table border=1>";
echo "<tr><td colspan=10 align=\"center\"><b>Resultados Gerais de Avaliacoes</b></td></tr>";
echo "<tr>";
echo "<td>";
echo "Ano";
echo "</td>";
for ($i=1; $i<=9; $i++)
      {
        echo "<td>";
        echo retorna_texto_competencia($i);
        echo "</td>";
     } 
echo "</tr>";
       
 while ($lista=mysql_fetch_row($ret))
  {
          $str_ret=busca_estat_geral($lista[0]);
          $ret1=sql($BD4,$str_ret);
           echo "<tr>";
           echo "<td align=\"left\">";
           $valor= str_replace(".",",",$lista[0]);
           echo $valor;
           echo "</td>";
          while ($lista1=mysql_fetch_row($ret1))
                {
                 echo "<td align=\"center\">";  
                 echo $lista1[1];  
                 echo "</td>";  
                }
           echo "</tr>";
  }
 
 $str_ret="select distinct ano_pesq from Pesquisa_Opiniao_Clientes2006";
 $ret=sql($BD4,$str_ret);
echo "<tr><td colspan=10 align=\"center\"><b>Resultados Gerais Avaliacoes Supervisores</b></td></tr>";
echo "<tr>";
echo "<td>";
echo "Ano";
echo "</td>";
for ($i=1; $i<=9; $i++)
      {
        echo "<td>";
        echo retorna_texto_competencia($i);
        echo "</td>";
     } 
echo "</tr>";
       
 while ($lista=mysql_fetch_row($ret))
  {
          $str_ret=busca_estat(1,$lista[0]);
          $ret1=sql($BD4,$str_ret);
           echo "<tr>";
           echo "<td align=\"left\">";
           echo $lista[0];
           echo "</td>";
          while ($lista1=mysql_fetch_row($ret1))
                {
                 echo "<td align=\"center\">";  
                 echo $lista1[1];  
                 echo "</td>";  
                }
           echo "</tr>";
  }

echo "<tr><td colspan=10 align=\"center\"><b>Resultados Gerais Avaliacoes Clientes/Pares</b></td></tr>";
echo "<tr>";
echo "<td>";
echo "Ano";
echo "</td>";
for ($i=1; $i<=9; $i++)
      {
        echo "<td>";
        echo retorna_texto_competencia($i);
        echo "</td>";
     } 
echo "</tr>";
       
 $str_ret="select distinct ano_pesq from Pesquisa_Opiniao_Clientes2006";
 $ret=sql($BD4,$str_ret);

 while ($lista=mysql_fetch_row($ret))
  {
          $str_ret=busca_estat(3,$lista[0]);
          $ret1=sql($BD4,$str_ret);
           echo "<tr>";
           echo "<td align=\"left\">";
           echo $lista[0];
           echo "</td>";
          while ($lista1=mysql_fetch_row($ret1))
                {
                 echo "<td align=\"center\">";  
                 echo $lista1[1];  
                 echo "</td>";  
                }
           echo "</tr>";
  }

echo "<tr><td colspan=10 align=\"center\"><b>Resultados avaliacao de supervisores por agrupamento</b></td></tr>";

 $str_ret="select distinct ano_pesq from Pesquisa_Opiniao_Clientes2006";
 $ret=sql($BD4,$str_ret);
 while ($lista=mysql_fetch_row($ret))
  {

          $str_agrup="select distinct agrup_saad, cnpma.agrupamento_saad.texto from avaliacao.elegiveis, cnpma.agrupamento_saad
                       where avaliacao.elegiveis.agrup_saad<>'0'
                       and cnpma.agrupamento_saad.id=avaliacao.elegiveis.agrup_saad
                       and cnpma.agrupamento_saad.ano='$ANO_REF'
                       order by avaliacao.elegiveis.agrup_saad";
           $res_agrup=sql($BD3,$str_agrup);
           while($lis_agrup=mysql_fetch_row($res_agrup))
           {
           echo "<tr>";

           echo "<td align=\"left\">";
           echo "$lista[0]-Agrupamento:$lis_agrup[1]";
           echo "</td>";

           $str_ret=busca_estat_agrup(1,$lista[0],$lis_agrup[0]);
           $ret_agrup=sql($BD4,$str_ret);

           while ($lista1=mysql_fetch_row($ret_agrup))
                {
                 echo "<td align=\"center\">";  
                 echo $lista1[1];  
                 echo "</td>";  
                }
           echo "</tr>";
          }
  }

echo "<tr><td colspan=10 align=\"center\"><b>Resultados avaliacao de pares/clientes por agrupamento</b></td></tr>";

 $str_ret="select distinct ano_pesq from Pesquisa_Opiniao_Clientes2006";
 $ret=sql($BD4,$str_ret);
 while ($lista=mysql_fetch_row($ret))
  {

          $str_agrup="select distinct agrup_saad, cnpma.agrupamento_saad.texto from avaliacao.elegiveis, cnpma.agrupamento_saad
                       where avaliacao.elegiveis.agrup_saad<>'0'
                       and cnpma.agrupamento_saad.id=avaliacao.agrup_saad
                       and cnpma.agrupamento_saad.ano='$ANO_REF'
                       order by avaliacao.2010_elegiveis.agrup_saad";
           $res_agrup=sql($BD3,$str_agrup);
           while($lis_agrup=mysql_fetch_row($res_agrup))
           {
           echo "<tr>";

           echo "<td align=\"left\">";
           echo "$lista[0]-Agrupamento:$lis_agrup[1]";
           echo "</td>";

           $str_ret=busca_estat_agrup(3,$lista[0],$lis_agrup[0]);
           $ret_agrup=sql($BD4,$str_ret);

           while ($lista1=mysql_fetch_row($ret_agrup))
                {
                 echo "<td align=\"center\">";  
                 echo $lista1[1];  
                 echo "</td>";  
                }
           echo "</tr>";
        }
  }


echo "</table>";





$str_ret="select distinct ano_pesq from Pesquisa_Opiniao_Clientes2006";
 $ret=sql($BD4,$str_ret);
echo "<table border=1>";
echo "<tr><td colspan=4 align=\"center\"><b>Resultados Gerais por escala</b></td></tr>";
echo "<tr>";
echo "<td>";
echo "Ano";
echo "</td>";
for ($i=1; $i<=4; $i++)
      {
        echo "<td>";
        switch ($i)
         {
           case 1:echo "Nao apresenta";
                  break;
           case 2:echo "Apresenta parcialmente";
                  break;
           case 3:echo "Apresenta plenamente";
                  break;
           case 4:echo "Supera";
                  break;
         }
        echo "</td>";
     }
echo "</tr>";


 while ($lista=mysql_fetch_row($ret))
  {
          $str_ret=busca_itens($lista[0]);
          $ret1=sql($BD4,$str_ret);
           echo "<tr>";
           echo "<td align=\"left\">";
           echo $lista[0];
           echo "</td>";
          while ($lista1=mysql_fetch_row($ret1))
                {
                 echo "<td align=\"center\">"; 
                 echo $lista1[1]; 
                 echo "</td>"; 
                }
           echo "</tr>";
  }






/*
$str_ret="SELECT Pesq_Satisfacao_Resp_Item.cod_pesq_satisfacao,
          MIN(Pesq_Satisfacao_Resp_Item.cod_tipo_resposta)
          FROM Pesq_Satisfacao_Resp_Item,Pesquisa_Opiniao_Clientes2006
          WHERE Pesq_Satisfacao_Resp_Item.cod_tipo_resposta<>'5'
          AND Pesquisa_Opiniao_Clientes2006.ano_pesq='$ANO_REF'
          AND Pesq_Satisfacao_Resp_Item.codigo_pesquisa=Pesquisa_Opiniao_Clientes2006.codigo_pesquisa
          GROUP BY Pesq_Satisfacao_Resp_Item.cod_pesq_satisfacao";
$ret=sql($BD4,$str_ret);
while ($lista=mysql_fetch_row($ret))
{
          echo $lista[0];
          echo "-";
          echo retorna_texto($lista[0]);
          echo $lista[1];
     echo "<br>";
}


echo "<br>";
echo "<br>";

$str_ret="SELECT Pesq_Satisfacao_Resp_Item.cod_pesq_satisfacao,
          MAX(Pesq_Satisfacao_Resp_Item.cod_tipo_resposta)
          FROM Pesq_Satisfacao_Resp_Item,Pesquisa_Opiniao_Clientes2006
          WHERE Pesq_Satisfacao_Resp_Item.cod_tipo_resposta<>'5'
          AND Pesquisa_Opiniao_Clientes2006.ano_pesq='$ANO_REF'
          AND Pesq_Satisfacao_Resp_Item.codigo_pesquisa=Pesquisa_Opiniao_Clientes2006.codigo_pesquisa
          GROUP BY Pesq_Satisfacao_Resp_Item.cod_pesq_satisfacao";
$ret=sql($BD4,$str_ret);
while ($lista=mysql_fetch_row($ret))
{
          echo $lista[0];
          echo "-";
          echo retorna_texto($lista[0]);
          echo $lista[1];
     echo "<br>";
}

echo "<br>";
echo "<br>";

$str_ret="SELECT Pesq_Satisfacao_Resp_Item.cod_tipo_resposta,
          count(Pesq_Satisfacao_Resp_Item.cod_tipo_resposta)
          FROM Pesq_Satisfacao_Resp_Item,Pesquisa_Opiniao_Clientes2006
#          WHERE Pesq_Satisfacao_Resp_Item.cod_tipo_resposta<>'5'
          WHERE Pesquisa_Opiniao_Clientes2006.ano_pesq='$ANO_REF'
          AND Pesq_Satisfacao_Resp_Item.codigo_pesquisa=Pesquisa_Opiniao_Clientes2006.codigo_pesquisa
          GROUP BY Pesq_Satisfacao_Resp_Item.cod_tipo_resposta";
$ret=sql($BD4,$str_ret);
while ($lista=mysql_fetch_row($ret))
{
          echo $lista[0];
          echo "-";
#          echo retorna_texto($lista[0]);
          echo $lista[1];
     echo "<br>";
}

echo "<br>";
echo "<br>";

echo "<center><font class=\"title\"><u>A v a l i a c a o  - 2 0 0 9 - A n o &nbsp;&nbsp; B a s e  - 2 0 0 8</u></font></center>";

echo "<table border=1>";
echo "<tr>";
echo "<td>";
echo "Competencia";
echo "</td>";
echo "<td>";
echo "Geral";
echo "</td>";
echo "<td>";
echo "Geral-Assist.A";
echo "</td>";
echo "<td>";
echo "Geral-Assist.B/C";
echo "</td>";
echo "<td>";
echo "Geral-An/Pesq";
echo "</td>";
echo "<td>";
echo "Supervisor";
echo "</td>";
echo "<td>";
echo "Autoavaliacao";
echo "</td>";
echo "<td>";
echo "Pares";
echo "</td>";
echo "</tr>";
echo "<tr>";
echo "<td>";

echo "<table>";
for ($i=1; $i<=38; $i++)
    {
     echo "<tr>";
     echo "<td>";
     $msg=retorna_texto($i);
     echo $msg;
     echo "</td>";
     echo "</tr>";
    }
echo "</table>";

echo "</td>";
echo "<td valign=\"top\">";


echo "<table>";

$str_ret="SELECT Pesq_Satisfacao_Resp_Item.cod_pesq_satisfacao,
                 AVG(Pesq_Satisfacao_Resp_Item.cod_tipo_resposta)
          FROM Pesq_Satisfacao_Resp_Item,Pesquisa_Opiniao_Clientes2006
          WHERE Pesq_Satisfacao_Resp_Item.cod_tipo_resposta<>'5'
          AND Pesq_Satisfacao_Resp_Item.codigo_pesquisa=Pesquisa_Opiniao_Clientes2006.codigo_pesquisa
          AND Pesquisa_Opiniao_Clientes2006.ano_pesq='$ANO_REF'
          GROUP BY Pesq_Satisfacao_Resp_Item.cod_pesq_satisfacao";
$ret=sql($BD4,$str_ret);

#$ret=estat_medias(
while ($lista=mysql_fetch_row($ret))
{
     echo "<tr>";
     echo "<td>";
          echo $lista[1];
     echo "</td>";
     echo "</tr>";
}
echo "</table>";

echo "</td>";
echo "<td valign=\"top\">";

echo "<table>";

$str_ret="SELECT Pesq_Satisfacao_Resp_Item.cod_pesq_satisfacao,
                 AVG(Pesq_Satisfacao_Resp_Item.cod_tipo_resposta)
          FROM Pesq_Satisfacao_Resp_Item,Pesquisa_Opiniao_Clientes2006
          WHERE Pesq_Satisfacao_Resp_Item.cod_tipo_resposta<>'5'
          AND Pesq_Satisfacao_Resp_Item.codigo_pesquisa=Pesquisa_Opiniao_Clientes2006.codigo_pesquisa
          AND Pesquisa_Opiniao_Clientes2006.tipo_cliente='0'
          AND Pesquisa_Opiniao_Clientes2006.ano_pesq='$ANO_REF'
          GROUP BY Pesq_Satisfacao_Resp_Item.cod_pesq_satisfacao";
$ret=sql($BD4,$str_ret);

#$ret=estat_medias(0,
while ($lista=mysql_fetch_row($ret))
{
     echo "<tr>";
     echo "<td>";
          echo $lista[1];
     echo "</td>";
     echo "</tr>";
}
echo "</table>";

echo "</td>";
echo "<td valign=\"top\">";

echo "<table>";
$str_ret="SELECT Pesq_Satisfacao_Resp_Item.cod_pesq_satisfacao,
                 AVG(Pesq_Satisfacao_Resp_Item.cod_tipo_resposta)
          FROM Pesq_Satisfacao_Resp_Item,Pesquisa_Opiniao_Clientes2006
          WHERE Pesq_Satisfacao_Resp_Item.cod_tipo_resposta<>'5'
          AND Pesq_Satisfacao_Resp_Item.codigo_pesquisa=Pesquisa_Opiniao_Clientes2006.codigo_pesquisa
          AND Pesquisa_Opiniao_Clientes2006.tipo_cliente='2'
          AND Pesquisa_Opiniao_Clientes2006.ano_pesq='$ANO_REF'
          GROUP BY Pesq_Satisfacao_Resp_Item.cod_pesq_satisfacao";
$ret=sql($BD4,$str_ret);
while ($lista=mysql_fetch_row($ret))
{
     echo "<tr>";
     echo "<td>";
          echo $lista[1];
     echo "</td>";
     echo "</tr>";
}
echo "</table>";

echo "</td>";
echo "<td valign=\"top\">";

echo "<table>";
$str_ret="SELECT Pesq_Satisfacao_Resp_Item.cod_pesq_satisfacao,
                 AVG(Pesq_Satisfacao_Resp_Item.cod_tipo_resposta)
          FROM Pesq_Satisfacao_Resp_Item,Pesquisa_Opiniao_Clientes2006
          WHERE Pesq_Satisfacao_Resp_Item.cod_tipo_resposta<>'5'
          AND Pesq_Satisfacao_Resp_Item.codigo_pesquisa=Pesquisa_Opiniao_Clientes2006.codigo_pesquisa
          AND Pesquisa_Opiniao_Clientes2006.tipo_cliente='1'
          AND Pesquisa_Opiniao_Clientes2006.ano_pesq='$ANO_REF'
          GROUP BY Pesq_Satisfacao_Resp_Item.cod_pesq_satisfacao";
$ret=sql($BD4,$str_ret);
while ($lista=mysql_fetch_row($ret))
{
     echo "<tr>";
     echo "<td>";
          echo $lista[1];
     echo "</td>";
     echo "</tr>";
}
echo "</table>";

echo "</td>";
echo "<td valign=\"top\">";

echo "<table>";


$str_ret="SELECT Pesq_Satisfacao_Resp_Item.cod_pesq_satisfacao,AVG(Pesq_Satisfacao_Resp_Item.cod_tipo_resposta)
             FROM Pesq_Satisfacao_Resp_Item,Pesquisa_Opiniao_Clientes2006
             WHERE Pesquisa_Opiniao_Clientes2006.codigo_pesquisa=Pesq_Satisfacao_Resp_Item.codigo_pesquisa
             AND Pesquisa_Opiniao_Clientes2006.codigo_aval='1'
             AND Pesq_Satisfacao_Resp_Item.cod_tipo_resposta<>'5'
             AND Pesquisa_Opiniao_Clientes2006.ano_pesq='$ANO_REF'
             GROUP BY Pesq_Satisfacao_Resp_Item.cod_pesq_satisfacao";
$ret=sql($BD4,$str_ret);

while ($lista=mysql_fetch_row($ret))
{
     echo "<tr>";
     echo "<td>";
          echo $lista[1];
     echo "</td>";
     echo "</tr>";
}
echo "</table>";
 

echo "</td>";
echo "<td valign=\"top\">";

echo "<table>";
$str_ret="SELECT Pesq_Satisfacao_Resp_Item.cod_pesq_satisfacao,AVG(Pesq_Satisfacao_Resp_Item.cod_tipo_resposta)
             FROM Pesq_Satisfacao_Resp_Item,Pesquisa_Opiniao_Clientes2006
             WHERE Pesquisa_Opiniao_Clientes2006.codigo_pesquisa=Pesq_Satisfacao_Resp_Item.codigo_pesquisa
             AND Pesquisa_Opiniao_Clientes2006.codigo_aval='2'
             AND Pesq_Satisfacao_Resp_Item.cod_tipo_resposta<>'5'
             AND Pesquisa_Opiniao_Clientes2006.ano_pesq='$ANO_REF'
             GROUP BY Pesq_Satisfacao_Resp_Item.cod_pesq_satisfacao";
$ret=sql($BD4,$str_ret);
while ($lista=mysql_fetch_row($ret))
{
     echo "<tr>";
     echo "<td>";
          echo $lista[1];
     echo "</td>";
     echo "</tr>";
}
echo "</table>";


echo "</td>";
echo "<td valign=\"top\">";

echo "<table>";
$str_ret="SELECT Pesq_Satisfacao_Resp_Item.cod_pesq_satisfacao,AVG(Pesq_Satisfacao_Resp_Item.cod_tipo_resposta)
             FROM Pesq_Satisfacao_Resp_Item,Pesquisa_Opiniao_Clientes2006
             WHERE Pesquisa_Opiniao_Clientes2006.codigo_pesquisa=Pesq_Satisfacao_Resp_Item.codigo_pesquisa
             AND Pesquisa_Opiniao_Clientes2006.codigo_aval='3'
             AND Pesq_Satisfacao_Resp_Item.cod_tipo_resposta<>'5'
             AND Pesquisa_Opiniao_Clientes2006.ano_pesq='$ANO_REF'
             GROUP BY Pesq_Satisfacao_Resp_Item.cod_pesq_satisfacao";
$ret=sql($BD4,$str_ret);
while ($lista=mysql_fetch_row($ret))
{
     echo "<tr>";
     echo "<td>";
          echo $lista[1];
     echo "</td>";
     echo "</tr>";
}
echo "</table>";
echo "</td>";
echo "</tr>";
echo "</table>";
*/
?>
