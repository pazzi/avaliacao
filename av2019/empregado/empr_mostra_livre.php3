<?php
include ("../../func_avalia.php3");

if (!$HTTP_GET_VARS["parm"])
    {
    $senha=$HTTP_POST_VARS["password"];
    $user=$HTTP_POST_VARS["user"];
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
   if ($cod_ret == 0)
   {
    echo "<a href=./index.php3>User-id ou Senha inv�lidos - entre novamente</a>";
    exit();
   } 
*/

echo "<br>";
cabecalho();
echo "<br>";

if ($_GET["parm"]==1)
    {
     echo "<font class=\"corpo\"><b><i>Operacao de escolha concluida, se voce quiser ainda pode fazer alteracoes nas escolhas abaixo, sempre que faze-lo nao se esqueca de apertar o botao Gravar  !!!</i></b></font>";
     echo "<br>";
     echo "<br>";
    }  
     else
          {
            echo "<font class=\"corpo\"><b><i>Operacao de escolha aberta</i></b></font>";
          }

echo "<center>";
echo "<font class=\"title\">Avaliacao por clientes - escolha 6 empregados(clientes)</font> ";
echo "</center>";
echo "<br>";
echo "<center>";
echo "<font class=\"corpo\"><i>[Depois da escolha dos clientes aperte o botao \"gravar\" para envio dos dados]</i></font>";
echo "</center>";
echo "<br>";
echo "<center>";
echo "<font class=\"corpo\"><i>[ATENCAO:O supervisor (periodo $ANO_REF) nao faz parte desta lista - O supervisor tem avaliacao a parte ]</i></font>";
echo "</center>";
echo "<br>";
echo "<center>";
echo "<center>";
echo "<font class=\"corpo\"><i>[Procure escolher empregados que estejam presentes na unidade no periodo de avaliacao ]</i></font>";
echo "</center>";
echo "<br>";
echo "<a href=\"index.php3\">Voltar</a>";
echo "</center>";
echo "<br>";

##Obtem dados de quem logou - matricula a ser avaliada (matr_da)
$sql_matr=sql($BD1,"select matr,local from empregados where email='$user'");
$matr_ret=mysql_result($sql_matr,0,"matr"); 
$local_ret=mysql_result($sql_matr,0,"local"); 
//*****************************

if ( ($matr_ret=="322623") or ($matr_ret=="304554") or ($matr_ret=="321737") or ($matr_ret=="333930") or ($matr_ret=="351289") or ($matr_ret=="323093") or ($matr_ret=="276116"))
     {
       echo "<br>";
       echo " <b><h1>Caro empregado, a norma impede sua participacao na escolha de pares/clientes</h1></b>";
       exit();
     }

##Obtem dados do supervisor de quem logou (matr_or) status p
$sql_matr_sup=sql($BD3,"select supervisor from elegiveis where matr='$matr_ret' and ano='$ANO_REF'");
$matr_sup_ret=mysql_result($sql_matr_sup,0,"supervisor"); 


echo  "<form  action=\"empr_cadastra_elegiveis_livre.php3\" method=\"POST\" >\n";
echo "<INPUT TYPE=\"hidden\" NAME=\"matr_da\" VALUE=\"$matr_ret\">";
echo "<INPUT TYPE=\"hidden\" NAME=\"matr_super\" VALUE=\"$matr_sup_ret\">";

$str_rec_nome="SELECT avaliacao.elegiveis.matr, cnpma.empregados.nome 
                    FROM avaliacao.elegiveis,cnpma.empregados
                    WHERE avaliacao.elegiveis.matr=cnpma.empregados.matr
                    AND avaliacao.elegiveis.elegivel='1'
                    AND avaliacao.elegiveis.matr<>'$matr_ret'
                    AND avaliacao.elegiveis.matr<>'$matr_sup_ret'
                    AND avaliacao.elegiveis.ano='$ANO_REF'
                    ORDER BY cnpma.empregados.nome;";


$rec_nome=sql($BD1,$str_rec_nome); 


echo "<center>";
echo "<table border=\"0\" width=\"80%\" cellspacing=3>";
echo "<tr>";
echo "<td align=\"center\">";
echo "<font class=\"corpo\">Nome</font>";
echo "</td>";
echo "<td align=\"center\">";
echo "<font class=\"corpo\">Observacao</font>";
echo "</td>";
echo "<td align=\"center\">";
echo "<font class=\"corpo\">escolher</font>";
echo "</td>";
echo "</tr>";
$i=0;
while ($lista1=mysql_fetch_row($rec_nome))
     {
       $matricula=$lista1[0];
       $ret=verifica_matr_avaliador($matricula,$ANO_REF);
       $ret_ver_matr_escolhida=verifica_matr_avaliador_avaliado($matr_ret,$matricula,$ANO_REF);
       if ($ret>=10 and $ret_ver_matr_escolhida==0)
         {
                 continue;
         }
          else
               {
                 echo "<INPUT TYPE=\"hidden\" NAME=\"matr_or[". $i . "]\" VALUE=\"$matricula\">";
                 echo "<tr>\n";
                 echo "<td bgcolor=\"#e0e0e0\" >\n";
                 echo "<font class=\"corpo\">\n";
                             $msg_obs="&nbsp;";
                             $flag="n";
/*
                 $retorno=verifica_ferias($matricula,$MES_AVALIACAO,$ANO_AVAL);
                 if ($retorno<> 0)
                    { 
                      $expl_retorno=explode(":::",$retorno);
                      $data_ini=$expl_retorno[0];
                      $data_fim=$expl_retorno[1];
                      $texto_motivo=$expl_retorno[2];
                      $msg_obs="<b>".$texto_motivo." de:".DATE_FORMAT_USER($data_ini)." ate: ".DATE_FORMAT_USER($data_fim)."</b>" ;
                      $flag="y";
                    }
                    else
                           {
                             $msg_obs="&nbsp;";
                             $flag="n";
                           }
*/ 
      
#INICIO incluido para checar empregados que nao estejam nas listas de ferias/licença do RH      
      switch ($matricula)

          {
            case  312300:
            case  292770:
            case  225655:
            case  334082:
                         $msg_obs="<b>Empregado em Licenca<b>" ;
                         $flag="y";
                         break;
           
            case  106783:
            case  234237:
                         $msg_obs="<b>Empregado em viagem Exterior<b>" ;
                         $flag="y";
                         break;

            case  225570:
            case  294760:
                         $msg_obs="<b>Empregado em Mestrado<b>" ;
                         $flag="y";
                         break;
            case  310064:
            case  312532:
            case  326593:
                         $msg_obs="<b>Empregado em Doutorado<b>" ;
                         $flag="y";
                         break;

            case  310761:
                         $msg_obs="<b>Empregado  a disposicao do SINPAF<b>" ;
                         $flag="y";
                         break;
            case  336109:
                         $msg_obs="<b>Empregado com contrato suspenso<b>" ;
                         $flag="y";
                         break;
            case 314364:
            case 225594:
            case 262886:
            case 259837:
            case 308243:
            case 317204:
            case 276116:
            case 314144:
            case 326568:
            case 258084:
            case 311573:
            case 312532:
            case 315531:
            case 348094:
            case 220787:

                         $msg_obs="<b>Empregado em Ferias<b>" ;
                         $flag="y";
                         break;
 

          }


#FIM -incluido para checar empregados que nao estejam as listas de ferias/licença do RH      

       echo $i;
       echo "-";
       echo $matricula;
       echo "-";
       echo $lista1[1];
       echo "</font>\n";
       echo "</td>\n";
       if ($flag=="n")
        {
          echo "<td bgcolor=\"#e0e0e0\">\n";
        }  
         else
             {
              echo "<td bgcolor=\"#b8b8b8\">\n";
             }
       echo "<font class=\"corpo\">\n";
       echo $msg_obs; 
       echo "</font>\n";
       echo "</td>\n";
       echo "<td bgcolor=\"#ffff99\">\n";
       $str_elegivel="SELECT matr_or
                            FROM escolha
                            WHERE matr_da='$matr_ret'
                            AND matr_or='$matricula'
                            AND ano='$ANO_REF'";
       $res_elegivel=sql($BD3,$str_elegivel);
       $conta_entradas= mysql_num_rows($res_elegivel); 

       if ($conta_entradas >= 1) 
          {
            $eleg=1;
          }
            else
                 {
                   $eleg=0;
                 }
       
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

       echo "</tr>\n";
       $i++;
     }
  }
echo "</table>";
echo "</center>";

echo "<center>";
   echo "<table width=\"80%\">\n";

   //**** PLACE FUNCTION LETTER IN BUTTON NAMES TO CONVEY STATE ****
   echo "<tr>\n";
   echo "<td  align=center >";
   print "<input type=\"submit\" name=\"Submit\" value=\"Gravar\">\n";
   echo "</td>\n";
/*
   echo "<td>";
   print "<input type=\"submit\" name=\"Voltar\" value=\"Voltar sem gravar\">\n";
   echo "</td>";
*/
   echo "</tr>\n";
   echo "</table>\n";
   echo "</center>\n";

echo "</form>";
rodape();
?>
