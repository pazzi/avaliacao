<?php
include ("../func_avalia.php3");

$str_get= $_GET["id"];
$expl_get=explode(":::",$str_get);
$matr_ret=$expl_get[1];

$sql_matr=sql($BD1,"select matr,nome,local from empregados where matr='$matr_ret'");
$nome=mysql_result($sql_matr,0,"nome");
$local_ret=mysql_result($sql_matr,0,"local");
$sql_elegiveis=sql($BD4,"select * from elegiveis where matr='$matr_ret' and ano='$ANO_REF'");
$agrupamento=mysql_result($sql_elegiveis,0,"cod_agrupamento");
$supervisor=mysql_result($sql_elegiveis,0,"supervisor");
$setor=mysql_result($sql_elegiveis,0,"cod_setor");

$sql_id="SELECT codigo_pesquisa FROM Pesquisa_Opiniao WHERE ano_pesq='$ANO_REF' AND matricula='$matr_ret' AND codigo_aval='2'";
$res_sql_id=sql($BD4,$sql_id);
$codigo=mysql_result($res_sql_id,0,"codigo_pesquisa");



cabecalho();

echo "<center>";
	echo "<h4>Avaliacao de Desempenho Individual</h4>";
echo "</center>";
echo "</div>";

echo "<br>\n";
echo "<br>\n";
$nome_agrupamento=nome_agrupamento($agrupamento);
echo "<div class=\"row\">";
	echo "<div class=\"col-md-8\">";
	echo "<div class=\"well\">";
	echo "<h5>$nome</h5>";
	echo "</div>";
	echo "</div>";
	echo "<div class=\"col-md-4\">";
	echo "<div class=\"well\">";
	echo "<h5>$nome_agrupamento</h5>";
	echo "</div>";
	echo "</div>";
echo "</div>";

echo "<div class=\"row\">";
	echo "<div class=\"col-md-8\">";
	echo "<div class=\"well\">";
	echo "<h5>$LOTACAO</h5>";
	echo "</div>";
	echo "</div>";
	echo "<div class=\"col-md-4\">";
	echo "<div class=\"well\">";
	echo "<h5>".lista_nome($supervisor)."</h5>";
	echo "</div>";
	echo "</div>";
echo "</div>";

$matriz=array();

$matriz[0][0]="AVALIADORES/INDICADORES";
$matriz[1][0]="Superior Imediato";
$matriz[2][0]="Pares(media ponderada)";
$matriz[3][0]="Indicadores de Producao(pesquisa)";
$matriz[4][0]="Indicadores de Engajamento(pesquisa)";
$matriz[5][0]="Valor ponderado por fontes";
$matriz[0][1]="Competencias Comportamentais";
$matriz[0][2]="Peso da Fonte";
$matriz[0][3]="Contribuicao Tecnica";
$matriz[0][4]="Peso da Fonte";
$matriz[0][5]="Engajamento com o Trabalho";
$matriz[0][6]="Peso da Fonte";
$matriz[5][1]=(($matriz[1][1]*$matriz[1][2])/100);

$matriz2=array();
$matriz2[0][0]="Indicadores";
$matriz2[1][0]="Peso dos Indicadores";
$matriz2[2][0]="Valor Ponderado por fontes (acima)";
$matriz2[3][0]="Nota do Indicador";
$matriz2[0][1]="Competencias Comportamentais";
$matriz2[0][2]="Engajamento com o Trabalho";
$matriz2[0][3]="Contribuicao Tecnica";

$ret_peso_indicador_sql ="select distinct(z_indicador.cod_indicador), z_indicador.peso from z_indicador, z_itens where z_indicador.id=z_itens.id_indicador AND z_indicador.cod_agrupamento='$agrupamento'";

$ret_peso_indicador=sql($BD4,$ret_peso_indicador_sql);

while ($list_peso_indicador = mysql_fetch_row($ret_peso_indicador))
{
	switch ($list_peso_indicador[0])
		{	
			case 1:
				$matriz2[1][1]=$list_peso_indicador[1];
				break;
			case 3:
				$matriz2[1][2]=$list_peso_indicador[1];
				break;
			case 2:
				$matriz2[1][3]=$list_peso_indicador[1];
				break;
		}
}
	


$ret_peso_fontes_sql="select * from z_indicador, z_itens where z_indicador.id=z_itens.id_indicador AND z_indicador.cod_agrupamento='$agrupamento'";
$ret_peso_fontes=sql($BD4,$ret_peso_fontes_sql);

while ($list_peso_fontes = mysql_fetch_row($ret_peso_fontes))
{
	switch ($list_peso_fontes[6])
		{	
# Ana Paula - alterei os codigos a sguir das fontes para 2019 de 8, 9, 10, 11 e 12 para 13, 14, 15, 16, 17
			case 13:
				$matriz[1][2]=$list_peso_fontes[7];
				break;
			case 2: # aval 360?? - nao alterei
				$matriz[2][2]=$list_peso_fontes[7];
				break;
			case 14:
				$matriz[1][4]=$list_peso_fontes[7];
				break;
			case 15:
				$matriz[1][6]=$list_peso_fontes[7];
				break;
			case 16:
				$matriz[3][4]=$list_peso_fontes[7];
				break;
			case 17:
				$matriz[4][6]=$list_peso_fontes[7];
				break;
		}
}



 $ret_func= busca_medias_competencia(1,$matr_ret,$ANO_REF);
 $return=sql($BD4, $ret_func);
 $contador=0;
 $soma_nota=0;
 while ($lista=mysql_fetch_row($return))
         {
          if (($lista[0] <> 4) and ($lista[0] <> 5) and ($lista[0] <> 6) and ($lista[0] <> 7) and ($lista[0] <> 8))
		{
          		$contador++;
          		$soma_nota=$soma_nota+$lista[1];
		}
			else
				{
					$memorial[$lista[0]][$lista[1]];
					switch ($lista[0])
							{
								case 4:
									$matriz[1][5]=$lista[1];
									break;
								case 5:
									$matriz[1][3]=$lista[1];
									break;
								case 6: 
									$matriz[1][5]=$lista[1];
									break;
								case 7: 
									$matriz[3][3]=$lista[1];
									break;
								case 8: 
									$matriz[4][5]=$lista[1];
									break;
							}
				
				}
         }
$media_sup=$soma_nota/$contador;
$matriz[1][1]=$media_sup;



#Calculo das nota dos clientes 
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
$conta_ind= count($notas_ar);
for ( $indice = 0 ; $indice <= $conta_ind - 1 ; $indice++ )
           {
              $soma=$soma+$notas_ar[$indice];
            }
$media_cli=$soma/($conta_ind);

$matriz[2][1]=$media_cli;


#Valor ponderado Compet Comportamentais de todos e Indicadores Prod e Engajamento da pesquisa
$matriz[5][1]=(($matriz[1][1]*$matriz[1][2])+($matriz[2][1]*$matriz[2][2])+($matriz[3][1]*$matriz[3][2])+($matriz[4][1]*$matriz[4][2]))/100;
$matriz2[2][1]=$matriz[5][1];

#Valor ponderado da Contr Tecnica
$matriz[5][3]=(($matriz[1][3]*$matriz[1][4])+($matriz[2][3]*$matriz[2][4])+($matriz[3][3]*$matriz[3][4])+($matriz[4][3]*$matriz[4][4]))/100;
$matriz2[2][3]=$matriz[5][3];

#Valor ponderado do Engajamento
$matriz[5][5]=(($matriz[1][5]*$matriz[1][6])+($matriz[2][5]*$matriz[2][6])+($matriz[3][5]*$matriz[3][6])+($matriz[4][5]*$matriz[4][6]))/100;
$matriz2[2][2]=$matriz[5][5];

$matriz2[3][1]=$matriz2[1][1]*$matriz2[2][1]/100;
$matriz2[3][2]=$matriz2[1][2]*$matriz2[2][2]/100;
$matriz2[3][3]=$matriz2[1][3]*$matriz2[2][3]/100;

$nfi=$matriz2[3][1]+$matriz2[3][2]+$matriz2[3][3];


echo "<table class=\"table table-striped\">";
echo "<thead>";
echo "<tr>";
	for ($c=0; $c<=5; $c++)
		{	
			echo "<th>";
			echo $matriz[$c][0];
			echo "</th>";
		}
echo "</tr>";

echo "</thead>";
echo "<tbody>";
	for ($l=1; $l<=6; $l++)
		{
			echo "<tr>";
			for ($c=0; $c<=5; $c++)
				{
					if ($c==0)
						{
							echo "<td>";
						}
						else	{

								echo "<td align=\"center\">";
							}
					#if ((($matriz[$c][$l]=="") or ($matriz[$c][$l]==0)) and ($c>0))
#echo $c;
#echo "###";
#echo $l;

					if (($matriz[$c][$l]=="")  and ($c>0))
						{
							$matriz[$c][$l]="***";
						}
						
					if ( ($c<>0) AND (($l%2)==0) AND ($matriz[$c][$l] <> "***") )
						{
						#	echo $matriz[$c][$l]. "%" . "---".$c . "-". $l;
							echo $matriz[$c][$l]. "%";
						} else{
								echo $matriz[$c][$l];
							}
					
						

					echo "</td>";	
				}
			echo "</tr>";
		} 
echo "</tbody>";

echo "</table>";

$tem_memorial= busca_memorial($codigo);

if ($tem_memorial == 0)
	{

		echo "**Obs: Memorial Tecnico ou Relato do Empregado nao preenchido";
	}

echo "<br>";
echo "<br>";

echo "<table class=\"table table-striped\">";
echo "<thead class=\"thead-inverse\">";
echo "<tr>";
	for ($c=0; $c<=3; $c++)
		{	
			echo "<th>";
			echo $matriz2[$c][0];
			echo "</th>";
		}
echo "</tr>";

echo "</thead>";
echo "<tbody>";
	for ($l=1; $l<=4; $l++)
		{
			echo "<tr>";
			for ($c=0; $c<=3; $c++)
				{
					echo "<td>";
					if ($c==1)
						{
							echo $matriz2[$c][$l]."%";
						}else	{
								echo $matriz2[$c][$l];
							}
					echo "</td>";	
				}
			echo "</tr>";
		} 
echo "</tbody>";

echo "</table>";



echo "<div class=\"row\">";
echo "<div class=\"col-md-10\">";
echo "<div class=\"well\">";
echo "<h4>NFI -  Nota final dos Indicadores</h4>";
echo "</div>";
echo "</div>";
echo "<div class=\"col-md-2\">";
echo "<div class=\"well\">";
echo "<h4>$nfi</h4>";
echo "</div>";
echo "</div>";
echo "</div>";

echo "<br>";



$valor=$nome.":::".$nome_agrupamento.":::".lista_nome($supervisor).":::".$nfi;

$fim=count($matriz);

for ($i = 0; $i <= $fim; $i++)
	for ($j = 0; $j <=5 ; $j++)
		{
 {
   			$valor .= ":::".$matriz[$j][$i];
		}
}

$fim=count($matriz2);

for ($i = 0; $i <= $fim; $i++)
 {
	for ($j = 0; $j <=3 ; $j++)
		{
			$valor.= ":::".$matriz2[$j][$i];
		}
}

echo "<center>";
echo "<a href=\"../res_avaliacao/av_imprime_pdf.php?valor=$valor\">Gerar copia para Impressao</a>";
echo "</center>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<center>";
 echo "<a href=\"cnpma.comitegestorsaad@embrapa.br\" class=\"link\" title=\"comissao de progressao salarial\">Contate a comissao por e-mail</a>";
echo "</center>";


rodape();
?>
