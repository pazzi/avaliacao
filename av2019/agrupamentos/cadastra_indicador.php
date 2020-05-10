<?php
include ("../func_avalia.php3");
if (!$_GET["id"])
	{
	  echo "Parametro id deve ser passado na referencia - contate o suporte";
	  exit();
	}else
		{
			$id_agrup=$_GET["id"];
			$ano_agrup=$_GET["ano"];
		}
cabecalho();

function lista_agrupamentos($id_agrup)
	{
		GLOBAL $BD4;
		$str_sql_0="select $BD4.Agrupamento.descricao, $BD4.Agrupamento.ano_referencia, $BD4.Indicador.desc_indicador, $BD4.z_indicador.peso, $BD4.z_fontes.descricao, $BD4.z_itens.peso
		FROM $BD4.Agrupamento, $BD4.z_indicador, $BD4.Indicador, $BD4.z_itens, $BD4.z_fontes
		WHERE $BD4.Agrupamento.cod_agrupamento=$id_agrup
		AND $BD4.Agrupamento.cod_agrupamento=$BD4.z_indicador.cod_agrupamento
		AND $BD4.z_indicador.cod_indicador=$BD4.Indicador.cod_indicador
		AND $BD4.z_indicador.id=$BD4.z_itens.id_indicador
		AND $BD4.z_itens.id_fonte=$BD4.z_fontes.id
		ORDER BY $BD4.Indicador.desc_indicador;";
		$ret_0=sql($BD4,$str_sql_0);

##echo "str: $str_sql_0<br>"; # Ana Paula
		return($ret_0);
	}

function lista_indicador()
	{
		GLOBAL $BD4;
		$str_sql_1="select * FROM $BD4.Indicador order by $BD4.Indicador.desc_indicador";
		$ret=sql($BD4,$str_sql_1);
		return($ret);
	}

function lista_fontes($ano_agrup)
	{
		GLOBAL $BD4;
		$str_sql="select * FROM $BD4.z_fontes where $BD4.z_fontes.ano_base='$ano_agrup' order by $BD4.z_fontes.descricao";
		$ret=sql($BD4,$str_sql);
		return($ret);
	}

echo "<center>";
echo "<h4>Preparacao de parametros para o processo de avaliacao de desempenho ref. ano - ".$ano_agrup. "</h4>";
echo "</center>";
echo "<br>";
echo "<br>";
echo "<a href=./agrup.php?ano=$ANO_REF>Voltar para agrupamentos</a>";
echo "<br>";
echo "<br>";

echo  "<form  action=\"cadastra_indicador_grava.php\" method=\"POST\" >\n";
echo "<INPUT TYPE=\"hidden\" NAME=\"ano_agrup\" VALUE=$ano_agrup>";
echo "<INPUT TYPE=\"hidden\" NAME=\"id_agrup\" VALUE=$id_agrup>";


echo "<div class=\"row\">";
	echo "<div class=\"col-5\">";
	$ret_0=lista_indicador();
		echo "<div class=\"row\">";
		echo "<div class=\"col-5\">\n";
			echo "<SELECT  NAME=\"codIndicador\">\n";
				while ($lista0=mysql_fetch_row($ret_0))
					{
						echo "<option value=\"$lista0[0]\">";
						echo  $lista0[1];
						echo "</option>\n";
					}

			echo "</SELECT>";
		echo "</div>\n";
		echo "<div class=\"col-3\">";
			echo "Peso: ";
			echo "<SELECT  NAME=\"pesoIndicador\">\n";
				for ($y=1; $y<=100; $y++)
					{
						echo "<option value=\"$y\">";
						echo  $y;
						echo "</option>\n";
					}
			echo "</SELECT>";
		echo "</div>";
		echo "</div>\n";
echo "<br>";
	$ret_1=lista_fontes($ano_agrup);
	$i=0;
		while ($lista1=mysql_fetch_row($ret_1))
			{
		echo "<div class=\"row\">";
		echo "<div class=\"col-6\">";
#		echo "<input type=checkbox  name=fonte[] value=\"$lista1[0]\">";
		echo  $lista1[1];
		echo "</div>\n";

		echo "<div class=\"col-3\">";
		echo "Peso: ";
#		echo "<SELECT NAME=\"pesoFonte[]\">\n";
		echo "<input type=\"hidden\"  NAME=\"fonte[]\" value=\"".$lista1[0]. "\">\n";
		echo "<input type=\"text\"  NAME=\"pesoFonte[]\">\n";
/*
			for ($z=1; $z<=100; $z++)
				{
					echo "<option value=\"$z\">";
					echo  $z;
					echo "</option>\n";
				}
		echo "</SELECT>";
*/
		echo "</div>\n";
		echo "</div>";
		echo "<BR>";
	$i++;

	}
echo "<br>";
echo "<center>";
echo "<button type=\"submit\" class=\"btn btn-danger\" name=\"Submit\">Atualizar BD</button>";
echo "</center>";
echo "</form>\n";

echo "</div>";
echo "<div class=\"col-7\">";
echo "<h5>Indicadores e fontes definidos</h5>";
echo nome_agrupamento($id_agrup);
echo $ano_agrup;
echo "<div class=\"table-responsive-sm\">";
echo "<table class=\"table table-sm\">";
echo "<tr>";
	echo "<td>";
		echo "Indicador";
	echo "</td>";
	echo "<td>";
		echo "Peso de indicador";
	echo "</td>";
	echo "<td>";
		echo "Fontes";
	echo "</td>";
	echo "<td>";
		echo "Pesos de fonte";
	echo "</td>";
echo "</tr>";
$ret_func=lista_agrupamentos($id_agrup);
while ($lista2 = mysql_fetch_row($ret_func))
	{
		echo "<tr>";
			echo "<td>";
				echo $lista2[2];
			echo "</td>";
			echo "<td>";
				echo $lista2[3];
			echo "</td>";
			echo "<td>";
				echo $lista2[4];
			echo "</td>";
			echo "<td>";
				echo $lista2[5];
			echo "</td>";
			echo "<td>";
		echo "</tr>";
	}
echo "</table>";
echo "</div>";
echo "</div>";
echo "</div>";

echo "<center>";
rodape();
echo "</center>";
?>
