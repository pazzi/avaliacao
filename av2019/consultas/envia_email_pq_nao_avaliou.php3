<?php
include ("../func_avalia.php3");
##################################################################################################
###          Observar no texto do email a data e a hora do fim de avaliacao - linha 73         ###
##################################################################################################
echo "<br>";
cabecalho();
echo "<br>";
echo "<center>";
echo "<font class=\"title\">Envia email</font> ";
echo "</center>";
echo "<br>";
echo "<center>";
#echo "<a href=\"menu.php3\">Voltar</a>";
echo "</center>";
echo "<br>";


$str_sql="SELECT $BD4.Pesquisa_Opiniao.matricula_superv,$BD1.empregados.nome,count($BD4.Pesquisa_Opiniao.matricula_superv)
                              FROM $BD4.Pesquisa_Opiniao,$BD1.empregados
                              WHERE $BD1.empregados.matr=$BD4.Pesquisa_Opiniao.matricula_superv
                              AND $BD4.Pesquisa_Opiniao.ano_pesq='$ANO_REF'
                              AND $BD4.Pesquisa_Opiniao.codigo_aval<>'2'
                              GROUP BY $BD4.Pesquisa_Opiniao.matricula_superv
                              ORDER BY 3 DESC";
$ret_str_sql=sql($BD4,$str_sql);
$layout="<i><font class=\"corpo\"><b>Empregados  que nao avaliaram  </b></font></i>";
echo "<center>";
echo "<table border=\"0\" width=\"80%\" cellspacing=3>";
echo "<tr>";
echo "<td>";
echo $layout;
echo "</td>";
echo "</tr>";
 
$s=0;
$n=0;
                $i=1;
                while ($lista1=mysql_fetch_row($ret_str_sql))
                        {
                                       $matr_avaliador=$lista1[0];
                                       echo "<tr>";
                                       echo "<font class=\"corpo\">";
                                       echo "<td>";
                                       echo $i;
                                       echo ":";
                                       echo $matr_avaliador;
                                       echo ":";
                                       echo $lista1[1];
                                       echo ":";
                                       echo $lista1[2];
                                       echo ":";

                                       $str_sql_efetivo="SELECT  count(codigo_pesquisa)
                                                           FROM Pesquisa_Opiniao
                                                           WHERE matricula_superv='$matr_avaliador'
                                                           AND ano_pesq='$ANO_REF'
                                                           and codigo_pesquisa in (Select DISTINCT codigo_pesquisa FROM Pesq_Satisfacao_Resp_Item)";

                                       $ret_str_sql_efetivo=sql($BD4,$str_sql_efetivo);
                                       $num_total= mysql_result($ret_str_sql_efetivo,0,0);
                                       echo $num_total;

                                       $ret_email="SELECT email_corporativo,nome from empregados where matr='$matr_avaliador'";
                                       $ret_email_sql=sql($BD1,$ret_email);
                                       $email=mysql_result($ret_email_sql,0,0);
                                       $nome=mysql_result($ret_email_sql,0,1);
                                       if ($num_total<>$lista1[2])
                                            {
                                              echo "----------------------> Enviado Email!!!";

echo "<br>";
                                               mail("$email,$RESP_SGP_EMAIL, paula.almada@embrapa.br","Avaliacao de Competencias Comportamentais ","Prezado(a) $nome,\n\n Verificamos que existem avaliacoes de Competencias Comportamentais pendentes sob sua responsabilidade a serem feitas. Vimos solicitar-lhe que entre em www.cnpma.embrapa.br/avaliacao/av2018/avaliacao/ para realizar essas avaliacoes pendentes.\n\n O prazo de termino da fase de avaliacao e: 26-03-2019 as 24h:00\n\n Nosso muito Obrigado\n\nComite de Avaliacao de Desempenho Individual da Embrapa Meio Ambiente","FROM:cnpma.comiteprogsalarial@embrapa.br");
echo $email;
echo "<br>";

                                            }
                                       echo "</font>";
                                       echo "</td>";
                                       echo "</tr>";
                                       $i++;
                        }
                echo "</table>";
                echo "</center>";
rodape();
?>
