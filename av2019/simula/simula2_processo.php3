<?php
include ("../func_avalia.php3");

function verifica_agrupamento($valor){
	GLOBAL $ANO_REF;
	GLOBAL $BD4;
	$str_ver_agrup="SELECT numero from Agrupamento where cod_agrupamento='$valor' and ano_referencia='$ANO_REF'";
        $res_ver_agrup=sql($BD4,$str_ver_agrup);
	$num_agrup=mysql_result($res_ver_agrup,0,"numero");
        return $num_agrup;
}


function avaliacao_supervisor($matricula,$supervisor,$id_agrupamento)
	{
		GLOBAL $ANO_REF;
		GLOBAL $BD4;
			echo "<br>";
                echo "Tera avaliacao de competencias por:";
                echo lista_nome($supervisor);
                $cod_aval_num=1;
		echo "<br>";
	}

function avaliacao_360($matricula,$supervisor,$id_agrupamento,$cod_setor)
	{	
		GLOBAL $ANO_REF;
		GLOBAL $BD4;
                    $cod_aval_num=3;
			echo "<br>";
                   	echo "Farah a avaliacao de competencias de:"; 
			echo "<br>";
			$sql_str360="SELECT matr FROM elegiveis WHERE matr <> '$matricula' AND matr <> '$supervisor' AND cod_setor='$cod_setor'";
			$res1=sql($BD4, $sql_str360);                
                        while ($lis1=mysql_fetch_row($res1))
			{
			echo lista_nome($lis1[0]);
			echo "<br>";
  			}
	}

function cont_tec_memorial($matricula,$supervisor,$id_agrupamento)
	{
		GLOBAL $ANO_REF;
		GLOBAL $BD4;
			echo "<br>";
                   	echo "Entregarah  o memorial para a avaliacao de:"; 
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
                   	echo "Terah  o  seu engajamento de producao avaliado por:"; 

			echo lista_nome($supervisor);
			echo "<br>";
	}

function engajamento_memorial($matricula,$supervisor,$id_agrupamento)
	{
		GLOBAL $ANO_REF;
		GLOBAL $BD4;

                    $cod_aval_num=88;

			echo "<br>";
                   	echo "Terah  o  seu  memorial de engajamento  avaliado por:"; 

			echo lista_nome($supervisor);
			echo "<br>";
	}



function lista_avaliacao_de_supervisao($matricula,$supervisor,$id_agrupamento,$cod_setor)
        {      
                GLOBAL $ANO_REF;
                GLOBAL $BD4;
                    $cod_aval_num=3;
                        echo "<br>";
                        echo "Farah a avaliacao de supervisao de:";
                        echo "<br>";
                        $sql_str_sup="SELECT matr FROM elegiveis WHERE matr <> '$matricula' AND matr <> '$supervisor' AND supervisor='$supervisor' AND cod_setor='$cod_setor'";
                        $res1=sql($BD4, $sql_str_sup);
                        while ($lis3=mysql_fetch_row($res3))
                        {
                        echo lista_nome($lis3[0]);
                        echo "<br>";
                        }
        }




cabecalho();
$cont_sup=0;
$cont_cli=0;
$cont_memorial=0;

$sql_str="SELECT * 
                 FROM Pesquisa_Opiniao 
                 where ano='$ANO_REF'
                 ORDER BY matricula_superv"; 


$res0=sql($BD4,$sql_str);

while($lis0=mysql_fetch_row($res0))
 {
   $matricula=$lis0[2];
   $supervisor=$lis0[5];

   $id_agrupamento=$lis0[4];
   $cod_agrupamento=verifica_agrupamento($lis0[4]);
   $cod_setor=$lis0[7];
   echo "<b>";
   echo lista_nome($supervisor);
   echo "</b>";
   echo "<br>";


	switch($cod_agrupamento){
                              		case 1:
						avaliacao_supervisor($matricula,$supervisor,$id_agrupamento);
						avaliacao_360($matricula,$supervisor,$id_agrupamento,$cod_setor);
						cont_tec_memorial($matricula,$supervisor,$id_agrupamento);
						engajamento_prod($matricula,$supervisor,$id_agrupamento);
						break;
                              		case 2:
						avaliacao_supervisor($matricula,$supervisor,$id_agrupamento);
						engajamento_memorial($matricula,$supervisor,$id_agrupamento);
						break;
                              		case 3:
						avaliacao_supervisor($matricula,$supervisor,$id_agrupamento);
						avaliacao_360($matricula,$supervisor,$id_agrupamento,$cod_setor);
						engajamento_memorial($matricula,$supervisor,$id_agrupamento);
						break;
                              		case 4:
						avaliacao_supervisor($matricula,$supervisor,$id_agrupamento);
						avaliacao_360($matricula,$supervisor,$id_agrupamento,$cod_setor);
						engajamento_memorial($matricula,$supervisor,$id_agrupamento);
						break;
                              		case 5:
						avaliacao_supervisor($matricula,$supervisor,$id_agrupamento);
						avaliacao_360($matricula,$supervisor,$id_agrupamento,$cod_setor);
						engajamento_memorial($matricula,$supervisor,$id_agrupamento);
						break;
                              		case 6:
						avaliacao_supervisor($matricula,$supervisor,$id_agrupamento);
						avaliacao_360($matricula,$supervisor,$id_agrupamento,$cod_setor);
						engajamento_memorial($matricula,$supervisor,$id_agrupamento);
						break;
                              		case 7:
						avaliacao_supervisor($matricula,$supervisor,$id_agrupamento);
						avaliacao_360($matricula,$supervisor,$id_agrupamento,$cod_setor);
						cont_tec_memorial($matricula,$supervisor,$id_agrupamento);
						engajamento_prod($matricula,$supervisor,$id_agrupamento);
						break;
                              		case 8:
						avaliacao_supervisor($matricula,$supervisor,$id_agrupamento);
						avaliacao_360($matricula,$supervisor,$id_agrupamento,$cod_setor);
						engajamento_memorial($matricula,$supervisor,$id_agrupamento);
						break;
                              		case 9:
						avaliacao_supervisor($matricula,$supervisor,$id_agrupamento);
						avaliacao_360($matricula,$supervisor,$id_agrupamento,$cod_setor);
						engajamento_memorial($matricula,$supervisor,$id_agrupamento);
						break;
                              		case 10:
						cont_tec_memorial($matricula,$supervisor,$id_agrupamento);
						engajamento_prod($matricula,$supervisor,$id_agrupamento);
					        lista_avaliacao_de_supervisao($matricula,$supervisor,$id_agrupamento,$cod_setor)
	
						break;
                              		case 11:
						avaliacao_supervisor($matricula,$supervisor,$id_agrupamento);
						cont_tec_memorial($matricula,$supervisor,$id_agrupamento);
						engajamento_prod($matricula,$supervisor,$id_agrupamento);
						break;
                              		case 12:
						avaliacao_supervisor($matricula,$supervisor,$id_agrupamento);
						cont_tec_memorial($matricula,$supervisor,$id_agrupamento);
						engajamento_prod($matricula,$supervisor,$id_agrupamento);
						break;
                              		case 13:
						avaliacao_supervisor($matricula,$supervisor,$id_agrupamento);
						avaliacao_360($matricula,$supervisor,$id_agrupamento,$cod_setor);
						engajamento_memorial($matricula,$supervisor,$id_agrupamento);
						break;
                              		case 14:
						avaliacao_supervisor($matricula,$supervisor,$id_agrupamento);
						avaliacao_360($matricula,$supervisor,$id_agrupamento,$cod_setor);
						engajamento_memorial($matricula,$supervisor,$id_agrupamento);
						break;
                              		case 15:
						cont_tec_memorial($matricula,$supervisor,$id_agrupamento);
						break;
                              		case 16:
						cont_tec_memorial($matricula,$supervisor,$id_agrupamento);
						engajamento_prod($matricula,$supervisor,$id_agrupamento);
					        lista_avaliacao_de_supervisao($matricula,$supervisor,$id_agrupamento,$cod_setor)
						break;
                              		case 17:
						avaliacao_supervisor($matricula,$supervisor,$id_agrupamento);
						avaliacao_360($matricula,$supervisor,$id_agrupamento,$cod_setor);
						cont_tec_memorial($matricula,$supervisor,$id_agrupamento);
						engajamento_prod($matricula,$supervisor,$id_agrupamento);
						break;
                              		case 18:
						avaliacao_supervisor($matricula,$supervisor,$id_agrupamento);
						avaliacao_360($matricula,$supervisor,$id_agrupamento,$cod_setor);
						engajamento_memorial($matricula,$supervisor,$id_agrupamento);
						break;
                              		case 19:
						avaliacao_supervisor($matricula,$supervisor,$id_agrupamento);
						avaliacao_360($matricula,$supervisor,$id_agrupamento,$cod_setor);
						cont_tec_memorial($matricula,$supervisor,$id_agrupamento);
						engajamento_prod($matricula,$supervisor,$id_agrupamento);
						break;
                              		case 20:
						avaliacao_supervisor($matricula,$supervisor,$id_agrupamento);
						avaliacao_360($matricula,$supervisor,$id_agrupamento,$cod_setor);
						cont_tec_memorial($matricula,$supervisor,$id_agrupamento);
						engajamento_prod($matricula,$supervisor,$id_agrupamento);
						break;
                              		case 21:
						cont_tec_memorial($matricula,$supervisor,$id_agrupamento);
						engajamento_prod($matricula,$supervisor,$id_agrupamento);
					        lista_avaliacao_de_supervisao($matricula,$supervisor,$id_agrupamento,$cod_setor)
						break;
                              		case 22:
						cont_tec_memorial($matricula,$supervisor,$id_agrupamento);
						engajamento_prod($matricula,$supervisor,$id_agrupamento);
					        lista_avaliacao_de_supervisao($matricula,$supervisor,$id_agrupamento,$cod_setor)
						break;

				}


 echo "************************************************************************************************************************************************************************";
 echo "<br>";
 echo "<br>";
  }
    

echo "Numero de insercoes de avaliacoes para supervisores:";
echo $cont_sup; 
echo "<br>";
echo "Numero de insercoes de avaliacoes para clientes:";
echo $cont_cli; 
echo "<br>";
echo "Numero de insercoes de memoriais:";
echo $cont_memorial; 
echo "<br>";
rodape();
?>
