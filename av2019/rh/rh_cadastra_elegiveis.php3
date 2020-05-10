<?php
include ("../func_avalia.php3");
$sql_delete="DELETE FROM elegiveis WHERE ano = '$ANO_REF'";
sql($BD4,$sql_delete); # Ana Paula
sleep(2);

$fim=count($_POST['matr_da']);
for ($i = 0; $i <= $fim; $i++)
 {

   $supervisor=explode(":::",$_POST['super'][$i]);
   $matr_supervisor=$supervisor[0];
   $matricula= $_POST['matr_da'][$i];
   $elegivel= $_POST['elegivel'][$i];
   $exp_agrupamento=explode(":::",$_POST['agrupamento'][$i]);
   $agrupamento= $exp_agrupamento[0];
   $exp_setor=explode(":::",$_POST['setor'][$i]);
   $setor= $exp_setor[0];
   $obs= $_POST['obs'][$i];
   $sql_inser="INSERT INTO elegiveis
                     VALUES ('','$matricula','$matr_supervisor','$elegivel', '$agrupamento','$obs', '$ANO_REF', '$setor')";
   sql($BD4,$sql_inser);
##echo "- $sql_inser<br>"; # Ana Paula
 }
sleep(2);
header("Location:http://$REFERER_SERVER/avaliacao/$AMBIENTE/rh/rh_mostra.php3?parm=1");
//header("Location:http://ouro.cnpma.embrapa.br/avaliacao/av2018/rh/rh_mostra.php3?parm=1");

?>
