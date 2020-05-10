<?php
include ("../../func_avalia.php3");

$matr_ret=$_GET["matricula"];

$sql_matr=sql($BD1,"select matr,nome,local from empregados where matr='$matr_ret'");
$nome=mysql_result($sql_matr,0,"nome");
$local_ret=mysql_result($sql_matr,0,"local");

cabecalho();
echo "<br>";
echo "<center><font class=\"title\">$matr_ret - $nome</font></center>";
echo "<br>";
echo "<br>";
echo "<center><font class=\"title\"><u>Medias de competencias  - $ANO_AVAL - A n o &nbsp;&nbsp; B a s e  - $ANO_REF</u></font></center>";
echo "<br>";
echo "<br>";

echo "<table cellsspacing=4 cellpadding=1>\n";
echo "<tr>\n";
echo "<td bgcolor=\"#ffffff\">\n";
echo "<font class=\"title\"><u>Resultado:</u></font>";
echo "</td>\n";
echo "</tr>\n";
echo "</table>\n";

 $ret_func= busca_medias_competencia(1,$matr_ret,$ANO_REF);
 $return=sql($BD4, $ret_func);
 $contador=0;
 $soma_nota=0;
 while ($lista=mysql_fetch_row($return))
         {
          $contador++;
          $soma_nota=$soma_nota+$lista[1];
         }
 $media_sup=$soma_nota/$contador;


#Calculo das nota dos clientes e do ecom
$ret_func= busca_notas_por_formulario(3,$matr_ret,$ANO_REF,$lista0[0]);
$return=sql($BD4, $ret_func);
$soma=0;
$media=0;
$notas="";
$notas_ar=array();
$id_ar=array();
while ($lista=mysql_fetch_row($return))
         {
               $notas_ar[]= $lista[1];
               $id_ar[]= $lista[0];
         }
sort($notas_ar);
$conta_ind= count($notas_ar);
for ( $indice = 1 ; $indice <= $conta_ind - 2 ; $indice++ )
           {
              $soma=$soma+$notas_ar[$indice];
            }
$media_cli=$soma/($indice-1);
$nota_ecom1=(($media_sup * 3)/5) + (($media_cli * 2)/5);
$nota_ecom=($nota_ecom1 -1)/3;
#$nota_ecom=($nota_ecom1)/4;

echo "<table border=0>\n";
echo "<tr>\n";
echo "<td>\n";
 echo "Media do Supervisor:";
echo "</td>\n";
echo "<td>\n";
 echo $media_sup;
echo "</td>\n";
echo "</tr>\n";
echo "<tr>\n";
echo "<td>\n";
echo "Media Clientes final";
echo "</td>\n";
echo "<td>\n";

echo $media_cli;
echo " &nbsp;&nbsp;- &nbsp;&nbsp;&nbsp;Utilizando-se as seguintes medias de clientes ->";
for ( $indice = 1 ; $indice <= $conta_ind - 2 ; $indice++ )
           {
              echo $notas_ar[$indice];
              echo "[Avaliador:";
              echo $id_ar[$indice];
              echo "]";
              echo "&nbsp;&nbsp; ";

            }
echo "<br>";
echo "Medias de clientes desprezadas ->";
echo $notas_ar[0];
echo "[Avaliador:";
echo $id_ar[0];
echo "]";
echo "&nbsp;&nbsp; ";
echo $notas_ar[$conta_ind-1];
echo "[Avaliador:";
echo $id_ar[$conta_ind-1];
echo "]";

echo "</td>\n";
echo "<tr>\n";
echo "</table>\n";

echo "<br>";
echo "<br>";
echo "<table border=\"0\" valign=\"top\" cellpadding=1>";
 echo "<tr><td align=\"center\" colspan=2>S U P E R V I S O R</td></tr>";
 $ret_func= busca_medias_competencia(1,$matr_ret,$ANO_REF);
 $return=sql($BD4, $ret_func);
 $contador=0;
 $soma_nota=0;
 while ($lista=mysql_fetch_row($return))
         {
          echo "<tr";
            if (bcmod($contador,2)==0)
                {
                  echo " bgcolor=\"#ffff66\" >\n";
                }
                 else
                     {
                      echo " bgcolor=\"#ffffff\" >\n";
                     }
          echo "<td>\n";
          $msg=retorna_texto_competencia($lista[0]);
          echo $msg;
          echo "</td>";
          echo "<td>";
          echo $lista[1];
          echo "</td>\n";
          echo "</tr>\n";
          $contador++;
          $soma_nota=$soma_nota+$lista[1];
         }
$media_sup=$soma_nota/$contador;
echo "<tr><td>Media</td><td bgcolor=\"#ffff00\">$media_sup</td></tr>";
echo "</table>";
echo "</td>\n";
echo "</tr>\n";
echo "</table>\n";

echo "<br>";
echo "<br>";
echo "<br>";

 $ret_func= busca_medias(3,$matr_ret,$ANO_REF);
 $return=sql($BD4, $ret_func);
 $contador=0;
 $soma_nota=0;

 $compet1=0;
 $compet2=0;
 $compet3=0;
 $compet4=0;
 $compet5=0;
 $compet6=0;
 $compet7=0;
 $compet8=0;
 $compet9=0;
 $cont1=0;
 $cont2=0;
 $cont3=0;
 $cont4=0;
 $cont5=0;
 $cont6=0;
 $cont7=0;
 $cont8=0;
 $cont9=0;

 while ($lista=mysql_fetch_row($return))
         {
          $texto_competencia=$lista[0];
          $valor_compet=$lista[1];
          $num_compet=$lista[2];
          echo "<tr";
            if (bcmod($contador,2)==0)
                {
                  echo " bgcolor=\"#99ffff\" >\n";
                }
                 else
                     {
                      echo " bgcolor=\"#ffffff\" >\n";
                     }
/*
          echo "<td align=\"center\">\n";
          echo $num_compet;
          echo "</td>\n";
          echo "<td>\n";
          #echo retorna_texto($texto_competencia);
          echo "</td>\n";
          echo "<td>\n";
          echo $valor_compet;
          echo "</td>\n";
*/

          echo "</tr>\n";

          switch ($num_compet)
                {
                  case 1:
                         $cont1++;
                         $compet1=$compet1 + $valor_compet;
                         break;
                  case 2:
                         $cont2++;
                         $compet2=$compet2 + $valor_compet;
                         break;
                  case 3:
                         $cont3++;
                         $compet3=$compet3 + $valor_compet;
                         break;
                  case 4:
                         $cont4++;
                         $compet4=$compet4 + $valor_compet;
                         break;
                  case 5:
                         $cont5++;
                         $compet5=$compet5 + $valor_compet;
                         break;
                  case 6:
                         $cont6++;
                         $compet6=$compet6 + $valor_compet;
                         break;
                  case 7:
                         $cont7++;
                         $compet7=$compet7 + $valor_compet;
                         break;
                  case 8:
                         $cont8++;
                         $compet8=$compet8 + $valor_compet;
                         break;
                  case 9:
                         $cont9++;
                         $compet9=$compet9 + $valor_compet;
                         break;
                }

          $contador++;
          $soma_nota=$soma_nota+$lista[1];
         }

echo "<table border=\"0\" valign=\"top\" cellpadding=1>";
echo "<tr><td align=\"center\" colspan=2> A v a l i a c a o &nbsp; d e &nbsp;&nbsp; C l i e n t  e s</td></tr>";
echo "<tr><td align=\"center\" colspan=2>Medias por competencia</td></tr>";

$soma_media_pares=0;
$conta_medias_pares=0;

echo "<tr bgcolor=\"#ffff66\" >\n";
echo "<td>\n";
$msg=retorna_texto_competencia(1);
echo $msg;
echo "</td>";

if ($cont1>0)
  {
   echo "<td>";
   $conta_medias_pares++;
   $med_competencia_par=$compet1/$cont1;
   echo $med_competencia_par;
   $soma_media_pares=$soma_media_pares+$med_competencia_par;
   echo "</td>\n";
   echo "</tr>\n";
 }
  else
      {
       echo "<td>";
       echo "----";
       echo "</td>\n";
       echo "</tr>\n";
     }


echo "<tr bgcolor=\"#ffffff\" >\n";
echo "<td>\n";
$msg=retorna_texto_competencia(2);
echo $msg;
echo "</td>";

if ($cont2>0)
  {
   echo "<td>";
   $conta_medias_pares++;
   $med_competencia_par=$compet2/$cont2;
   echo $med_competencia_par;
   $soma_media_pares=$soma_media_pares+$med_competencia_par;
   echo "</td>\n";
   echo "</tr>\n";
 }
  else
      {
       echo "<td>";
       echo "----";
       echo "</td>\n";
       echo "</tr>\n";
     }


echo "<tr bgcolor=\"#ffff66\" >\n";
echo "<td>\n";
$msg=retorna_texto_competencia(3);
echo $msg;
echo "</td>";

if ($cont3>0)
  {
   echo "<td>";
   $conta_medias_pares++;
   $med_competencia_par=$compet3/$cont3;
   echo $med_competencia_par;
   $soma_media_pares=$soma_media_pares+$med_competencia_par;
   echo "</td>\n";
   echo "</tr>\n";
 }
  else
      {
       echo "<td>";
       echo "----";
       echo "</td>\n";
       echo "</tr>\n";
     }


echo "<tr bgcolor=\"#ffffff\" >\n";
echo "<td>\n";
$msg=retorna_texto_competencia(4);
echo $msg;
echo "</td>";

if ($cont4>0)
  {
   echo "<td>";
   $conta_medias_pares++;
   $med_competencia_par=$compet4/$cont4;
   echo $med_competencia_par;
   $soma_media_pares=$soma_media_pares+$med_competencia_par;
   echo "</td>\n";
   echo "</tr>\n";
 }
  else
      {
       echo "<td>";
       echo "----";
       echo "</td>\n";
       echo "</tr>\n";
     }


echo "<tr bgcolor=\"#ffff66\" >\n";
echo "<td>\n";
$msg=retorna_texto_competencia(5);
echo $msg;
echo "</td>";

if ($cont5>0)
  {
   echo "<td>";
   $conta_medias_pares++;
   $med_competencia_par=$compet5/$cont5;
   echo $med_competencia_par;
   $soma_media_pares=$soma_media_pares+$med_competencia_par;
   echo "</td>\n";
   echo "</tr>\n";
 }
  else
      {
       echo "<td>";
       echo "----";
       echo "</td>\n";
       echo "</tr>\n";
     }


echo "<tr bgcolor=\"#ffffff\" >\n";
echo "<td>\n";
$msg=retorna_texto_competencia(6);
echo $msg;
echo "</td>";

if ($cont6>0)
  {
   echo "<td>";
   $conta_medias_pares++;
   $med_competencia_par=$compet6/$cont6;
   echo $med_competencia_par;
   $soma_media_pares=$soma_media_pares+$med_competencia_par;
   echo "</td>\n";
   echo "</tr>\n";
 }
  else
      {
       echo "<td>";
       echo "----";
       echo "</td>\n";
       echo "</tr>\n";
     }


echo "<tr bgcolor=\"#ffff66\" >\n";
echo "<td>\n";
$msg=retorna_texto_competencia(7);
echo $msg;
echo "</td>";

if ($cont7>0)
  {
   echo "<td>";
   $conta_medias_pares++;
   $med_competencia_par=$compet7/$cont7;
   echo $med_competencia_par;
   $soma_media_pares=$soma_media_pares+$med_competencia_par;
   echo "</td>\n";
   echo "</tr>\n";
 }
  else
      {
       echo "<td>";
       echo "----";
       echo "</td>\n";
       echo "</tr>\n";
     }


echo "<tr bgcolor=\"#ffffff\" >\n";
echo "<td>\n";
$msg=retorna_texto_competencia(8);
echo $msg;
echo "</td>";

if ($cont8>0)
  {
   echo "<td>";
   $conta_medias_pares++;
   $med_competencia_par=$compet8/$cont8;
   echo $med_competencia_par;
   $soma_media_pares=$soma_media_pares+$med_competencia_par;
   echo "</td>\n";
   echo "</tr>\n";
 }
  else
      {
       echo "<td>";
       echo "----";
       echo "</td>\n";
       echo "</tr>\n";
     }

echo "<tr bgcolor=\"#ffff66\" >\n";
echo "<td>\n";
$msg=retorna_texto_competencia(9);
echo $msg;
echo "</td>";

if ($cont9>0)
  {
   echo "<td>";
   $conta_medias_pares++;
   $med_competencia_par=$compet9/$cont9;
   echo $med_competencia_par;
   $soma_media_pares=$soma_media_pares+$med_competencia_par;
   echo "</td>\n";
   echo "</tr>\n";
 }
  else
      {
       echo "<td>";
       echo "----";
       echo "</td>\n";
       echo "</tr>\n";
     }


echo "<tr bgcolor=\"#ffffff\" >\n";
echo "<td>\n";
echo "Media pares";
echo "</td>";
echo "<td>";
$media_pares= $soma_media_pares/$conta_medias_pares;
echo $media_pares;
echo "</td>\n";
echo "</tr>\n";
echo "</table>\n";

echo "</td>";
echo "</tr>";
echo "</table>";
rodape();
?>
