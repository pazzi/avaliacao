<?php
include ("../func_avalia.php3");
$agrup_sup_360=array(1,3,4,5,6,7,8,9,13,14,17,18,19,20);

	
$str_sql_lista="select $BD1.empregados.matr, $BD1.empregados.nome, $BD1.empregados.local, $BD4.elegiveis.cod_agrupamento, $BD4.elegiveis.supervisor, $BD4.elegiveis.cod_setor 
			from $BD1.empregados,$BD4.elegiveis 
			where $BD1.empregados.matr=$BD4.elegiveis.matr
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


	 $ret_func= busca_medias_competencia(1,$matr_ret,$ANO_REF);
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
					$nota_nfi_memorial= $memorial * obtem_nfi($agrupamento,9);
					break;
				case 6:
					$relato=$lista[1];
					$nota_nfi_relato= $relato * obtem_nfi($agrupamento,10);
					break;
				case 7:
					$ind_producao=$lista[1];
					$nota_nfi_ind_producao= $ind_producao * obtem_nfi($agrupamento,11);
					break;
				case 8:
					$ind_engajamento=$lista[1];
					$nota_nfi_ind_engajamento= $ind_engajamento * obtem_nfi($agrupamento,12);
					break;

			}
         }
	$media_sup=$soma_nota/$contador;
	$nota_nfi_supervisor=$media_sup * obtem_nfi($agrupamento,8);

/*
#Verifica se pertence a agrupamento  com avaliacao 360

if (in_array($agrupamento, $agrup_sup_360))
{

     $ret_func= busca_notas_por_formulario(3,$matr_ret,$ANO_REF);
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
     $media_pares=$media_cli;
	

}
*/


$nfi = $nota_nfi_supervisor + $nota_nfi_memorial + $nota_nfi_relato + $nota_nfi_ind_engajamento + $nota_nfi_ind_producao;

echo $nome;
echo ":";
echo nome_agrupamento($agrupamento);
echo ":";
echo $media_sup;
echo ":";
echo $media_pares;
echo ":";
echo $memorial;
echo ":";
echo $relato;
echo ":";
echo $ind_engajamento;
echo ":";
echo $ind_producao;
echo ":";
echo $nfi;
echo "<br>";

$nome="";
$media_sup="0";
$media_pares="0";
$memorial="0";
$relato="0";
$ind_engajamento="0";
$ind_producao="0";

$nota_nfi_supervisor=0;
$media_pares_final=0;
$nota_nfi_memorial=0;
$nota_nfi_relato=0;
$nota_nfi_ind_engajamento="0";
$nota_nfi_ind_producao="0";
$nfi="0";
}

rodape();
?>
