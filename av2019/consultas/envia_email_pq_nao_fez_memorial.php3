<?php
include ("../func_avalia.php3");
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
$email_control="paula.almada@embrapa.br";
$email_control2="claudia.crecci@embrapa.br";
print "$ANO_REF - $BD4";

           $str_sql="SELECT $BD1.empregados.matr,$BD1.empregados.nome, $BD1.empregados.email_corporativo
                              FROM $BD1.empregados,$BD4.elegiveis
                              WHERE $BD1.empregados.matr=$BD4.elegiveis.matr
                              AND $BD4.elegiveis.elegivel='1'
                              AND $BD4.elegiveis.ano='$ANO_REF'
                                ORDER BY $BD1.empregados.nome ASC";
               $ret_str_sql=sql($BD4,$str_sql);
               echo "<h4>Empregados  sem preenchimento de memorial relato do empregado</h4>";

                echo "<center>";
                echo "<table border=\"0\" width=\"80%\" cellspacing=3>";

                $i=1;
                while ($lista1=mysql_fetch_row($ret_str_sql))
                        {
                           $str_memorial="SELECT $BD4.Pesquisa_Opiniao.codigo_pesquisa
                                                      FROM $BD4.Pesquisa_Opiniao, $BD4.Memorial
                                                        WHERE $BD4.Pesquisa_Opiniao.matricula='$lista1[0]'
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
                                               echo $lista1[0];
                                               echo ":";
                                               echo $lista1[1];
                                               echo "</font>";
                                               echo "</td>";
                                               echo "</tr>";

                              			//mail($email_control,"Preenchimento do Memorial ou Relato do empregado","Prezado(a) $lista1[1],\n\n $lista1[2]\n\n Favor entrar em www.cnpma.embrapa.br/avaliacao/av2018/avaliacao/desempenho/login.php para preencher o Memorial Tecnico e/ou o Relato do Empregado referentes ao processo de Avaliacao de Desempenho Individual ano base - ".$ANO_REF."\n\n Atenciosamente \n\n Comissao de progressao Salarial ","FROM:cnpma.sgp@embrapa.br");
                              			//mail($email_control2,"Preenchimento do Memorial ou Relato do empregado","Prezado(a) $lista1[1],\n\n $lista1[2]\n\n Favor entrar em www.cnpma.embrapa.br/avaliacao/av2018/avaliacao/desempenho/login.php para preencher o Memorial Tecnico e/ou o Relato do Empregado referentes ao processo de Avaliacao de Desempenho Individual ano base - ".$ANO_REF."\n\n Atenciosamente \n\n Comissao de progressao Salarial ","FROM:cnpma.sgp@embrapa.br");
                                                //mail($lista1[2],"Preenchimento do Memorial ou Relato do empregado","Prezado(a) $lista1[1],\n\n $lista1[2]\n\n Favor entrar em www.cnpma.embrapa.br/avaliacao/av2018/avaliacao/desempenho/login.php para preencher o Memorial Tecnico e/ou o Relato do Empregado referentes ao processo de Avaliacao de Desempenho Individual ano base - ".$ANO_REF."\n\n Atenciosamente \n\n Comissao de progressao Salarial ","FROM:cnpma.sgp@embrapa.br");

                                               $i++;
                                        }
                        }
                echo "</table>";
                echo "</center>";


echo $i;
?>
