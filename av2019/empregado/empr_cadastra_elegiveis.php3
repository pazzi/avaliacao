<?php
include ("../../func_avalia.php3");

#contar quantos foram escolhidos pelo usuario.
$teste=array_count_values($_REQUEST['elegivel']);
if ($teste[1] < 6)
   {
     echo "Escolha pelo menos 6 empregados para a avaliacao";
     echo "<br>";
     echo "<a href=http://www.cnpma.embrapa.br/avaliacao/atual/empregado/>Voltar</a>";
     exit();
    } 

if ($teste[1] > 6)
   {
     echo "Escolha 6  e somente 6 empregados para a avaliacao";
     echo "<br>";
     echo "<a href=http://www.cnpma.embrapa.br/avaliacao/atual/empregado/>Voltar</a>";
     exit();
    } 

$matr_da=$_POST['matr_da'];
$matr_or=$_POST['matr_or'];
$matr_super=$_POST['matr_super'];


$sql_del="DELETE 
                 FROM escolha
                 WHERE matr_da='$matr_da'
                 AND ano='$ANO_REF'";
sql($BD3,$sql_del);



/**********Nao havera autoavaliacao
$str_insere_auto="INSERT INTO escolha
                   VALUES ('','$matr_da','$matr_da','a','$ANO_REF')";
sql($BD3,$str_insere_auto);
*/



$str_insere_super="INSERT INTO escolha
                         VALUES ('','$matr_da','$matr_super','s','$ANO_REF')";
sql($BD3,$str_insere_super);

#echo $str_insere_auto;
#echo "<br>";
#echo $str_insere_super;
#echo "<br>";
#echo "<br>";

$fim=count($_POST['matr_or']);
for ($i = 0; $i <= $fim; $i++)
 {
   if ($_POST['elegivel'][$i]==1)
     {
      $matr_par=$_POST['matr_or'][$i];
      $sql_inser="INSERT INTO escolha
                     VALUES ('','$matr_da','$matr_par','e','$ANO_REF')";
     sql($BD3,$sql_inser);
     }
 }
sleep(1);
header("Location:http://www.cnpma.embrapa.br/avaliacao/atual/empregado/empr_mostra.php3?parm=1");
?>
