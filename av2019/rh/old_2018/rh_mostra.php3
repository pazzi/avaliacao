<?php
include ("../func_avalia.php3");
include ("../config.inc");

if (!$_GET["parm"])
    {
    $senha=$_POST["password"];
    $user=$_POST["user"];
    setcookie("cookie_senha_aval",$senha);
    setcookie("cookie_user_aval",$user);
    }
     else
         {
           $password=$_COOKIE["cookie_senha_aval"];
           $user=$_COOKIE["cookie_user_aval"];
         } 


   $ret=authenticateUser($user, $password, $ip);
   $cod_ret=substr($ret, 0, 1);
   $stamp=substr($ret, 1, strlen($ret)-1);
   
/*
if ($_SERVER["HTTP_REFERER"]=="http://www.cnpma.embrapa.br/desenv/avaliacao/atual/rh/rh_mostra.php3")
    {
      $cod_ret=1;
    }
*/


   if ($cod_ret == 0)
   {
    echo "<a href=./index.php3>User-id ou Senha inválidos - entre novamente</a>";
    exit();
   } 

cabecalho($ANO_REF);
echo "<br>";
echo "<center>";
echo "<H2>Modulo - RH  - Ajuste de avaliados e avaliadores ano base $ANO_REF</H2>";
echo "</center>";
echo "<br>";
echo "<br>";
echo "<center>";
echo "<a href=\"index.php3\">Voltar</a>";
echo "</center>";
echo "<br>";
echo "<br>";

$sql_matr=sql($BD1,"select matr,local from empregados where email='$user'");
$matr_ret=mysql_result($sql_matr,0,"matr"); 
$local_ret=mysql_result($sql_matr,0,"local"); 

/*
if ($local_ret<> 21)
   {
    echo "<a href=./index.php3>Usuario não pertencem ao RH</a>";
    exit();
   }
*/

//*****************************

$str_rec_superv="SELECT matr,nome 
                    FROM comissionados 
                    WHERE comissionados.ano='$ANO_REF'
                    ORDER BY comissionados.nome";


$str_agrupamento="SELECT AvaliacaoDesemp.Agrupamento.cod_agrupamento,AvaliacaoDesemp.Agrupamento.descricao 
                    FROM AvaliacaoDesemp.Agrupamento 
                    WHERE AvaliacaoDesemp.Agrupamento.ano_referencia='$ANO_REF'
                    ORDER BY AvaliacaoDesemp.Agrupamento.descricao";


$str_setor="SELECT AvaliacaoDesemp.setor.cod_setor,AvaliacaoDesemp.setor.descricao 
                    FROM AvaliacaoDesemp.setor 
                    WHERE AvaliacaoDesemp.setor.ano='$ANO_REF'
                    ORDER BY AvaliacaoDesemp.setor.descricao";


echo  "<form  action=\"rh_cadastra_elegiveis.php3\" method=\"POST\" >\n";

/*
$rec_nome=sql($BD1,"SELECT $BD1.empregados.matr,$BD1.empregados.nome,$BD1.empregados.cargo 
                    FROM $BD1.empregados
                    WHERE $BD1.empregados.tipo='e'
                    AND $BD1.empregados.situacao='a'
		    AND $BD1.empregados.matr NOT IN (SELECT $BD3.excessoes.matr FROM $BD3.excessoes WHERE $BD3.excessoes.ano='$ANO_REF')
                    ORDER BY $BD1.empregados.nome;");
*/

$rec_nome=sql($BD1,"SELECT $BD1.empregados.matr,$BD1.empregados.nome 
                    FROM $BD1.empregados
                    WHERE $BD1.empregados.tipo='e'
                    AND $BD1.empregados.situacao='a'
                    ORDER BY $BD1.empregados.nome;");

echo "<table class=\"table table-striped\">";
echo "<thead>\n";
echo "<tr>\n";
echo "<th>\n";
      echo "Nome";
echo "</th>\n";
echo "<th>\n";
      echo "Avaliador(pode nao ser o supervisor imediato)";
echo "</th>\n";
echo "<th>\n";
      echo "Setor";
echo "</th>\n";
echo "<th>\n";
      echo "Agrupamento";
echo "</th>\n";
echo "<th>\n";
      echo "Participante?";
echo "</th>\n";
echo "<th>\n";
      echo "Observacao";
echo "</th>\n";
echo "</tr>\n";
echo "</thead>\n";
echo "<tbody>\n";
$i=0;
while ($lista1=mysql_fetch_row($rec_nome))
     {
       $matricula=$lista1[0];

       $sql_busca_reg="SELECT *
                               FROM elegiveis
                               WHERE matr='$matricula'
                               AND ano='$ANO_REF';";
       $res_busca_reg=sql($BD4, $sql_busca_reg);

       $matr= mysql_result($res_busca_reg, 0, "matr");
       
       $supervisor= mysql_result($res_busca_reg, 0, "supervisor");
       $eleg= mysql_result($res_busca_reg, 0, "elegivel");
       $agrupamento= mysql_result($res_busca_reg, 0, "cod_agrupamento");
       $setor= mysql_result($res_busca_reg, 0, "cod_setor");
       $obs= mysql_result($res_busca_reg, 0, "obs");
 
       echo "<INPUT TYPE=\"hidden\" NAME=\"matr_da[". $i . "]\" VALUE=\"$matricula\">";
       echo "<tr>\n";
       echo "<td >\n";
       echo $i;
       echo " - ";
#       echo $matr;
       if ($matr=="")
           {
            echo "*";
            echo $matricula;
           }
            else
                 {
                  echo $matr;
                 }
       echo " - ";
       echo $lista1[1];
       echo "</td>\n";


       echo "<td >\n";
       $result_rec_superv=sql($BD4,$str_rec_superv); 
       echo "<SELECT NAME=\"super[". $i . "]\">\n";
       echo  "<OPTION>000000".":::"."A definir";
       while ($lista4=mysql_fetch_row($result_rec_superv))
            {
               if ($lista4[0]== $supervisor)
                {
                  echo "<OPTION SELECTED>";
                  echo  "$lista4[0]".":::"."$lista4[1]";
                }
                 else
                      {
                        echo "<OPTION>";
                        echo  "$lista4[0]".":::"."$lista4[1]";
                      }
            }
       echo "</SELECT>\n";
       echo "</td>\n";

       echo "<td >\n";
       $result_rec_setor=sql($BD4,$str_setor); 
       echo "<SELECT NAME=\"setor[". $i . "]\">\n";
       echo  "<OPTION>000000".":::"."A definir";
       while ($lista7=mysql_fetch_row($result_rec_setor))
            {
               if ($lista7[0]== $setor)
                {
                  echo "<OPTION SELECTED>";
                  echo  "$lista7[0]".":::"."$lista7[1]";
                }
                 else
                      {
                        echo "<OPTION>";
                        echo  "$lista7[0]".":::"."$lista7[1]";
                      }
            }
       echo "</SELECT>\n";
       echo "</td>\n";

       echo "<td >\n";
       $result_agrupamento=sql($BD4,$str_agrupamento); 
       echo "<SELECT NAME=\"agrupamento[". $i . "]\">\n";
       echo  "<OPTION>00".":::"."A definir";
       while ($lista6=mysql_fetch_row($result_agrupamento))
            {
               if ($lista6[0]== $agrupamento)

                {
                  echo "<OPTION SELECTED>";
                  echo  "$lista6[0]".":::"."$lista6[1]";
                }
                 else
                      {
                        echo "<OPTION>";
                        echo  "$lista6[0]".":::"."$lista6[1]";
                      }
            }
       echo "</SELECT>\n";
       echo "</td>\n";

       echo "<td >\n";
       if ($eleg =='1')
          {
            echo "<INPUT TYPE=RADIO NAME=\"elegivel[".$i."]\" VALUE=1 CHECKED>sim";
            echo "<INPUT TYPE=RADIO NAME=\"elegivel[".$i."]\" VALUE=0>nao";
          } 
           else
               {
                 echo "<INPUT TYPE=RADIO NAME=\"elegivel[".$i."]\" VALUE=1>sim";
                 echo "<INPUT TYPE=RADIO NAME=\"elegivel[".$i."]\" VALUE=0 CHECKED>nao";
               }
       echo "</td>\n";

       echo "<td >\n";
            echo "<INPUT TYPE=TEXT SIZE=30 MAXLENGTH=50 VALUE=\"$obs\" NAME=\"obs[".$i."]\" >";
       echo "</td>\n";
       echo "</tr>\n";
       $i++;
     }
echo "</tbody>";
echo "</table>";

   echo "<table class=\"table\">\n";
   echo "<tr>\n";
   echo "<td>";
   echo "<button type=\"submit\" class=\"btn btn-danger\" name=\"Submit\">Atualizar BD</button>";
   #print "<input type=\"submit\" name=\"Submit\" value=\"Atualizar BD\">\n";
   echo "</td>\n";
   echo "</tr>\n";
   echo "</table>\n";
   echo "</center>\n";

echo "</form>";
rodape();
?>
