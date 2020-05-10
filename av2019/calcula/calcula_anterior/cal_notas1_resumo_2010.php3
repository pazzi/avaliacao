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


$ret=le_empregados();
while ($lista=mysql_fetch_row($ret))
{
  $matr_ret=$lista[0];
  $nome=$lista[1];
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

$ret_func= busca_notas_por_formulario(3,$matr_ret,$ANO_REF,$lista0[0]);
$return=sql($BD4, $ret_func);

$soma=0;
$media=0;
$notas="";
$notas_ar=array();
 while ($lista=mysql_fetch_row($return))
         {
           $notas_ar[]= $lista[1];
          }
           sort($notas_ar);
           $conta_ind= count($notas_ar);
           for ( $indice = 1 ; $indice <= $conta_ind - 2 ; $indice++ )
            {
                $soma=$soma+$notas_ar[$indice];
             }
$media_cli=$soma/($indice-1);

$nota_ecom1=(($media_sup * 3)/5) + (($media_cli * 2)/5);
$nota_virg=explode(".",$nota_ecom1);
$nota_fim=$nota_virg[0].",".$nota_virg[1];

echo $matr_ret.";".$nome.";".$nota_fim;
#$nota_ecom=($nota_ecom1 -1)/3;
#echo $matr_ret.":::".$nota_ecom;
echo "<br>";
}

?>
