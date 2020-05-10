<?php
include ("../func_avalia.php3");

function ultimoID()
{
	global $BD4;
        $str_sql= sql("$BD4","SELECT max(id) as id FROM z_indicador;");
	$ret=mysql_result($str_sql,0,0);
	return $ret;
}

$sql_inser="INSERT INTO z_indicador
                     VALUES ('','$_POST[id_agrup]','$_POST[codIndicador]','$_POST[pesoIndicador]')";
#echo $sql_inser;
   sql($BD4,$sql_inser);
#echo "<br>";

$ultimoIdIndicador=ultimoID();

$total=count($_POST['fonte']);

for ($i = 0; $i < $total; $i++)
 {
	$fonte= $_POST['fonte'][$i];
	$pesoFonte= $_POST['pesoFonte'][$i];

	if ($pesoFonte <> '')
	{
		$sql_insere="INSERT INTO z_itens
                     VALUES ('','$ultimoIdIndicador','$fonte','$pesoFonte')";
#echo "-----------------------------------no loop-------------------------------<br>";
#	echo $sql_insere;
#echo "<br>";
   		sql($BD4,$sql_insere);
	}
 }

$id=$_POST["id_agrup"];
header("Location:http://$REFERER_SERVER/avaliacao/$AMBIENTE/agrupamentos/cadastra_indicador.php?id=$id&ano=$ANO_REF");

?>
