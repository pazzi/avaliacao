<?php
include ("../func_avalia.php3");
cabecalho();
function busca_nome_indicador($id)
	{
		GLOBAL $BD4;
		$str_sql_1="select $BD4.Indicador.desc_indicador FROM $BD4.Indicador WHERE $BD4.Indicador.cod_indicador='$id'";
		$ret_1=sql($BD4,$str_sql_1);
		$ret_desc=mysql_result($ret_1,0,"desc_indicador");
		return($ret_desc);
	}

function busca_nome_fonte($id)
	{
		GLOBAL $BD4;
		$str_sql_2="select $BD4.z_fontes.descricao FROM $BD4.z_fontes WHERE $BD4.z_fontes.id='$id'";
		$ret_2=sql($BD4,$str_sql_2);
		$ret_fonte=mysql_result($ret_2,0,"descricao");
		return($ret_fonte);
	}

/*
$str_sql_agrup="select $BD4.Agrupamento.* from $BD.Agrupamento where $BD4.Agrupamento.ano_referencia='$ANO_REF' ORDER BY $BD4.Agrupamento.numero";
$res_lista=sql($BD4,$str_sql_agrup);
echo "<table class=\"table table\">";
while ($liste = mysql_fetch_row($res_lista))
        {
			echo "<tr>";
			echo "<td>";
                        echo $liste[0];
                        echo " - ";
                        echo $liste[1];
                        echo " - ";
                        echo $liste[2];
                        echo " - ";
                        echo $liste[3];
                        echo " </td>";
                        echo " </tr>";
			$str_sql_indicador="select $BD4.z_indicador.* FROM $BD4.z_indicador WHERE $BD4.z_indicador.cod_agrupamento='$liste[0]' ORDER BY $BD4.z_indicador.cod_indicador";
			$res_indic=sql($BD4,$str_sql_indicador);
			
			while ($listaa = mysql_fetch_row($res_indic))
				{
					echo "<tr>";
					echo "<td>";
					echo $listaa[0];
					echo " - ";
					echo $listaa[1];
					echo " - ";
					echo busca_nome_indicador($listaa[2]);
					echo " - ";
					echo $listaa[3];
					$str_sql_fonte="select $BD4.z_itens.* FROM $BD4.z_itens WHERE $BD4.z_itens.id_indicador='$listaa[0]' ORDER BY $BD4.z_itens.id_indicador";
					$res_fonte=sql($BD4,$str_sql_fonte);
					while ($listac = mysql_fetch_row($res_fonte))
						{
							echo "------";
							echo $listac[0];
							echo " - ";
							echo $listac[1];
							echo " - ";
							echo busca_nome_fonte($listac[2]);
							echo " - ";
							echo $listac[3];
							
							
						}

					echo "</td>";
					echo "</td>";
				}
			echo "<tr>";
			echo "<td>";
			echo "  ";
			echo "</td>";
			echo "</tr>";
					
	}
echo "</table>";

echo "<br>";
echo "<br>";
echo "<br>";
*/
echo "<br>";
echo "<br>";
echo "<center>";
echo "<h3>Agrupamentos, indicadores, fontes, pesos</h3>";
echo "</center>";
echo "<br>";


$sql_str="select Agrupamento.descricao, z_indicador.peso, Indicador.desc_indicador,z_fontes.descricao,z_fontes.ano_base,z_itens.peso 
from Agrupamento, z_indicador,z_itens, Indicador, z_fontes
where Agrupamento.cod_agrupamento=z_indicador.cod_agrupamento
and z_indicador.cod_indicador=Indicador.cod_indicador
and z_indicador.id=z_itens.id_indicador
and z_fontes.id=z_itens.id_fonte
order by z_fontes.ano_base, Agrupamento.descricao, Indicador.desc_indicador";

$res_fonte4=sql($BD4,$sql_str);

echo "<center>";
echo "<table class=table>";
while ($listad = mysql_fetch_row($res_fonte4))
	{
		echo "<tr>\n";
			echo "<td>";
				echo $listad[0];
			echo "</td>";
			echo "<td>";
				echo $listad[1];
			echo "</td>";
			echo "<td>";
				echo $listad[2];
			echo "</td>";
			echo "<td>";
				echo $listad[3];
			echo "</td>";
			echo "<td>";
				echo $listad[4];
			echo "</td>";
			echo "<td>";
				echo $listad[5];
			echo "</td>";
		echo "</tr>\n";

	}

echo "</table>";
echo "</center>";


echo "<br>";
echo "<br>";
echo "<br>";
rodape();
?>
