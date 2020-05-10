<?php
include ("../func_avalia.php3");

if (!$_GET["parm"])
    {
    $senha=$_POST["password"];
    $user=$_POST["user"];
    setcookie("cookie_senha_aval",$senha);
    setcookie("cookie_user_aval",$user);
    }
     else
         {
           $password=$_COOKIE["cookie_senha_aval"];
           $user=$_COOKIE["cookie_user_aval"];
         }

$passagem=explode(":::",$_GET["id"]);
$id=$passagem[0];
$matr=$passagem[1];


cabecalho();

echo "<br>";
echo "<center>";
#echo "<a href=\"lista_sub.php3\">Voltar</a>";
echo "</center>";
echo "<br>";
echo "<br>";
echo "<center>A v a l i a c a o  - $ANO_AVAL - A n o &nbsp;&nbsp; B a s e  - $ANO_REF</center>";
echo "<br>";
echo "<br>";
echo "<center><h3>".lista_nome($matr)."</h3></center>";
echo "<br>";
echo "<center>";
echo "<h3>R E S U M O</h3>";
echo "<br>";
echo "<table class=\"table table-bordered\">";
echo "<thead>";
echo "<tr>";
echo "<td>";
echo "Grupo";
echo "</td>";
echo "<td>";
echo "Média";
echo "</td>";
echo "</tr>";
echo "</thead>";
echo "<tbody>";
 $ret_func= busca_medias_competencia_por_codigo($id);
 $return=sql($BD4, $ret_func);
 $contador=0;
 $soma_nota=0;
 $relato='';
 $memorial='';
 $ind_producao='';
 $ind_engajamento='';
 while ($lista=mysql_fetch_row($return))
         {
	   switch($lista[0])
		{
			case 1:
			case 2:
			case 3:
          			echo "<tr>";
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
				break;
			case 5:
				$memorial=$lista[1];
				break;
			case 6:
				$relato=$lista[1];
				break;
			case 7:
				$ind_producao=$lista[1];
				break;
			case 8:
				$ind_engajamento=$lista[1];
				break;
		}
	  
         }
$media_sup=$soma_nota/$contador;
echo "<tr><td>Media competencias comportamentais (supervisor)</td><td>". ($media_sup<>''?$media_sup:'***') ."</td></tr>";
echo "<tr><td>Nota memorial</td><td>". ($memorial<>''?$memorial:'***'). "</td></tr>";
echo "<tr><td>Nota engajamento</td><td>".($relato<>''?$relato:'***')."</td></tr>";
echo "<tr><td>Nota indicador de producao</td><td>".($ind_producao<>''?$ind_producao:'***')."</td></tr>";
echo "<tr><td>Nota indicador de engajamento</td><td>".($ind_engajamento<>''?$ind_engajamento:'***')."</td></tr>";
echo "</tbody>";
echo "</table>";
echo "</center>";

echo "<br>";
echo "<br>";
echo "<br>";
echo "<center>";
echo "Notas em cada item de competencia";
echo "</center>";
echo "<br>";


echo "<center>";
echo "<table class=\"table table-bordered\">";
echo "<thead>";
echo "<tr><td>Competencia</td><td>Item</td><td>Valor</td><td>Escala</td></tr>";
echo "</thead>";
echo "<tbody>";
 $ret_func= busca_media_por_codigo($id);
 $return=sql($BD4, $ret_func);
 $contador=0;
 $soma_nota=0;
 $relato='';
 $memorial='';
 $ind_producao='';
 $ind_engajamento='';
 while ($lista=mysql_fetch_row($return))
         {
		switch($lista[2])
			{
				case 1:
				case 2:
				case 3:
				  echo "<tr>";
				  echo "<td>\n";
				  echo $lista[2];
				  echo "</td>\n";
				  echo "<td>\n";
				  $msg=retorna_texto($lista[0]);
				  echo $msg;
				  echo "</td>";
				  echo "<td>";
				  echo $lista[1];
				  echo "</td>\n";
				  echo "<td>";
				  echo ver_escala($lista[1]);
				  echo "</td>\n";
				  echo "</tr>\n";
				  $contador++;
				  $soma_nota=$soma_nota+$lista[1];
				  break;
				case 5:
					$memorial=$lista[1];
					break;
				case 6:
					$relato=$lista[1];
					break;
				case 7:
					$ind_producao=$lista[1];
					break;
				case 8:
					$ind_engajamento=$lista[1];
					break;
			}
         }
echo "</body>";
echo "</table>";
echo "</center>";

$str_sql_cod="select codigo_pesquisa from Pesquisa_Opiniao where matricula='$matr' AND codigo_aval=2 AND ano_pesq='$ANO_REF'";
$ret_sql_cod=sql($BD4,$str_sql_cod);
$codigo=mysql_result($ret_sql_cod,0,'codigo_pesquisa');
$str_sql="select desc_memorial from Memorial where codigo_pesquisa='$codigo'";
$ret=sql($BD4,$str_sql);
$texto_memorial=mysql_result($ret,0,"desc_memorial");
echo "<br>";
echo "<h4>Memorial/Relato do Empregado</h4>";
echo $texto_memorial;
echo "<br>";
echo "<br>";
echo "<table class=\"table table-striped\">";
echo "<tr><td>Nota memorial</td><td>". ($memorial<>''?$memorial:'***'). "</td></tr>";
echo "<tr><td>Nota engajamento</td><td>".($relato<>''?$relato:'***')."</td></tr>";
echo "<tr><td>Nota indicador de producao</td><td>".($ind_producao<>''?$ind_producao:'***')."</td></tr>";
echo "<tr><td>Nota indicador de engajamento</td><td>".($ind_engajamento<>''?$ind_engajamento:'***')."</td></tr>";
echo "</tbody>";
echo "</table>";
echo "</center>";

##############

	
$str_sql_lista="select $BD1.empregados.matr, $BD1.empregados.nome, $BD1.empregados.local, $BD4.elegiveis.cod_agrupamento, $BD4.elegiveis.supervisor, $BD4.elegiveis.cod_setor 
			from $BD1.empregados,$BD4.elegiveis 
			where $BD1.empregados.matr='$matr'
			and $BD1.empregados.matr=$BD4.elegiveis.matr
			and $BD4.elegiveis.ano='$ANO_REF'  
			and $BD4.elegiveis.elegivel='1' 
			ORDER BY $BD4.elegiveis.cod_agrupamento, $BD1.empregados.nome";
$res_lista=sql($BD4,$str_sql_lista);
while ($liste = mysql_fetch_row($res_lista))
	{ 
		$matr_ret=$liste[0];
		$nome=$liste[1];
                $local_ret=$liste[2];
		$agrupamento=$liste[3];
		$supervisor=$liste[4];
		$setor=$liste[5];

		$ret_func= busca_medias_competencia(1,$matr,$ANO_REF);
		$return=sql($BD4, $ret_func);
	 
		$contador=0;
		$soma_nota=0;
		$media_sup=0;
		$memorial=0;
		$relato=0;
		$ind_producao=0;
		$ind_engajamento=0;


############################################################################################################
#FUNCAO obtem_nfi($agrupamento, valor) - o valor deve ser obtido em "id" de z_fontes vai variar de ano a ano
# Em ano ref 2019 alterar os ids das fontes para os correspondentes no ano de referencia:
# em 2019: avaliador: 13; memorail-14; relato: 15; producao: 16; engajamento: 17; 
# Alterado por Ana Paula em 24/03/2020
############################################################################################################
                while ($lista=mysql_fetch_row($return))
                                {
                                        switch ($lista[0])
                                                {
                                                        case 1:
                                                        case 2:
                                                        case 3:
                                                                $contador++;
                                                                $soma_nota=$soma_nota+$lista[1];
                                                                break;
                                case 5:
                                        $memorial=$lista[1];
                                        $nota_nfi_memorial= $memorial * obtem_nfi($agrupamento,14);
                                        break;
                                case 6:
                                        $relato=$lista[1];
                                        $nota_nfi_relato= $relato * obtem_nfi($agrupamento,15);
                                        break;
                                case 7:
                                        $ind_producao=$lista[1];
                                        $nota_nfi_ind_producao= $ind_producao * obtem_nfi($agrupamento,16);
                                        break;
                                case 8:
                                        $ind_engajamento=$lista[1];
                                        $nota_nfi_ind_engajamento= $ind_engajamento * obtem_nfi($agrupamento,17);
                                        break;

                                                }
                                }
        $media_sup=$soma_nota/$contador;
        $nota_nfi_supervisor=$media_sup * obtem_nfi($agrupamento,13);



$nfi = $nota_nfi_supervisor + $nota_nfi_memorial + $nota_nfi_relato + $nota_nfi_ind_engajamento + $nota_nfi_ind_producao;

# ana Paula - comentar depois
##echo "<br>aqui: NFI: nota_nfi_supervisor + nota_nfi_memorial + nota_nfi_relato + nota_nfi_ind_engajamento + nota_nfi_ind_producao<br>";
##echo "aqui: $nota_nfi_supervisor + $nota_nfi_memorial + $nota_nfi_relato + $nota_nfi_ind_engajamento + $nota_nfi_ind_producao";

}

echo "<br>";
echo "<center>";
echo "<table class=\"table table-striped\">";
echo "<tr><td>NFI</td><td align=\"right\">". $nfi. "</td></tr>";
echo "</table>";
echo "</center>";


rodape();
?>
