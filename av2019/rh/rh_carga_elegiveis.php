<?php
include ("../func_avalia.php3");

# Converte o codigo do agrupamento e o codigo do setor para a insercao inicial nos elegiveis aproveitando os valores do ano anterior
$ano_ant=$ANO_REF-1;

function verifica_agrupamento($valor){
	GLOBAL $ANO_REF;
	GLOBAL $BD4;
	$str_ver_agrup="SELECT numero from Agrupamento where cod_agrupamento='$valor';";
        $res_ver_agrup=sql($BD4,$str_ver_agrup);
	$num_agrup=mysql_result($res_ver_agrup,0,"numero");
        return $num_agrup;
}

function verificaNovoAgrupamento($valor){
        GLOBAL $ANO_REF;
        GLOBAL $BD4;
        $str_ver_agrup="SELECT cod_agrupamento from Agrupamento where numero='$valor' and ano_referencia='$ANO_REF'";
        $res_ver_agrup=sql($BD4,$str_ver_agrup);
        $cod_agrup=mysql_result($res_ver_agrup,0,"cod_agrupamento");
        return $cod_agrup;
}

function verificaSetor($valor){
        GLOBAL $ANO_REF;
        GLOBAL $BD4;
         GLOBAL $ano_ant;
        $str_ver_setor="SELECT descricao from setor where cod_setor='$valor' and ano='$ano_ant'";
        $res_ver_setor=sql($BD4,$str_ver_setor);
        $nome_setor=mysql_result($res_ver_setor,0,"descricao");
        return $nome_setor;
}

function verificaNovoSetor($valor){
        GLOBAL $ANO_REF;
        GLOBAL $BD4;
        $str_ver_setor="SELECT cod_setor from setor where descricao='$valor' and ano='$ANO_REF'";
        $res_ver_setor=sql($BD4,$str_ver_setor);
        $cod_setor=mysql_result($res_ver_setor,0,"cod_setor");
        return $cod_setor;
}


$sql_str="SELECT * 
                 FROM elegiveis
                 where ano='$ano_ant'
                 ORDER BY matr"; 

$res0=sql($BD4,$sql_str);

while($lis0=mysql_fetch_row($res0))
 {
   $matricula=$lis0[1];
   $supervisor=$lis0[2];
   $elegivel=$lis0[3];
   $id_agrupamento=$lis0[4];

   $num_agrupamento=verifica_agrupamento($lis0[4]);
   $novo_cod_agrupamento=verificaNovoAgrupamento($num_agrupamento);

   $cod_setor=$lis0[7];
   $nome_setor=verificaSetor($cod_setor);
   $novo_cod_setor= verificaNovoSetor($nome_setor);

##echo "num_agrup:$num_agrupamento - novo_cod_agrup: $novo_cod_agrupamento <br>";
##echo "nome_setor:$cod_setor - $nome_setor - Novo_setor: $novo_cod_setor<br>";

$str_elegiveis="INSERT INTO AvaliacaoDesempDesenv.elegiveis (id ,matr,supervisor,elegivel ,cod_agrupamento ,obs ,ano,cod_setor) VALUES (null,'$matricula','$supervisor','$elegivel','$novo_cod_agrupamento','','$ANO_REF','$novo_cod_setor')";

echo "CARGA DESABILITADA<br>";
# echo "str:$str_elegiveis<br>";
#                    sql($BD4,$str_elegiveis);
  }    

echo "Numero de insercoes agrupamentos $ANo_REF:";
echo $cont_sup; 
echo "<br>";
?>
