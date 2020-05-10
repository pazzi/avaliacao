<?
include ("../../func_avalia.php3");
cabecalho();

/*
$ip=$REMOTE_ADDR;
if (verificaUser($cookie_user, $cookie_stamp, $ip, "av")!=1)
{
header("Location:http://$HTTP_HOST/$VAR_SEG/main.php");
exit();
}
*/

$user=$POST["user"];

 if (($RESP_SGP_LOGIN1 == $user) OR ($RESP_SGP_LOGIN2 == $user) )
   {
    echo "<a href=./index.php>Modulo especifico do SGP</a>";
    exit();
   }


echo "<br>\n";

 //**** BEGIN GLOBAL VARIABLES ****
 $fcn = BNone;
 //**** END GLOBAL VARIABLES ****

 //**** BEGIN GENERIC SQL FUNCTIONS ****

 function listInOrder()
   {
   global $BD3;
   global $BD1;
   global $ANO_REF;
   $res_sql="select $BD3.final.id,
                                  $BD3.final.matr,
                                  $BD1.empregados.nome,
                                  $BD3.final.cargo,
                                  $BD3.final.agrup
                           from $BD3.final,$BD1.empregados
                           where $BD1.empregados.matr=$BD3.final.matr
                           AND $BD3.final.ano='$ANO_REF'
                           order by $BD1.empregados.nome;";
   return sql("$BD3",$res_sql);
   }


 function lookup($id)
   {
   global $BD3;
   return sql("$BD3","SELECT * FROM final where id='$id';");
   }

 function deleteByLastname($id)
   {
   return sql("$BD3","DELETE FROM final where id='$id';");
   }

 //**** END GENERIC SQL FUNCTIONS ****


 //**** BEGIN HIGH LEVEL APP UTILITY FUNCTIONS ****

 function presentInputForm($id, $matr, $cargo, $agrup, $eaf, $ecom, $epp, $n_ref, $ref, $tipo, $obs,$ano, $fcnLetter)
    {
     global $BD3;
     global $BD1;
     global $ANO_REF;
   switch ($fcnLetter)
     {
     case "E":
     case "A":
       break;
     default: 
       print "<p><h1>Letra de funcao ilegal ($fcnLetter) in presentInputForm()<p>\n";
  print "<p><a href=\"cadastra.php\">Volte para selecionar </a>";
return;
       break;
     }

   echo "<font class=corpo><b>Cadastramento</b></font> <br><br>";
   print "<form action=\"cadastra.php\" method=\"POST\">\n";

   $res_sql_nome= sql($BD1,"select $BD1.empregados.nome from $BD1.empregados where $BD1.empregados.matr='$matr'");
   $res_nome= mysql_result($res_sql_nome,0,"nome");

   switch ($fcnLetter)
     {
     case "E":                   //don't allow editing of key value
       echo " $id\n";
       echo " - ";
       echo " $res_nome\n";

       $rec_nome=sql($BD1,"SELECT matr,nome 
                    FROM empregados
                    WHERE empregados.tipo='e'
                    AND empregados.situacao='a'
                    ORDER BY nome;");

       print "<input type=\"hidden\" name=\"HILid\" value=\"$id\">\n<br>";
       print "<input type=\"hidden\" name=\"TImatr\" value=\"$matr:::$res_nome\">\n<br>";
       break;
     case "A":
              $rec_nome=sql($BD1,"SELECT $BD1.empregados.matr, $BD1.empregados.nome
                    FROM $BD1.empregados
                    WHERE $BD1.empregados.tipo = 'e'
                    AND $BD1.empregados.situacao = 'a'
                    AND $BD1.empregados.matr NOT IN ( SELECT matr FROM $BD3.final WHERE ano=$ANO_REF)
                    ORDER BY $BD1.empregados.nome;");

   echo "<br>Matricula: ";
       break;
     }
   
      if ($fcnLetter =="A")
         {
            echo "<SELECT NAME=\"TImatr\">\n";
            while ($lista4=mysql_fetch_row($rec_nome))
             {
               if ($lista4[0]== $matr)
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
          }
   echo "<br>";
   echo "<br><i>Atencao:Utilize pontos nas casas decimais</i>";
   echo "<br>";
   print "<br>EAF: ";
   print "<input type=\"text\" name=\"TIeaf\" value=\"$eaf\" size=10 maxlength=10>\n<br>";

   print "<br>ECOM: ";
   print "<input type=\"text\" name=\"TIecom\" value=\"$ecom\" size=10 maxlength=10>\n<br>";

   print "<br>EPP: ";
   print "<input type=\"text\" name=\"TIepp\" value=\"$epp\" size=10 maxlength=10>\n<br>";
/*
   print "<br>Classificacao no agrupamento: ";
   print "<input type=\"text\" name=\"TIclass\" value=\"$class\" size=2 maxlength=2>\n<br>";
*/

   print "<br>Numero de Referencias : ";
   print "<input type=\"text\" name=\"TIn_ref\" value=\"$n_ref\" size=2 maxlength=2>\n<br>";

   print "<br>Nova referencia: ";
   print "<input type=\"text\" name=\"TIref\" value=\"$ref\" size=5 maxlength=5>\n<br>";

#   print "<br>Tipo (e-elegivel n-Nao elegivel): ";
#   print "<input type=\"text\" name=\"TItipo\" value=\"$tipo\" size=2 maxlength=2>\n<br>";

   echo "<br>";
   echo "<br>";
   echo "<INPUT TYPE=RADIO NAME=\"TItipo\" VALUE=\"e\"";
         if ($tipo=="e")
          {
            echo " checked>Elegivel";
          }
           else
               {
                echo " >Elegivel";
               }
     echo "<INPUT TYPE=RADIO NAME=\"TItipo\" VALUE=\"n\"";
         if ($tipo=="t")
          {
            echo " checked>Nao elegivel";
          }
           else
               {
                echo " >Nao elegivel";
               }

   echo "<br>";
   echo "<br>";

   print "<br>Observacaoes: ";
   print "<input type=\"text\" name=\"TIobs\" value=\"$obs\" size=50 maxlength=200>\n<br>";
   print "<input type=\"HIDDEN\" name=\"TIano\" value=\"$ANO_REF\">\n<br>";


   //**** PLACE FUNCTION LETTER IN BUTTON NAMES TO CONVEY STATE ****
   print "    <p><input type=\"submit\" name=\"B" . $fcnLetter;
   print "Submit\" value=\"Submit\">\n";
   print "&nbsp;&nbsp;\n";

   print "<input type=\"submit\" name=\"B" . $fcnLetter;
   print "Cancel\" value=\"Cancel\">\n";
   print "</form>\n";

   }

 function fillSelect()
   {
   $result=listInOrder(); //THIS REPLACES FORMER INLINE pg_ CALLS!

   print "<form  action=\"cadastra.php\" method=\"POST\">\n";
   echo  "<font class=title> Cadastramento </font> <br><br>";
   print "<select name=\"DROWS\" size=\"1\">\n";
   print "<pre>";

   for($row=0; $row < mysql_num_rows($result); $row++)
     {
     print "  <option>";
     for($column=0; $column < mysql_num_fields($result); $column++)
       {
       print mysql_result ($result, $row, $column) . ":::";
       }
     print "<br></option>\n";
     }
   print "</pre>";
   print "</select></font>\n";
   print "&nbsp;&nbsp;\n";
   print "<input type=\"submit\" name=\"BEdit\" value=\"Edit\">\n";
   print "&nbsp;&nbsp;\n";
   print "<input type=\"submit\" name=\"BAdd\" value=\"Add\">\n";
   print "&nbsp;&nbsp;\n";
   print "<input type=\"submit\" name=\"BDelete\" value=\"Delete\">\n";
   print "</form>\n";
   }

 function setGlobals()
   {
   global $_POST;
   if(sizeof($_POST) < 1)
     {
     return;
     }
   global $fcn;
   reset ($_POST);
   while (list ($key, $val) = each ($_POST)) 
     {
     if(substr($key, 0, 1) == 'B') //Only buttons begin with B
       {
       $fcn=$key;
       }
     }
   }

 //**** END HIGH LEVEL APP UTILITY FUNCTIONS ****


 //**** BEGIN STATE-SPECIFIC SUBROUTINES ****

 function doEdit()
   {
   global $_POST;
$regs=explode(":::",$_POST["DROWS"]);
$id= $regs[0];
  if (strlen($id) <= 0)
    {
     echo "Nao existe valores a serem editados";
     echo "<a href=./cadastra.php>Voltar</a> ";
     exit();
    }
$result = lookup($id);

   presentInputForm(
         mysql_result($result, 0, "id"),
         mysql_result($result, 0, 1),
         mysql_result($result, 0, 2),
         mysql_result($result, 0, 3),
         mysql_result($result, 0, 4),
         mysql_result($result, 0, 5),
         mysql_result($result, 0, 6),
         mysql_result($result, 0, 7),
         mysql_result($result, 0, 8),
         mysql_result($result, 0, 9),
         mysql_result($result, 0, 10),
         mysql_result($result, 0, 11),
"E");
   }

 function doAdd()
   {
   global $_POST;
   presentInputForm("", "", "", "","", "", "", "", "", "", "","", "A");
   }

 function doDelete()
   {
   global $_POST;
$regs=explode(":::",$_POST["DROWS"]);
$id= $regs[0];
  $result=lookup($id);
   for($column=0; $column < mysql_num_fields($result); $column++)
     {
     print mysql_field_name($result, $column) . "=";
     print mysql_result ($result, 0, $column) . "<br>\n";
     }
   print "<form  action=\"cadastra.php\" method=\"POST\">\n";
   print "<input type=\"hidden\" name=\"HDid\" value=\"$id\">\n";
      
   print "<input type=\"submit\" name=\"BDDelete\" value=\"Delete\">\n";
   print "&nbsp;&nbsp;\n";
   print "<input type=\"submit\" name=\"BDCancel\" value=\"Cancel\">\n";
   print "&nbsp;&nbsp;\n";
   print "</form>\n";
   }

 function doGeneric()
   {
   fillSelect();
   }

 function editToDB()
   {
   global $BD3;
   global $ANO_REF;
   global $_POST;
   $matr_arr = explode(":::",$_POST["TImatr"]);
   $matr=$matr_arr[0];
   $statement = "UPDATE final ";
   $statement .= "SET matr='" . chop($matr);
   $statement .= "',cargo='" . chop($_POST["TIcargo"]);
   $statement .= "',agrup='" . chop($_POST["TIagrup"]);
   $statement .= "',eaf='" . chop($_POST["TIeaf"]);
   $statement .= "',ecom='" . chop($_POST["TIecom"]);
   $statement .= "',epp='" . chop($_POST["TIepp"]);
#   $statement .= "',class='" . chop($_POST["TIclass"]);
   $statement .= "',n_ref='" . chop($_POST["TIn_ref"]);
   $statement .= "',ref='" . chop($_POST["TIref"]);
   $statement .= "',tipo='" . chop($_POST["TItipo"]);
   $statement .= "',obs='" . chop($_POST["TIobs"]);
   $statement .= "',ano='" . $ANO_REF;
   #$statement .= "',ano='" . chop($_POST["TIano"]);
   $statement .= "' WHERE id='" . chop($_POST["HILid"]);
   $statement .= "';";
   sql("$BD3",$statement);
   }

 function addToDB()
   {
   global $_POST;
   global $BD3;
   global $ANO_REF;
   $matr_arr = explode(":::",$_POST["TImatr"]);
   $matr=$matr_arr[0];
   $statement = "INSERT INTO final VALUES (\"null\" ,";
   $statement .= "'" . $matr . "', ";
   $statement .= "'" . $_POST["TIcargo"] . "', ";
   $statement .= "'" . $_POST["TIagrup"] . "', ";
   $statement .= "'" . $_POST["TIeaf"] . "', ";
   $statement .= "'" . $_POST["TIecom"] . "', ";
   $statement .= "'" . $_POST["TIepp"] . "', ";
#   $statement .= "'" . $_POST["TIclass"] . "', ";
   $statement .= "'" . $_POST["TIn_ref"] . "', ";
   $statement .= "'" . $_POST["TIref"] . "', ";
   $statement .= "'" . $_POST["TItipo"] . "', ";
   $statement .= "'" . $_POST["TIobs"] . "', ";
   $statement .= "'" . $ANO_REF . "'";
   #$statement .= "'" . $_POST["TIano"] . "'";
   $statement .= ");";
#echo $statement;
   sql("$BD3",$statement);
}
 function deleteFromDB()
   {
   global $_POST;
   global $BD3;
   $id= $_POST["HDid"];

   sql("$BD3","DELETE FROM final where id='$id';");

   }

 //**** END STATE-SPECIFIC SUBROUTINES ****


 //**** BEGIN MAIN PROGRAM ****
// header('<META HTTP-EQUIV="pragma" CONTENT="nocache">'); 
 setGlobals();

 switch ($fcn)
   {
   case "BEdit":
     doEdit();
     break;
   case "BAdd":
     doAdd();
     break;
   case "BDelete":
     doDelete();
     break;
   case "BESubmit":
     editToDB();
     doGeneric();
     break;
   case "BASubmit":
     addToDB();
     doGeneric();
     break;
   case "BDDelete":
     deleteFromDB();
     doGeneric();
     break;
   case "BACancel":
   case "BDCancel":
   case "BECancel":
   case "BNone":
     doGeneric();
     break;
   default:
     print "Illegal function identifier encountered:$fcn:<p>\n";
     break;
   }
echo "<br>";
echo "<br>";
echo "<center><a href=./login.php><font class=corpo>Sair</font></a>";
echo "<br>";
echo "<center><a href=./relat.php><font class=corpo>Relatorio</font></a>";
echo "<br>";
echo "<br>";
#require ("/usr/local/www/data/inc/rodape.inc");

 //**** END MAIN PROGRAM ****
?>
