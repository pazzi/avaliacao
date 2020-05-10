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
                   echo "ecom=".$ecom;
                   break; 
        case "101":
                   $ecom=$media_sup * 3.25 + $media_auto * 1.75;
                   echo "ecom =".$ecom;
                   break; 
        case "110":
                   $ecom=$media_sup * 3 + $media_pares * 2;
                   echo "ecom =".$ecom;
                   echo "###############";
                   break; 
        case "111":
                   $ecom=$media_sup * 2.5 + $media_pares * 1.5 + $media_auto;
                   echo "ecom =".$ecom;
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

$ret=le_empregados();

echo "<br>";
echo "S U P E R V I S O R";
echo "<br>";

while ($lista=mysql_fetch_row($ret))
{
  $matr_ret=$lista[0];
  $nome=$lista[1];
  echo $matr_ret .":". $nome;
  $ret_func= busca_medias_competencia(1,$matr_ret,$ANO_REF);
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
  $media_sup=$soma_nota/$contador;
  echo $media_sup;
  echo "<br>\n";
}


$ret=le_empregados();

echo "<br>";
echo "A u t o a v a l i a c a o";
echo "<br>";

while ($lista=mysql_fetch_row($ret))
{
  $matr_ret=$lista[0];
  $nome=$lista[1];
  echo $matr_ret .":". $nome;
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
echo "<br>";
}

$ret=le_empregados();

echo "<br>";
echo "A v a l i a c a o &nbsp; d e &nbsp;&nbsp; P a r e s";
echo "<br>";
while ($lista=mysql_fetch_row($ret))
{
  $matr_ret=$lista[0];
  $nome=$lista[1];
  echo $matr_ret .":". $nome;
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
}

rodape();
?>
