<?php
include ("../../func_avalia.php3");
$res_sql_empr="select avaliacao.elegiveis.matr,cnpma.empregados.nome from avaliacao.elegiveis,cnpma.empregados  where avaliacao.elegiveis.elegivel='1' and avaliacao.elegiveis.matr=cnpma.empregados.matr";
$ret=sql($BD3, $res_sql_empr);

echo "<table border=\"0\" valign=\"top\" cellpadding=1>";

while ($lis=mysql_fetch_row($ret))
{
 $matr=$lis[0];
 $nome=$lis[1];
 $contador=0;
 $soma_nota=0;
 $ret_func= busca_medias_competencia(1,$lis[0],$ANO_REF);
 $return=sql($BD4, $ret_func);
 while ($lista=mysql_fetch_row($return))
         {
#          echo "<td>\n";
#          $matr=$lis[0];
#          $nome=$lis[1];
#          echo "</td>\n";
/*
          echo "<td>\n";
          $msg=retorna_texto_competencia($lista[0]);
          echo $msg;
          echo "</td>";
          echo "<td>";
          echo $lista[1];
          echo "</td>\n";
*/
          $contador++;
          $soma_nota=$soma_nota+$lista[1];
         }
  $media_sup=$soma_nota/$contador;
  echo "<td>$matr</td><td>$nome</td><td bgcolor=\"#ffff00\">$media_sup</td>";
  $matr='**';
  $nome='**';
  echo "</tr>\n";
}
echo "</table>";
?>
