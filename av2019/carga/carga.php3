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
                    $cod_aval_num=1;
                    $str_supervisor="INSERT INTO Pesquisa_Opiniao
                                 VALUES ('','','$matricula','$id_agrupamento','$ANO_REF','$supervisor','12','$cod_aval_num')";
                    sql($BD4,$str_supervisor);
		#	echo $str_supervisor;
		#	echo "<br>";
	}

function avaliacao_360($matricula,$supervisor,$id_agrupamento,$cod_setor)
	{	
		GLOBAL $ANO_REF;
		GLOBAL $BD4;
                    $cod_aval_num=3;
                    
			#$sql_str360="SELECT matr FROM elegiveis WHERE matr <> '$matricula' AND matr <> '$supervisor' AND cod_setor='$cod_setor'";
			$sql_str360="SELECT matr FROM elegiveis WHERE matr <> '$matricula' AND matr NOT IN ( SELECT matr from comissionados WHERE ano='$ANO_REF') AND cod_setor='$cod_setor'";
#echo "360";
#echo "<br>";
#echo $sql_str360;
#echo "<br>";
			$res1=sql($BD4, $sql_str360);                
                        while ($lis1=mysql_fetch_row($res1))
			{
                    		$str_auto="INSERT INTO Pesquisa_Opiniao
                                 VALUES ('','','$lis1[0]','$id_agrupamento','$ANO_REF','$matricula','12','$cod_aval_num')";
				sql($BD4,$str_auto);
				#echo $str_auto;
				#echo "<br>";
  			}

	}


function cont_tec_memorial($matricula,$supervisor,$id_agrupamento)
	{
		GLOBAL $ANO_REF;
		GLOBAL $BD4;
                    $cod_aval_num=2;
                    $str_memorial="INSERT INTO Pesquisa_Opiniao
                                 VALUES ('','','$matricula','$id_agrupamento','$ANO_REF','$supervisor','12','$cod_aval_num')";
                    #sql($BD4,$str_memorial);
		#	echo $str_memorial;
		#	echo "<br>";
	}

function engajamento_prod($matricula,$supervisor,$id_agrupamento)
	{
		GLOBAL $ANO_REF;
		GLOBAL $BD4;

                    $cod_aval_num=99;   

                    $str_eng_prod="INSERT INTO Pesquisa_Opiniao
                                 VALUES ('','','$matricula','$id_agrupamento','$ANO_REF','$supervisor','12','$cod_aval_num')";
                #    sql($BD4,$str_memorial);
		#	echo $str_eng_prod;
		#	echo "<br>";
	}

function engajamento_memorial($matricula,$supervisor,$id_agrupamento)
	{
		GLOBAL $ANO_REF;
		GLOBAL $BD4;

                    $cod_aval_num=88;

                    $str_eng_memorial="INSERT INTO Pesquisa_Opiniao
                                 VALUES ('','','$matricula','$id_agrupamento','$ANO_REF','$supervisor','12','$cod_aval_num')";
                #    sql($BD4,$str_memorial);
		#	echo $str_eng_memorial;
		#	echo "<br>";
	}


$cont_sup=0;
$cont_cli=0;
$cont_memorial=0;

$sql_str="SELECT * 
                 FROM elegiveis
                 where ano='$ANO_REF'
		 and elegivel='1'
                 ORDER BY matr"; 

$res0=sql($BD4,$sql_str);

while($lis0=mysql_fetch_row($res0))
 {
   $matricula=$lis0[1];
   $supervisor=$lis0[2];
   $id_agrupamento=$lis0[4];
   $cod_agrupamento=verifica_agrupamento($lis0[4]);
   $cod_setor=$lis0[7];


	switch($cod_agrupamento){
                              		case 1:
						avaliacao_supervisor($matricula,$supervisor,$id_agrupamento);
#						avaliacao_360($matricula,$supervisor,$id_agrupamento,$cod_setor);
#						cont_tec_memorial($matricula,$supervisor,$id_agrupamento);
#						engajamento_prod($matricula,$supervisor,$id_agrupamento);
						$cont_sup++;
						break;
                              		case 2:
						avaliacao_supervisor($matricula,$supervisor,$id_agrupamento);
#						engajamento_memorial($matricula,$supervisor,$id_agrupamento);
						$cont_sup++;
						break;
                              		case 3:
						avaliacao_supervisor($matricula,$supervisor,$id_agrupamento);
#						avaliacao_360($matricula,$supervisor,$id_agrupamento,$cod_setor);
#						engajamento_memorial($matricula,$supervisor,$id_agrupamento);
						$cont_sup++;
						break;
                              		case 4:
						avaliacao_supervisor($matricula,$supervisor,$id_agrupamento);
#						avaliacao_360($matricula,$supervisor,$id_agrupamento,$cod_setor);
#						engajamento_memorial($matricula,$supervisor,$id_agrupamento);
						$cont_sup++;
						break;
                              		case 5:
						avaliacao_supervisor($matricula,$supervisor,$id_agrupamento);
#						avaliacao_360($matricula,$supervisor,$id_agrupamento,$cod_setor);
#						engajamento_memorial($matricula,$supervisor,$id_agrupamento);
						$cont_sup++;
						break;
                              		case 6:
						avaliacao_supervisor($matricula,$supervisor,$id_agrupamento);
#						avaliacao_360($matricula,$supervisor,$id_agrupamento,$cod_setor);
#						engajamento_memorial($matricula,$supervisor,$id_agrupamento);
						$cont_sup++;
						break;
                              		case 7:
						avaliacao_supervisor($matricula,$supervisor,$id_agrupamento);
#						avaliacao_360($matricula,$supervisor,$id_agrupamento,$cod_setor);
#						cont_tec_memorial($matricula,$supervisor,$id_agrupamento);
#						engajamento_prod($matricula,$supervisor,$id_agrupamento);
						$cont_sup++;
						break;
                              		case 8:
						avaliacao_supervisor($matricula,$supervisor,$id_agrupamento);
#						avaliacao_360($matricula,$supervisor,$id_agrupamento,$cod_setor);
#						engajamento_memorial($matricula,$supervisor,$id_agrupamento);
						$cont_sup++;
						break;
                              		case 9:
						avaliacao_supervisor($matricula,$supervisor,$id_agrupamento);
#						avaliacao_360($matricula,$supervisor,$id_agrupamento,$cod_setor);
#						engajamento_memorial($matricula,$supervisor,$id_agrupamento);
						$cont_sup++;
						break;
                              		case 10:
						avaliacao_supervisor($matricula,$supervisor,$id_agrupamento);
#						cont_tec_memorial($matricula,$supervisor,$id_agrupamento);
#						engajamento_prod($matricula,$supervisor,$id_agrupamento);
						$cont_sup++;
						break;
                              		case 11:
						avaliacao_supervisor($matricula,$supervisor,$id_agrupamento);
#						avaliacao_360($matricula,$supervisor,$id_agrupamento,$cod_setor);
#						cont_tec_memorial($matricula,$supervisor,$id_agrupamento);
#						engajamento_prod($matricula,$supervisor,$id_agrupamento);
						$cont_sup++;
						break;
                              		case 12:
						avaliacao_supervisor($matricula,$supervisor,$id_agrupamento);
#						avaliacao_360($matricula,$supervisor,$id_agrupamento,$cod_setor);
#						cont_tec_memorial($matricula,$supervisor,$id_agrupamento);
#						engajamento_prod($matricula,$supervisor,$id_agrupamento);
						$cont_sup++;
						break;
                              		case 13:
						avaliacao_supervisor($matricula,$supervisor,$id_agrupamento);
#						avaliacao_360($matricula,$supervisor,$id_agrupamento,$cod_setor);
#						engajamento_memorial($matricula,$supervisor,$id_agrupamento);
						$cont_sup++;
						break;
                              		case 14:
						avaliacao_supervisor($matricula,$supervisor,$id_agrupamento);
#						avaliacao_360($matricula,$supervisor,$id_agrupamento,$cod_setor);
#						engajamento_memorial($matricula,$supervisor,$id_agrupamento);
						$cont_sup++;
						break;
                              		case 15:
						avaliacao_supervisor($matricula,$supervisor,$id_agrupamento);
#						cont_tec_memorial($matricula,$supervisor,$id_agrupamento);
						$cont_sup++;
						break;
                              		case 16:
						avaliacao_supervisor($matricula,$supervisor,$id_agrupamento);
#						cont_tec_memorial($matricula,$supervisor,$id_agrupamento);
#						engajamento_prod($matricula,$supervisor,$id_agrupamento);
						$cont_sup++;
						break;
                              		case 17:
						avaliacao_supervisor($matricula,$supervisor,$id_agrupamento);
#						avaliacao_360($matricula,$supervisor,$id_agrupamento,$cod_setor);
#						cont_tec_memorial($matricula,$supervisor,$id_agrupamento);
#						engajamento_prod($matricula,$supervisor,$id_agrupamento);
						$cont_sup++;
						break;
                              		case 18:
						avaliacao_supervisor($matricula,$supervisor,$id_agrupamento);
#						avaliacao_360($matricula,$supervisor,$id_agrupamento,$cod_setor);
#						engajamento_memorial($matricula,$supervisor,$id_agrupamento);
						$cont_sup++;
						break;
/*
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
						avaliacao_supervisor($matricula,$supervisor,$id_agrupamento);
						cont_tec_memorial($matricula,$supervisor,$id_agrupamento);
						engajamento_prod($matricula,$supervisor,$id_agrupamento);
						break;
                              		case 22:
						avaliacao_supervisor($matricula,$supervisor,$id_agrupamento);
						cont_tec_memorial($matricula,$supervisor,$id_agrupamento);
						engajamento_prod($matricula,$supervisor,$id_agrupamento);
*/						break;

				}


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
echo "FIM DE TRANSFERENCIA";
?>
