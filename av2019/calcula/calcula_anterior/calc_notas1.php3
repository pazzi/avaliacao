<?php
include ("../../func_avalia.php3");
cabecalho();
function calcula_ecom($media_sup,$media_pares,$media_auto)
{
	$md_sup=0;
	$md_par=0;
	$md_aut=0;
	if ($media_sup>0)
    		{
		      $md_sup=1;
		}
	if ($media_pares>0)
    		{
		      $md_par=1;
    		}
	if ($media_auto>0)
    		{
		      $md_aut=1;
    		}
  $md_total=$md_sup.$md_par.$md_aut;
  switch($md_total)
      {
        case "100":
                   $ecom=$media_sup * 5;
                   echo "ecom(100)=".$ecom*100/5;
                   break; 
        case "101":
                   $ecom=$media_sup * 3.25 + $media_auto * 1.75;
                   echo "ecom(101) =".$ecom*100/5;
                   break; 
        case "110":
                   $ecom=$media_sup * 3 + $media_pares * 2;
                   echo "ecom(110) =".$ecom*100/5;
                   echo "###############";
                   break; 
        case "111":
                   $ecom=$media_sup * 2.5 + $media_pares * 1.5 + $media_auto;
                   echo "ecom(111) =".$ecom*100/5;
                   break; 
      }
}

function le_empregados()
{
 global $BD1;
 $sql_matr="select matr,nome from empregados where tipo='e' and situacao='a' order by nome";
 $ret=sql($BD1,$sql_matr);
 return($ret);
}

echo "<center><font class=\"title\"><u>A v a l i a c a o  - 2 0 0 9 - A n o &nbsp;&nbsp; B a s e  - 2 0 0 8</u></font></center>";
echo "<br>";
echo "<u>Observacoes:</u>";
echo "<br>";
echo "A variacao do Ecom e de 1 a 4.";
echo "<br>";
echo "Com o Ecom (Escore de competencias) e o EAF (Escore de avaliacao final - SAAD) obtem-se o EPP - Escore de progressao salarial por merito";
echo "<br>";
echo "O calculo do EPP --> EPP = [(EAF x 80) + (Ecom convertido para a mesma base do EAF x 20)] / 100";
echo "<br>";

$ret=le_empregados();
while ($lista=mysql_fetch_row($ret))
{
  $matr_ret=$lista[0];
  $nome=$lista[1];
  echo "<br>";
  echo $matr_ret .":". $nome;
  echo "<br>";
  $ret_func= busca_medias_competencia(1,$matr_ret,$ANO_REF);
  $return=sql($BD4, $ret_func);
  $contador=0;
  $soma_nota=0;
  echo "S u p e r v i s a o";
  while ($lista=mysql_fetch_row($return))
         {
          echo ":".$lista[0];
          echo ":";
          echo $lista[1];
          echo ":";
          $contador++;
          $soma_nota=$soma_nota+$lista[1];
         }
  $media_sup=$soma_nota/$contador;
  echo $media_sup;
  echo "<br>\n";

echo "A u t o a v a l i a c a o";

  $ret_func= busca_medias_competencia(2,$matr_ret,$ANO_REF);
  $return=sql($BD4, $ret_func);
  $contador=0;
  $soma_nota=0;
  while ($lista=mysql_fetch_row($return))
         {
          echo ":".$lista[0];
          echo ":";
          echo $lista[1];
          echo ":";
          $contador++;
          $soma_nota=$soma_nota+$lista[1];
         }
  $media_auto=$soma_nota/$contador;
  echo $media_auto;

/*
echo "<br>";
echo "A v a l i a c a o &nbsp; d e &nbsp;&nbsp; P a r e s";
echo "<br>";
  $ret_func= busca_medias_competencia(3,$matr_ret,$ANO_REF);
  $return=sql($BD4, $ret_func);
  $contador=0;
  $soma_nota=0;
  while ($lista=mysql_fetch_row($return))
         {
          echo ":".$lista[0];
          echo ":";
          echo $lista[1];
          echo ":";
          $contador++;
          $soma_nota=$soma_nota+$lista[1];
         }

  $media_pares=$soma_nota/$contador;
  echo $media_pares;
  echo "<br>";
  echo "Ecom";
  echo ":";
  calcula_ecom($media_sup,$media_pares,$media_auto);
}

rodape();

*/

echo "<br>";
echo "A v a l i a c a o &nbsp; d e &nbsp;&nbsp; P a r e s:";

$ret_func= busca_medias(3,$matr_ret,$ANO_REF);
$return=sql($BD4, $ret_func);

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
         }
     


$soma_media_pares=0;
$conta_medias_pares=0;

if ($cont1>0)
  {
   $conta_medias_pares++;
   $med_competencia_par=$compet1/$cont1;
   echo "1:";
   echo $med_competencia_par;
   echo ":";
   $soma_media_pares=$soma_media_pares+$med_competencia_par;
 }

if ($cont2>0)
  {
   $conta_medias_pares++;
   $med_competencia_par=$compet2/$cont2;
   echo "2:";
   echo $med_competencia_par;
   echo ":";
   $soma_media_pares=$soma_media_pares+$med_competencia_par;
 }

if ($cont3>0)
  {
   $conta_medias_pares++;
   $med_competencia_par=$compet3/$cont3;
   echo "3:";
   echo $med_competencia_par;
   echo ":";
   $soma_media_pares=$soma_media_pares+$med_competencia_par;
 }

if ($cont4>0)
  {
   $conta_medias_pares++;
   $med_competencia_par=$compet4/$cont4;
   echo "4:";
   echo $med_competencia_par;
   echo ":";
   $soma_media_pares=$soma_media_pares+$med_competencia_par;
 }

if ($cont5>0)
  {
   $conta_medias_pares++;
   $med_competencia_par=$compet5/$cont5;
   echo "5:";
   echo $med_competencia_par;
   echo ":";
   $soma_media_pares=$soma_media_pares+$med_competencia_par;
 }

if ($cont6>0)
  {
   $conta_medias_pares++;
   $med_competencia_par=$compet6/$cont6;
   echo "6:";
   echo $med_competencia_par;
   echo ":";
   $soma_media_pares=$soma_media_pares+$med_competencia_par;
 }

if ($cont7>0)
  {
   $conta_medias_pares++;
   $med_competencia_par=$compet7/$cont7;
   echo "7:";
   echo $med_competencia_par;
   echo ":";
   $soma_media_pares=$soma_media_pares+$med_competencia_par;
 }

if ($cont8>0)
  {
   $conta_medias_pares++;
   $med_competencia_par=$compet8/$cont8;
   echo "8:";
   echo $med_competencia_par;
   echo ":";
   $soma_media_pares=$soma_media_pares+$med_competencia_par;
 }

if ($cont9>0)
  {
   $conta_medias_pares++;
   $med_competencia_par=$compet9/$cont9;
   echo "9:";
   echo $med_competencia_par;
   echo ":";
   $soma_media_pares=$soma_media_pares+$med_competencia_par;
 }


echo "Media pares:";
$media_pares= $soma_media_pares/$conta_medias_pares;
echo $media_pares;

$md_sup=0;
$md_par=0;
$md_aut=0;
if ($media_sup>0)
    {
      $md_sup=1;
    }
if ($media_pares>0)
    {
      $md_par=1;
    }
if ($media_auto>0)
    {
      $md_aut=1;
    }
$md_total=$md_sup.$md_par.$md_aut;

switch($md_total)
      {
        case "100":
                   $ecom=$media_sup * 5;
                   echo ":Ecom=".$ecom * 5/20;
                   break; 
        case "101":
                   $ecom=$media_sup * 3.25 + $media_auto * 1.75;
                   echo ":Ecom =".$ecom * 5/20;
                   break; 
        case "110":
                   $ecom=$media_sup * 3 + $media_pares * 2;
                   echo ":Ecom =".$ecom * 5/20;
                   echo "###############";
                   break; 
        case "111":
                   $ecom=$media_sup * 2.5 + $media_pares * 1.5 + $media_auto;
                   echo ":Ecom =".$ecom/5;
                   break; 
      }
echo "<br>\n";
}
?>
