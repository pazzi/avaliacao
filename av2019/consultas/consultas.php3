<?php
include ("../func_avalia.php3");
$parm=$_GET["parm"];
echo "<br>";
cabecalho();
echo "<br>";
echo "<center>";
echo "<h2>Consultas</h2> ";
echo "</center>";
echo "<br>";
echo "<center>";
#echo "<a href=\"menu.php3\">Voltar</a>";
echo "</center>";
echo "<br>";
sleep(1);
sleep(3);

switch ($parm)
  {
    case 0:
           $str_sql="SELECT $BD1.empregados.matr,$BD1.empregados.nome,
                            $BD4.elegiveis.supervisor,
                            $BD4.elegiveis.elegivel,
                            $BD4.elegiveis.cod_agrupamento
                              FROM $BD4.elegiveis,$BD1.empregados 
                              WHERE $BD1.empregados.matr=$BD4.elegiveis.matr
                              AND $BD4.elegiveis.ano='$ANO_REF'
                              AND $BD1.empregados.matr=$BD4.elegiveis.matr
                              ORDER BY $BD4.elegiveis.elegivel DESC,$BD4.elegiveis.cod_agrupamento DESC,$BD1.empregados.nome";
          $ret_str_sql=sql($BD4,$str_sql);
          $layout="<i><font class=\"corpo\"><b>LAYOUT</b> :Sequencial: Matricula:Nome:MatrSupervisor:Elegivel:Agrupamento Saad</font></i>";
           echo "<center>";
          echo "<table border=\"0\" width=\"80%\" cellspacing=3>";

          echo "<tr>";
          echo "<td>";
          echo $layout;
          echo "</td>";
          echo "</tr>";

          $i=0;
          while ($lista1=mysql_fetch_row($ret_str_sql))
                {
                  echo "<tr>";
                  if ($lista1[3]==0)
                      {
                        echo "<td bgcolor=\"#00cc00\">";
                      }
                         else
                                {
                                 echo "<td>";
                                }
          		echo "<font class=\"corpo\">"; 
          		echo $i;
          		echo ":";
          		echo $lista1[0];
          		echo ":";
          		echo $lista1[1];
          		echo ":";
          		echo $lista1[2];
          		echo ":";
          		echo $lista1[3];
          		echo ":";
          		echo $lista1[4];
          		echo ":";
          		echo $lista1[5];
          		echo "</font>";
          		echo "</td>";
          		echo "</tr>";
          		$i++;
                }
           echo "</table>";
           echo "</center>";
           break;

    case 1:
           $str_sql="SELECT $BD1.empregados.matr,$BD1.empregados.nome
                              FROM $BD1.empregados,$BD4.elegiveis
                              WHERE $BD1.empregados.matr=$BD4.elegiveis.matr
                              AND $BD4.elegiveis.elegivel='1'
                              AND $BD4.elegiveis.ano='$ANO_REF'
				ORDER BY $BD1.empregados.nome ASC";
##echo $str_sql;
               $ret_str_sql=sql($BD4,$str_sql);
	       echo "<h4>Empregados  sem preenchimento de memorial relato do empregado - $ANO_REF</h4>";

		echo "<center>";
		echo "<table border=\"0\" width=\"80%\" cellspacing=3>";

		$i=1;
		while ($lista1=mysql_fetch_row($ret_str_sql))
     			{
		           $str_memorial="SELECT $BD4.Pesquisa_Opiniao.codigo_pesquisa
                			              FROM $BD4.Pesquisa_Opiniao, $BD4.Memorial
                              				WHERE $BD4.Pesquisa_Opiniao.matricula='$lista1[0]'
                              				AND $BD4.Pesquisa_Opiniao.ano_pesq='$ANO_REF'
                              				AND $BD4.Pesquisa_Opiniao.codigo_pesquisa=$BD4.Memorial.codigo_pesquisa";
				$ret_memorial=sql($BD4,$str_memorial);
				$total_linhas=mysql_num_rows($ret_memorial);
				if ($total_linhas==0)
					{
					       echo "<tr>";
					       echo "<font class=\"corpo\">"; 
					       echo "<td>";
					       echo $i;
					       echo ":";
					       echo $lista1[1];
					       echo ":";
					       echo $lista1[2];
					       echo "</font>";
					       echo "</td>";
					       echo "</tr>";
					       $i++;
					}
     			}
		echo "</table>";
		echo "</center>";
           break;

    case 2:
           $str_sql="SELECT DISTINCT matr_da,$BD1.empregados.nome
                              FROM $BD4.escolha,$BD1.empregados
                              WHERE $BD1.empregados.matr=$BD4.escolha.matr_da
                              AND $BD4.escolha.ano='$ANO_REF'
                              ORDER BY $BD1.empregados.nome";
           $ret_str_sql=sql($BD3,$str_sql);
           $layout="<i><font class=\"corpo\"><b>Empregados  que escolheram</b></font></i>";
		echo "<center>";
		echo "<table border=\"0\" width=\"80%\" cellspacing=3>";

		echo "<tr>";
		echo "<td>";
		echo $layout;
		echo "</td>";
		echo "</tr>";

		$i=1;
		while ($lista1=mysql_fetch_row($ret_str_sql))
     			{
			       echo "<tr>";
			       echo "<td>";
			       echo "<font class=\"corpo\">"; 
       			       echo $i;
                               echo ":";
                               echo $lista1[0];
                               echo ":";
			       echo $lista1[1];
			       echo "</font>";
			       echo "</td>";
			       echo "</tr>";
			       $i++;
     			}
		echo "</table>";
		echo "</center>";
           break;
    case 3:
           echo "<center>Empregados que nao escolheram pares/clientes</center>";
           echo "<br>";
           $str_sql="SELECT $BD4.elegiveis.matr,$BD1.empregados.nome,$BD1.empregados.email
                            FROM $BD4.elegiveis,$BD1.empregados
                            WHERE $BD4.elegiveis.matr=$BD1.empregados.matr
                            AND $BD4.elegiveis.matr NOT IN $EXCEPCOES
                            AND $BD4.elegiveis.ano=$ANO_REF";
           $res_str_sql=sql($BD3,$str_sql);
           echo "<center>";
           echo "<table border=\"0\" width=\"80%\" cellspacing=3>";
$s=0;
$n=0;
           while ($lis_res=mysql_fetch_row($res_str_sql))
                 { 

                   $matricula=$lis_res[0];
                   $nome=$lis_res[1];
                   $email=$lis_res[2];
                   $str_sql="SELECT DISTINCT $BD4.escolha.matr_da
                              FROM $BD4.escolha
                              WHERE $BD4.escolha.matr_da='$matricula'
                              AND $BD4.escolha.ano='$ANO_REF'";

                   $ret_str_sql1=sql($BD3,$str_sql);
                   $lin_ret= mysql_num_rows($ret_str_sql1);

                   if ($lin_ret == 1)
                       {
                         #$status= "<font color=\"green\">Sim</font>";
                         $s++;
                         continue;
                       }
                        else
                             {
                              #$status="<font color=\"red\">-------------->Nao</font>";

                              $n++;
                             }
                       
                   echo "<td>";
                   echo $matricula;
                   echo " - ";
                   echo $nome;
                   echo " - ";
                   echo " [ ramal:";
                   $ret_fone=verifica_fone($matricula);
                   echo $ret_fone;
                   echo " ]";
                  # echo $status;
                   echo "</tr>";

                 }
           echo "</table>";
echo "<br>";
echo "          $s ................- Escolheram pares";
$perc_s= $s/($s+$n)*100;
echo "---------------";
echo $perc_s. "%";
echo "<br>";
echo "          $n ................- Nao escolheram pares";
$perc_n= $n/($s+$n)*100;
echo "---------------";
echo $perc_n. "%";
echo "<br>";
           echo "<center>";
           break;
     case 4:
            echo "Empregados e quantidades de avaliadores";

           $str_sql="SELECT $BD4.Pesquisa_Opiniao.matricula,$BD1.empregados.nome,count($BD4.Pesquisa_Opiniao.matricula_superv)
                            FROM $BD4.Pesquisa_Opiniao,$BD1.empregados
                            WHERE $BD4.Pesquisa_Opiniao.matricula=$BD1.empregados.matr
                            AND $BD4.Pesquisa_Opiniao.ano_pesq=$ANO_REF
                            GROUP BY $BD4.Pesquisa_Opiniao.matricula";
           $res_str_sql=sql($BD3,$str_sql);
$s=0;
$n=0;
           while ($lis_res=mysql_fetch_row($res_str_sql))
                 { 
                 $s++;
                   echo $lis_res[0].":::".$lis_res[1].":::".$lis_res[2];
                   echo "<br>";
                 }
                 echo $s ." ocorrencias";
           break;

    case 5:
           $str_sql="SELECT $BD4.Pesquisa_Opiniao.matricula_superv,$BD1.empregados.nome,count($BD4.Pesquisa_Opiniao.matricula_superv)
                              FROM $BD4.Pesquisa_Opiniao,$BD1.empregados
                              WHERE $BD1.empregados.matr=$BD4.Pesquisa_Opiniao.matricula_superv
                              AND $BD4.Pesquisa_Opiniao.ano_pesq='$ANO_REF'
                              AND $BD4.Pesquisa_Opiniao.codigo_aval<>'2'
                              GROUP BY $BD4.Pesquisa_Opiniao.matricula_superv
                              ORDER BY 3 DESC";
##echo $str_sql;
           $ret_str_sql=sql($BD4,$str_sql);
           echo "<i><p><b>Empregados  que nao avaliaram  </b></p></i>";
                echo "<table class=\"table table-striped\">";
                echo "<thead>";
                echo "<tr>";
                echo "<th>";
                echo "id";
                echo "</th>";
                echo "<th>";
                echo "Matricula";
                echo "</th>";
                echo "<th>";
                echo "Nome";
                echo "</th>";
                echo "<th>";
                echo "A avaliar";
                echo "</th>";
                echo "<th>";
                echo "Avaliados";
                echo "</th>";
                echo "<th>";
                echo "Ramal";
                echo "</th>";
                echo "</tr>";
                echo "</thead>";
                $s=0;
                $n=0;
                $i=1;
                while ($lista1=mysql_fetch_row($ret_str_sql))
                        {
                                       $matr_avaliador=$lista1[0];
                                       echo "<tr>";
                                       echo "<td>";
                                       echo $i;
                                       echo "</td>";
                                       echo "<td>";
                                       echo $matr_avaliador;
                                       echo "</td>";
                                       echo "<td>";
                                       echo $lista1[1];
                                       echo "</td>";
                                       echo "<td>";
                                       echo $lista1[2];
                                       echo "</td>";
                                       echo "<td>";
                                       $str_sql_efetivo="SELECT  count(codigo_pesquisa)
                                                           FROM Pesquisa_Opiniao
                                                           WHERE matricula_superv='$matr_avaliador'
                                                           AND ano_pesq='$ANO_REF'
                                                           and codigo_pesquisa in (Select DISTINCT codigo_pesquisa FROM Pesq_Satisfacao_Resp_Item)";
#echo $str_sql_efetivo;
                                       $ret_str_sql_efetivo=sql($BD4,$str_sql_efetivo);
                                       $num_total= mysql_result($ret_str_sql_efetivo,0,0);
                                       echo $num_total;
                                       echo "</td>";
                                       echo "<td>";
                                       if ($num_total<>$lista1[2])
                                            {
                                             $n++;
                                              $ret_fone=verifica_fone($matr_avaliador);
                                              echo $ret_fone;
                                            }
                                              else
                                                   {
                                                     $s++;
                                                   }

                                       $i++;
                        }
                                       echo "</td>";
                                       echo "</tr>";
                                       echo "</table>";

                                       echo "<br>";
                                       echo "<br>";
                                       echo "<br>";
                                       echo "$s - Avaliaram";
                                       $perc_s= $s/($s+$n)*100;
                                       echo "---------------";
                                       echo round($perc_s,2). "%";
                                       echo "<br>";
                                       echo "$n - Nao avaliaram";
                                       $perc_n= $n/($s+$n)*100;
                                       echo "---------------";
                                       echo round($perc_n,2). "%";

           break;



}
echo "<br>";
echo "<br>";
echo "<br>";
rodape();
?>
