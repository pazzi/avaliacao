<?php
include ("../func_avalia.php3");

$cont_sup=0;
$cont_cli=0;
$cont_memorial=0;

function verifica_agrupamento($valor){
	GLOBAL $ANO_REF;
	GLOBAL $BD4;
	$str_ver_agrup="SELECT numero from Agrupamento where cod_agrupamento='$valor' and ano_referencia='$ANO_REF'";
        $res_ver_agrup=sql($BD4,$str_ver_agrup);
	$num_agrup=mysql_result($res_ver_agrup,0,"numero");
        return $num_agrup;
}

function nome_agrupamento($valor){
	GLOBAL $ANO_REF;
	GLOBAL $BD4;
	$str_ver_agrup="SELECT descricao from Agrupamento where numero='$valor' and ano_referencia='$ANO_REF'";
        $res_ver_agrup=sql($BD4,$str_ver_agrup);
	$nome_agrup=mysql_result($res_ver_agrup,0,"descricao");
        return $nome_agrup;
}


function avaliacao_supervisor($matricula,$supervisor,$id_agrupamento)
	{
		GLOBAL $ANO_REF;
		GLOBAL $BD4;
			echo "<br>";
                echo "<u>Tera avaliacao de competencias por:</u>";
                echo lista_nome($supervisor);
                $cod_aval_num=1;
		echo "<br>";
	}

function avaliacao_360($matricula,$supervisor,$id_agrupamento,$cod_setor)
	{	
		GLOBAL $ANO_REF;
		GLOBAL $BD4;
                    $cod_aval_num=3;
			$count_ocorrencia=0;
			echo "<br>";
                   	echo "<u>Farah a avaliacao de competencias 360 de:</u>"; 
			echo "<br>";
			$sql_str360="SELECT matr FROM elegiveis WHERE matr <> '$matricula' AND matr <> '$supervisor' AND cod_setor='$cod_setor'";
			$res1=sql($BD4, $sql_str360);                
                        while ($lis1=mysql_fetch_row($res1))
			{
			echo lista_nome($lis1[0]);
                        $count_ocorrencia++;
			echo "<br>";
  			}
	}

function cont_tec_memorial($matricula,$supervisor,$id_agrupamento)
	{
		GLOBAL $ANO_REF;
		GLOBAL $BD4;
			echo "<br>";
                   	echo "<u>Entregarah  o memorial para a avaliacao de:</u>"; 
                    $cod_aval_num=2;

			echo lista_nome($supervisor);
			echo "<br>";
	}

function engajamento_prod($matricula,$supervisor,$id_agrupamento)
	{
		GLOBAL $ANO_REF;
		GLOBAL $BD4;

                    $cod_aval_num=99;   
			echo "<br>";
                   	echo "<u>Terah  o  seu engajamento de producao avaliado por:</u>"; 

			echo lista_nome($supervisor);
			echo "<br>";
	}

function engajamento_memorial($matricula,$supervisor,$id_agrupamento)
	{
		GLOBAL $ANO_REF;
		GLOBAL $BD4;

                    $cod_aval_num=88;

			echo "<br>";
                   	echo "<u>Terah  o  seu  memorial de engajamento  avaliado por:</u>"; 

			echo lista_nome($supervisor);
			echo "<br>";
	}


function lista_avaliacao_de_supervisao($matricula,$supervisor,$id_agrupamento,$cod_setor)
        {     
                GLOBAL $ANO_REF;
                GLOBAL $BD4;
                    $cod_aval_num=3;
                        echo "<br>";
                        echo "<u>Farah a avaliacao de supervisao de:</u>";
                        echo "<br>";
			$sql_str_sup="SELECT matr FROM elegiveis WHERE matr <> '$matricula'  AND cod_setor='$cod_setor'";
                        $res3=sql($BD4, $sql_str_sup);
                        while ($lis3=mysql_fetch_row($res3))
                        {
                        echo lista_nome($lis3[0]);
                        echo "<br>";
                        }
        }


function lista_restricao()
        {     
                GLOBAL $ANO_REF;
                GLOBAL $BD4;
                        echo "<br>";
                        echo "<u>Empregados que por algum motivo nao terao avaliacao:</u>";
                        echo "<br>";
			$sql_str_sup="SELECT matr FROM elegiveis WHERE elegivel='0' AND  cod_setor='$cod_setor'";
                        $res3=sql($BD4, $sql_str_sup);
                        while ($lis3=mysql_fetch_row($res3))
                        {
                        echo lista_nome($lis3[0]);
                        echo "<br>";
                        }
        }


function conta_360($matricula,$supervisor,$id_agrupamento,$cod_setor)
	{	
		GLOBAL $ANO_REF;
		GLOBAL $BD4;
                    $cod_aval_num=3;
			$count_ocorrencia=0;
			$sql_str360="SELECT matr FROM elegiveis WHERE matr <> '$matricula' AND matr <> '$supervisor' AND cod_setor='$cod_setor'";
			$res1=sql($BD4, $sql_str360);                
                        while ($lis1=mysql_fetch_row($res1))
			{
                        $count_ocorrencia++;
  			}
 		return $count_ocorrencia;
	}

function realiza_ava_supervisao($matricula,$supervisor,$id_agrupamento,$cod_setor)
	{	
		GLOBAL $ANO_REF;
		GLOBAL $BD4;
			$count_ocorrencia=0;
			$sql_sup="SELECT matr FROM elegiveis WHERE superviso = '$supervisor' AND cod_setor='$cod_setor' AND ano='$ANO_REF'";
			$res1=sql($BD4, $sql_sup);                
                        while ($lis1=mysql_fetch_row($res1))
			{
                        $count_ocorrencia++;
  			}
 		return $count_ocorrencia;

cabecalho();
$cont_sup=0;
$cont_cli=0;
$cont_memorial=0;

$sql_str="SELECT * 
                 FROM elegiveis
                 where ano='$ANO_REF'
                 ORDER BY matr"; 


$res0=sql($BD4,$sql_str);

while($lis0=mysql_fetch_row($res0))
 {
   $matricula=$lis0[1];
   $supervisor=$lis0[2];
   $id_agrupamento=$lis0[4];
   $cod_agrupamento=verifica_agrupamento($lis0[4]);
   $cod_setor=$lis0[7];
   echo "<b>";
   echo lista_nome($matricula);
   echo "</b>";
   echo "<br>";


	switch($cod_agrupamento){
                              		case 1:
						avaliacao_supervisor($matricula,$supervisor,$id_agrupamento);
                                                $count_aval_sup[$cod_agrupamento]++;
						avaliacao_360($matricula,$supervisor,$id_agrupamento,$cod_setor);
                                                $count_aval_360[$cod_agrupamento]= $count_aval_360[$cod_agrupamento] + conta_360($matricula,$supervisor,$id_agrupamento,$cod_setor);
						cont_tec_memorial($matricula,$supervisor,$id_agrupamento);
                                                $count_tec_memorial[$cod_agrupamento]++;
						engajamento_prod($matricula,$supervisor,$id_agrupamento);
                                                $count_eng_producao[$cod_agrupamento]++;
						break;
                              		case 2:
						avaliacao_supervisor($matricula,$supervisor,$id_agrupamento);
                                                $count_aval_sup[$cod_agrupamento]++;
						engajamento_memorial($matricula,$supervisor,$id_agrupamento);
                                                $count_eng_memorial[$cod_agrupamento]++;
						break;
                              		case 3:
						avaliacao_supervisor($matricula,$supervisor,$id_agrupamento);
                                                $count_aval_sup[$cod_agrupamento]++;
						avaliacao_360($matricula,$supervisor,$id_agrupamento,$cod_setor);
                                                $count_aval_360[$cod_agrupamento]= $count_aval_360[$cod_agrupamento] + conta_360($matricula,$supervisor,$id_agrupamento,$cod_setor);
						engajamento_memorial($matricula,$supervisor,$id_agrupamento);
                                                $count_eng_memorial[$cod_agrupamento]++;
						break;
                              		case 4:
						avaliacao_supervisor($matricula,$supervisor,$id_agrupamento);
                                                $count_aval_sup[$cod_agrupamento]++;
						avaliacao_360($matricula,$supervisor,$id_agrupamento,$cod_setor);
                                                $count_aval_360[$cod_agrupamento]= $count_aval_360[$cod_agrupamento] + conta_360($matricula,$supervisor,$id_agrupamento,$cod_setor);
						engajamento_memorial($matricula,$supervisor,$id_agrupamento);
                                                $count_eng_memorial[$cod_agrupamento]++;
						break;
                              		case 5:
						avaliacao_supervisor($matricula,$supervisor,$id_agrupamento);
                                                $count_aval_sup[$cod_agrupamento]++;
						avaliacao_360($matricula,$supervisor,$id_agrupamento,$cod_setor);
                                                $count_aval_360[$cod_agrupamento]= $count_aval_360[$cod_agrupamento] + conta_360($matricula,$supervisor,$id_agrupamento,$cod_setor);
						engajamento_memorial($matricula,$supervisor,$id_agrupamento);
                                                $count_eng_memorial[$cod_agrupamento]++;
						break;
                              		case 6:
						avaliacao_supervisor($matricula,$supervisor,$id_agrupamento);
                                                $count_aval_sup[$cod_agrupamento]++;
						avaliacao_360($matricula,$supervisor,$id_agrupamento,$cod_setor);
                                                $count_aval_360[$cod_agrupamento]= $count_aval_360[$cod_agrupamento] + conta_360($matricula,$supervisor,$id_agrupamento,$cod_setor);
						engajamento_memorial($matricula,$supervisor,$id_agrupamento);
                                                $count_eng_memorial[$cod_agrupamento]++;
						break;
                              		case 7:
						avaliacao_supervisor($matricula,$supervisor,$id_agrupamento);
                                                $count_aval_sup[$cod_agrupamento]++;
						avaliacao_360($matricula,$supervisor,$id_agrupamento,$cod_setor);
                                                $count_aval_360[$cod_agrupamento]= $count_aval_360[$cod_agrupamento] + conta_360($matricula,$supervisor,$id_agrupamento,$cod_setor);
						cont_tec_memorial($matricula,$supervisor,$id_agrupamento);
                                                $count_tec_memorial[$cod_agrupamento]++;
						break;
                              		case 8:
						avaliacao_supervisor($matricula,$supervisor,$id_agrupamento);
                                                $count_aval_sup[$cod_agrupamento]++;
						avaliacao_360($matricula,$supervisor,$id_agrupamento,$cod_setor);
                                                $count_aval_360[$cod_agrupamento]= $count_aval_360[$cod_agrupamento] + conta_360($matricula,$supervisor,$id_agrupamento,$cod_setor);
						engajamento_memorial($matricula,$supervisor,$id_agrupamento);
                                                $count_eng_memorial[$cod_agrupamento]++;
						break;
                              		case 9:
						avaliacao_supervisor($matricula,$supervisor,$id_agrupamento);
                                                $count_aval_sup[$cod_agrupamento]++;
						avaliacao_360($matricula,$supervisor,$id_agrupamento,$cod_setor);
                                                $count_aval_360[$cod_agrupamento]= $count_aval_360[$cod_agrupamento] + conta_360($matricula,$supervisor,$id_agrupamento,$cod_setor);
						engajamento_memorial($matricula,$supervisor,$id_agrupamento);
                                                $count_eng_memorial[$cod_agrupamento]++;
						break;
                              		case 10:
						cont_tec_memorial($matricula,$supervisor,$id_agrupamento);
                                                $count_tec_memorial[$cod_agrupamento]++;
						engajamento_prod($matricula,$supervisor,$id_agrupamento);
                                                $count_eng_producao[$cod_agrupamento]++;
						lista_avaliacao_de_supervisao($matricula,$supervisor,$id_agrupamento,$cod_setor);
						break;
                              		case 11:
						avaliacao_supervisor($matricula,$supervisor,$id_agrupamento);
                                                $count_aval_sup[$cod_agrupamento]++;
						cont_tec_memorial($matricula,$supervisor,$id_agrupamento);
						engajamento_prod($matricula,$supervisor,$id_agrupamento);
                                                $count_eng_producao[$cod_agrupamento]++;
						break;
                              		case 12:
						avaliacao_supervisor($matricula,$supervisor,$id_agrupamento);
                                                $count_aval_sup[$cod_agrupamento]++;
						cont_tec_memorial($matricula,$supervisor,$id_agrupamento);
						engajamento_prod($matricula,$supervisor,$id_agrupamento);
                                                $count_eng_producao[$cod_agrupamento]++;
						break;
                              		case 13:
						avaliacao_supervisor($matricula,$supervisor,$id_agrupamento);
                                                $count_aval_sup[$cod_agrupamento]++;
						avaliacao_360($matricula,$supervisor,$id_agrupamento,$cod_setor);
                                                $count_aval_360[$cod_agrupamento]= $count_aval_360[$cod_agrupamento] + conta_360($matricula,$supervisor,$id_agrupamento,$cod_setor);
						engajamento_memorial($matricula,$supervisor,$id_agrupamento);
                                                $count_eng_memorial[$cod_agrupamento]++;
						break;
                              		case 14:
						avaliacao_supervisor($matricula,$supervisor,$id_agrupamento);
                                                $count_aval_sup[$cod_agrupamento]++;
						avaliacao_360($matricula,$supervisor,$id_agrupamento,$cod_setor);
                                                $count_aval_360[$cod_agrupamento]= $count_aval_360[$cod_agrupamento] + conta_360($matricula,$supervisor,$id_agrupamento,$cod_setor);
						engajamento_memorial($matricula,$supervisor,$id_agrupamento);
                                                $count_eng_memorial[$cod_agrupamento]++;
						break;
                              		case 15:
						cont_tec_memorial($matricula,$supervisor,$id_agrupamento);
                                                $count_tec_memorial[$cod_agrupamento]++;
                                                $count_tec_indicador[$cod_agrupamento]++;
                                                $count_eng_indicador[$cod_agrupamento]++;
						break;
                              		case 16:
						cont_tec_memorial($matricula,$supervisor,$id_agrupamento);
                                                $count_tec_memorial[$cod_agrupamento]++;
						engajamento_prod($matricula,$supervisor,$id_agrupamento);
                                                $count_eng_producao[$cod_agrupamento]++;
						lista_avaliacao_de_supervisao($matricula,$supervisor,$id_agrupamento,$cod_setor);
						break;
                              		case 17:
						avaliacao_supervisor($matricula,$supervisor,$id_agrupamento);
                                                $count_aval_sup[$cod_agrupamento]++;
						avaliacao_360($matricula,$supervisor,$id_agrupamento,$cod_setor);
                                                $count_aval_360[$cod_agrupamento]= $count_aval_360[$cod_agrupamento] + conta_360($matricula,$supervisor,$id_agrupamento,$cod_setor);
						cont_tec_memorial($matricula,$supervisor,$id_agrupamento);
                                                $count_tec_memorial[$cod_agrupamento]++;
						engajamento_prod($matricula,$supervisor,$id_agrupamento);
                                                $count_eng_producao[$cod_agrupamento]++;
						break;
                              		case 18:
						avaliacao_supervisor($matricula,$supervisor,$id_agrupamento);
                                                $count_aval_sup[$cod_agrupamento]++;
						avaliacao_360($matricula,$supervisor,$id_agrupamento,$cod_setor);
                                                $count_aval_360[$cod_agrupamento]= $count_aval_360[$cod_agrupamento] + conta_360($matricula,$supervisor,$id_agrupamento,$cod_setor);
						engajamento_memorial($matricula,$supervisor,$id_agrupamento);
                                                $count_eng_memorial[$cod_agrupamento]++;
						break;
                              		case 19:
						avaliacao_supervisor($matricula,$supervisor,$id_agrupamento);
                                                $count_aval_sup[$cod_agrupamento]++;
						avaliacao_360($matricula,$supervisor,$id_agrupamento,$cod_setor);
                                                $count_aval_360[$cod_agrupamento]= $count_aval_360[$cod_agrupamento] + conta_360($matricula,$supervisor,$id_agrupamento,$cod_setor);
						cont_tec_memorial($matricula,$supervisor,$id_agrupamento);
                                                $count_tec_memorial[$cod_agrupamento]++;
						engajamento_prod($matricula,$supervisor,$id_agrupamento);
                                                $count_eng_producao[$cod_agrupamento]++;
						break;
                              		case 20:
						avaliacao_supervisor($matricula,$supervisor,$id_agrupamento);
                                                $count_aval_sup[$cod_agrupamento]++;
						avaliacao_360($matricula,$supervisor,$id_agrupamento,$cod_setor);
                                                $count_aval_360[$cod_agrupamento]= $count_aval_360[$cod_agrupamento] + conta_360($matricula,$supervisor,$id_agrupamento,$cod_setor);
						cont_tec_memorial($matricula,$supervisor,$id_agrupamento);
                                                $count_tec_memorial[$cod_agrupamento]++;
						engajamento_prod($matricula,$supervisor,$id_agrupamento);
                                                $count_eng_producao[$cod_agrupamento]++;
						break;
                              		case 21:
                                                $count_ava_supervisao[$cod_agrupamento]=$count_ava_supervisao[$cod_agrupamento] + realiza_ava_supervisao($matricula,$supervisao,$id_agrupamento,$cod_setor);
						cont_tec_memorial($matricula,$supervisor,$id_agrupamento);
						engajamento_prod($matricula,$supervisor,$id_agrupamento);
                                                $count_eng_producao[$cod_agrupamento]++;
						lista_avaliacao_de_supervisao($matricula,$supervisor,$id_agrupamento,$cod_setor);
						break;
                              		case 22:
						cont_tec_memorial($matricula,$supervisor,$id_agrupamento);
						engajamento_prod($matricula,$supervisor,$id_agrupamento);
                                                $count_eng_producao[$cod_agrupamento]++;
						lista_avaliacao_de_supervisao($matricula,$supervisor,$id_agrupamento,$cod_setor);
						break;

				}


 echo "************************************************************************************************************************************************************************";
 echo "<br>";
 echo "<br>";
  }

echo "<br>";
echo "<br>";
echo "<br>";
echo "<u>RESTRICOES:</u>";
echo "<br>";
echo "<br>";
lista_restricao();
echo "<br>";
echo "<br>";

echo "<table class=\"table table-bordered\">";
echo "<tr>";
echo "<thead>";
echo "<th>";
echo "Agrupamento";
echo "</th>";
echo "<th>";
echo "Avaliacao Supervisao";
echo "</th>";
echo "<th>";
echo "Avaliacao 360";
echo "</th>";
echo "<th>";
echo "Avaliacao CT Memorial";
echo "</th>";
echo "<th>";
echo "Avaliacao Eng Memorial";
echo "</th>";
echo "<th>";
echo "Avaliacao Eng Producao";
echo "</th>";
echo "<th>";
echo "Avaliacao CT Indicadores";
echo "</th>";
echo "<th>";
echo "Avaliacao Eng Indicadores";
echo "</th>";
echo "</thead>";
echo "</tr>";

for ($i=1; $i<=22; $i++)
{
	echo "<tr>";
	echo "<tbody>";
	echo "<td>";
	echo  nome_agrupamento($i);
	echo "</td>";
	echo "<td>";
	echo  $count_aval_sup[$i];
        $g[0] += $count_aval_sup[$i];
	echo "</th>";
	echo "<td>";
	echo $count_aval_360[$i];
        $g[1] += $count_aval_360[$i];
	echo "</td>";
	echo "<td>";
	echo $count_tec_memorial[$i];
        $g[2] += $count_tec_memorial[$i];
	echo "</td>";
	echo "<td>";
	echo $count_eng_memorial[$i];
        $g[3] += $count_eng_memorial[$i];
	echo "</td>";
	echo "<td>";
	echo $count_eng_producao[$i];
        $g[4] += $count_eng_producao[$i];
	echo "</td>";
	echo "<td>";
	echo $count_tec_indicador[$i];
        $g[5] += $count_tec_indicador[$i];
	echo "</td>";
	echo "<td>";
	echo $count_eng_indicador[$i];
        $g[6] += $count_eng_indicador[$i];
	echo "</td>";
	echo "</tbody>";
	echo "</tr>";
}
echo "<tr class=\"info\">";
echo "<td>"; 
echo "Totais";
echo "</td>"; 
for ($i=0; $i<=6; $i++)
{
	echo "<td>";
	echo $g[$i];
        $total=$total+$g[$i];
	echo "</td>";
}
echo "</tr>";
echo "</table>";
echo "<b>";
echo $total;
echo "</b>";
echo " <u> avaliacoes</u> - entre avaliacoes de competencias de supervisores, avaliacoes de competencias 360, memoriais tecnicos, memoriais de engajamento, e avaliacoes de engajamento(producao)";
 


rodape();
?>
