<?php
include ("../../func_avalia.php3");

echo "<br>";
echo "<center>";
echo "<a href=\"index.php3\">Voltar</a>";
echo "</center>";
echo "<br>";

echo "<center>";
echo "<table border=\"0\" width=\"80%\" cellspacing=3>";
echo "<tr>";
echo "<td>";
echo "-------------";
echo "</td>";
echo "</tr>";

$str_rec_empr="SELECT cnpma.empregados.matr
                        FROM cnpma.empregados
                        WHERE cnpma.empregados.tipo='e'
                        AND cnpma.empregados.situacao='a'
                        ORDER BY cnpma.empregados.nome";
$rec_empr=sql($BD1,$str_rec_empr);

while ($lis_empr=mysql_fetch_row($rec_empr))

{


 $str_rec0="SELECT Pesquisa_Opiniao_Clientes2006.codigo_pesquisa
                  FROM Pesquisa_Opiniao_Clientes2006
                  WHERE Pesquisa_Opiniao_Clientes2006.matricula='$lis_empr[0]' 
                  AND Pesquisa_Opiniao_Clientes2006.ano_pesq='$ANO_BASE'";

 $rec_result0=sql($BD4,$str_rec0); 
 $contador1=0;
 $soma_media=0;
 while ($lista0=mysql_fetch_row($rec_result0))
	{                  
		$id_user=$lista0[0];
		$str_rec="SELECT AVG(cod_tipo_resposta)
               		     FROM Pesq_Satisfacao_Resp_Item
                   		 WHERE cod_tipo_resposta <>'5' 
                                 AND codigo_pesquisa='$id_user'
                    		GROUP BY  cod_pesq_satisfacao;";
		$rec_result=sql($BD4,$str_rec); 

		$i=0;
		$soma_nota=0;
		while ($lista1=mysql_fetch_row($rec_result))
     			{
                                $nota= $lista1[0];
				$nota_transf=floatval($nota);
                                $soma_nota=$soma_nota + $nota_transf;
				$i++;
			}
	      echo "<tr>";
	      echo "<td>";
                $str_rec_user="SELECT *
                                      FROM Pesquisa_Opiniao_Clientes2006
                                      WHERE codigo_pesquisa='$id_user'";
                $res_rec_user=sql($BD4,$str_rec_user);
                $matr_rec_user=mysql_result($res_rec_user,0,2);
                $matr_rec_or=mysql_result($res_rec_user,0,5);
                $tipo_av=mysql_result($res_rec_user,0,7);
              echo $id_user;
              echo ":";
              echo $matr_rec_user;
              echo ":";
              echo lista_nome($matr_rec_user);
              echo ":";
              echo $matr_rec_or;
              echo ":";
              echo lista_nome($matr_rec_or);
              echo ":";
              echo $soma_nota;
              echo ":";
              echo $i;
              echo ":";
              if ($i<>0)
               {
                $total= $soma_nota/$i;
               }
                 else
                      {
                       $total=0;
                       #echo "Div por 0";
                       echo ":";
                      }
              if ($soma_nota<>0)
                {
                  $contador1++;
                }
              echo $total;
              echo ":";
              switch($tipo_av)
                   {
                    case 1:
                           echo "Supervisor";
                           break;
                    case 2:
                           echo "Auto-avaliacao";
                           break;
                    case 3:
                           echo "Pares";
                           break;
                   }
              $soma_media=$soma_media+$total;
	      echo "</td>";
	      echo "</tr>";
	}
echo "<tr>\n";
echo "<td>\n";
echo $contador1;
echo ":::";
echo $soma_media;
$geral=$soma_media/$contador1;
echo ":::";
echo $geral;
echo "</td>\n";
echo "</tr>\n";

}
echo "</table>";
echo "</center>";
rodape();
?>
