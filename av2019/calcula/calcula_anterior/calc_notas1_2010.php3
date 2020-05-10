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
 #$sql_matr="select matr,nome from empregados where tipo='e' and situacao='a' order by nome";
 $sql_matr="select matr,nome from cnpma.empregados, avaliacao.final where cnpma.empregados.tipo='e' 
 and cnpma.empregados.matr=cnpma.avaliacao.final.matr
 and cnpma.empregados.situacao='a' order by avaliacao.final,cnpma.empregados.nome";
 $ret=sql($BD1,$sql_matr);
 return($ret);
}

echo "<center><font class=\"title\"><u>A v a l i a c a o  - 2010- A n o &nbsp;&nbsp; B a s e  - ".$ANO_BASE."</u></font></center>";
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
  echo "<br>\n";
  echo "Media Supervisor : ";
  echo $media_sup;
  echo "<br>\n";

/*
echo "<br>";
echo "A v a l i a c a o &nbsp; d e &nbsp;&nbsp; C L I E N T E S :";
echo "<br>";


#$busca_chave=busca_por_id_avaliacao(3,$matr_ret,$ANO_BASE);
$ret_func= busca_notas_por_formulario(3,$matr_ret,$ANO_BASE,$lista0[0]);
$return=sql($BD4, $ret_func);

$soma=0;
$media=0;
$notas="";
$notas_ar=array();
 while ($lista=mysql_fetch_row($return))
         {
           echo $lista[0].":::".$lista[1].":::".$lista[2];
           #$notas.= $lista[1].",";
           $notas_ar[]= $lista[1];
           echo "<br>";
          }
         #$tamanho=strlen($notas);
         #$notas=substr($notas,0,$tamanho-1);
         #$notas_ar=array($notas); 
         sort($notas_ar);
         echo "Numero de avaliacoes:";
         $conta_ind= count($notas_ar);
         echo $conta_ind;
         echo "<br>";
         echo "Medias dos formularios para o calculo";
         echo "<br>";
         for ( $indice = 1 ; $indice <= $conta_ind - 2 ; $indice++ )
            {
             echo  $notas_ar[$indice] . '<br>';
             $soma=$soma+$notas_ar[$indice];
             }
 $media_cli=$soma/($indice-1);
echo "<br>";
echo "Media Clientes:";
echo $media_cli;


#echo"__________";
#echo $media_sup;
#echo "-";
#echo $media_cli;
#echo "-";

echo "<br>";
echo "media superv:".$media_sup;
echo "<br>";
$nota_ecom1=(($media_sup * 3)/5) + (($media_cli * 2)/5);

echo "<br>";
echo "nota para o sisrec:".$nota_ecom1;
echo "<br>";
Echo "ECOM:";
$nota_ecom=($nota_ecom1 -1)/3;
echo $nota_ecom;

*/
echo "<hr>";
echo "<br>";
}

?>
