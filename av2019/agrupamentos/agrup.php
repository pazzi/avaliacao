<?php
include ("../func_avalia.php");
if ((!$_GET["ano"]) AND (!$_POST["TIano"]))
		{
          		echo "Parametro ano deve ser passado na referencia - contate o suporte";
          		exit();
        	}elseif ($_GET["ano"])
                	{
				$ano=$_GET["ano"];
                	}elseif ($_POST["TIano"])
				{
					$ano=$_POST["TIano"];
				}


/*
$ip=$REMOTE_ADDR;
if (verificaUser($cookie_user, $cookie_stamp, $ip, "be")!=1)
{
header("Location:http://$HTTP_HOST/$VAR_SEG/main.php3");
exit();
}
*/

echo "<br>\n";
 //**** BEGIN GLOBAL VARIABLES ****
 $fcn = BNone;
 //**** END GLOBAL VARIABLES ****


 //**** BEGIN GENERIC SQL FUNCTIONS ****


 function listInOrder($ano)
   {
	global $BD4;
 	return sql("$BD4","SELECT Agrupamento.*
	FROM Agrupamento
	WHERE ano_referencia = '$ano'
	ORDER BY Agrupamento.descricao;");

   }

 function lookup($id)
   {
	global $BD4;
   return sql("$BD4","SELECT * FROM Agrupamento where cod_agrupamento='$id';");
   }

 function deleteByLastname($id)
   {
   return sql("$BD4","DELETE FROM Agrupamento where cod_agrupamento='$id';");
   }


 //**** END GENERIC SQL FUNCTIONS ****


 //**** BEGIN HIGH LEVEL APP UTILITY FUNCTIONS ****

 function presentInputForm($cod_agrupamento,$descricao, $ano_referencia, $numero,$ano, $fcnLetter)
 {
   global $ANO_REF;
   switch ($fcnLetter)
     {
     case "E":
     case "A":
       break;
     default: 
       echo "<p><h1>Letra de funcao ilegal ($fcnLetter) in presentInputForm()<p>\n";
  echo "<p><a href=\"agrup.php\">Volte para selecionar
</a>
</h1>
<p>\n";
return;
       break;
     }

   echo "<center>\n";

   echo "<table class=\"table\">\n";
   echo "<tr>\n";
   echo "<td colspan=2 align=center>\n";
  echo "<h3><b>Agrupamentos</b></h3>";
   echo "</td>\n";
   echo "</tr>\n";

   echo "<form action=\"agrup.php\" method=\"POST\">\n";

   echo "<tr>\n";
   echo "<td>\n";
  echo "Id:";
   echo "</td>\n";
   echo "<td>\n";
   switch ($fcnLetter)
     {
     case "E":                   //don't allow editing of key value
       echo "$cod_agrupamento";
       echo "<input type=\"hidden\" name=\"HILid\" value=\"$cod_agrupamento\">\n";
       break;
     case "A":                   //don't allow editing of key value
       echo "novo";
       echo "<input type=\"hidden\" name=\"TIid\" value=\"$cod_agrupamento\" size=11 maxlength=11>\n";
       echo "[novo]";
       break;
     }
   echo "</td>\n";

   echo "</tr>\n";


   echo "<tr>\n";
   echo "<td>\n";
   echo "Descricao: ";
   echo "</td>\n";
   echo "<td>\n";
   echo "<input type=\"hidden\" name=\"TIano\" value=\"$ano\">\n";
   echo "<input type=\"text\" name=\"TIdescricao\" value=\"$descricao\" size=50 maxlength=51>\n";
   echo "</td>\n";
   echo "</tr>\n";

/*
   echo "<tr>\n";
   echo "<td>\n";
   echo "Ano: ";
   echo "</td>\n";
   echo "<td>\n";
*/
   echo "<input type=\"hidden\" name=\"TIano_referencia\" value=\"$ANO_REF\" size=4 maxlength=5>\n";
/*
   echo "</td>\n";
   echo "</tr>\n";
*/

   echo "<tr>\n";
   echo "<td>\n";
   echo "Numero do agrupamento: ";
   echo "</td>\n";
   echo "<td>\n";
   echo "<input type=\"text\" name=\"TInumero\" value=\"$numero\" size=5 maxlength=5>\n";
   echo "</td>\n";
   echo "</tr>\n";

	
   echo "<tr>";
   //**** PLACE FUNCTION LETTER IN BUTTON NAMES TO CONVEY STATE ****
   echo "<td colspan=2>";
   echo "<center>";
   echo "<table>";
   echo "<tr>";
   echo "<td>";
   echo "<input type=submit name=B" . $fcnLetter . "Submit value=Submit>\n";
   echo "</td>";
   echo "<td>";
   echo "<input type=submit name=B" . $fcnLetter . "Cancel value=Cancel>\n";
   echo "</td>";
   echo "</tr>";
   echo "</table>";
   echo "</center>";
   echo "</td>";
   echo "</tr>";

   echo "</form>\n";
   echo "</table>";
   echo "</center>";

   }

 function fillSelect($ano)
   {
   $result=listInOrder($ano); //THIS REPLACES FORMER INLINE pg_ CALLS!


   echo "<center>\n";
   echo "<table class=\"table table-striped\">";
   echo "<thead>\n";
   echo "<tr>\n";
   echo "<th>\n";
   echo "Indicador";
   echo "</th>\n";
   echo "<th>\n";
   echo "Ind";
   echo "</th>\n";
   echo "<th>\n";
   echo "Agrupamento";
   echo "</th>\n";
   echo "<th>\n";
   echo "Ano";
   echo "</th>\n";
   echo "<th>\n";
   echo "Numero";
   echo "</th>\n";
   echo "<th>\n";
   echo "Del";
   echo "</th>\n";
   echo "</tr>\n";
   echo "</thead>\n";
   echo "<tbody>\n";

   while ($lista= mysql_fetch_row($result))
     {
	$id=$lista[0];
       echo "<tr>\n";
       echo "<td>\n";
       echo "<a href=./cadastra_indicador.php?id=$id&ano=$ano>Def/Alt</a>";
       echo "</td>\n";
       echo "<td>\n";
       echo $lista[0];
       echo "</td>\n";
       echo "<td>\n";
       echo "<a href=./agrup.php?parm=BEdit:::$id&ano=$ano>";
       echo $lista[1];
       echo "</a>";
       echo "</td>\n";
       echo "<td>\n";
       echo $lista[2];
       echo "</td>\n";
       echo "<td>\n";
       echo $lista[3];
       echo "</td>\n";
       echo "<td>\n";
       echo "<a href=./agrup.php?parm=BDelete:::$id&ano=$ano>";
	echo "Excluir";
       echo "</a>";
       echo "</td>\n";
       echo "</tr>\n";
     }
   echo "</tbody>\n";
   echo "</table>\n";
  echo "</center>\n";

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

 function doEdit($id,$ano)
   {
	$result = lookup($id);

   presentInputForm(
         mysql_result($result, 0, "cod_agrupamento"),
         mysql_result($result, 0, 1),
         mysql_result($result, 0, 2),
         mysql_result($result, 0, 3),
	 $ano,
"E");
   }

 function doAdd($ano)
   {
	global $_POST;
   presentInputForm("", "", "", "",$ano,"A");
   }

 function doDelete($id,$ano)
   {
  $result=lookup($id);
   for($column=0; $column < mysql_num_fields($result); $column++)
     {
     echo mysql_field_name($result, $column) . "=";
     echo mysql_result ($result, 0, $column) . "<br>\n";
     }
   echo "<form  action=\"agrup.php\" method=\"POST\">\n";
   echo "<input type=\"hidden\" name=\"HDid\" value=\"$id\">\n";
   echo "<input type=\"hidden\" name=\"TIano\" value=\"$ano\">\n";
   echo "<input type=\"submit\" name=\"BDDelete\" value=\"Delete\">\n";
   echo "&nbsp;&nbsp;\n";
   echo "<input type=\"submit\" name=\"BDCancel\" value=\"Cancel\">\n";
   echo "&nbsp;&nbsp;\n";
   echo "</form>\n";
   }

 function doGeneric($ano)
   {
   fillSelect($ano);
   }

 function editToDB()
   {
   global $_POST;
   global $BD4;
   $statement = "UPDATE Agrupamento ";
   $statement .= "SET descricao='" . chop($_POST["TIdescricao"]);
   $statement .= "',ano_referencia='" . chop($_POST["TIano_referencia"]);
   $statement .= "',numero='" . chop($_POST["TInumero"]);
   $statement .= "' WHERE cod_agrupamento='" . chop($_POST["HILid"]);
   $statement .= "';";
   sql($BD4,$statement);
   }

 function addToDB()
   {
   global $_POST;
   global $BD4;

   $statement = "INSERT INTO Agrupamento VALUES ('',";
   $statement .= "'" . $_POST["TIdescricao"] . "', ";
   $statement .= "'" . $_POST["TIano_referencia"] . "', ";
   $statement .= "'" . $_POST["TInumero"] . "'";
   $statement .= ");";
#echo $statement;
   sql($BD4,$statement);
   }

 function deleteFromDB()
   {
   global $_POST;
   global $BD4;
   $id= $_POST["HDid"];
   sql($BD4,"DELETE FROM Agrupamento where cod_agrupamento='$id';");
   #Deletar os relacionamentos
   $str_sql="select id from z_indicador where cod_agrupamento='$id'";
   $res=sql($BD4,$str_sql);
   while ($lis_id = mysql_fetch_row($res))
	{
	 sql($BD4, "DELETE FROM z_itens WHERE id_indicador='$lis_id[0]'");
	}
   sql ($BD4,"DELETE from z_indicador where cod_agrupamento='$id'");

   }

 //**** END STATE-SPECIFIC SUBROUTINES ****


 //**** BEGIN MAIN PROGRAM ****
cabecalho(ANO_REF);
echo "<h3>Administracao de agrupamentos ano base $ano</h3>";
echo "<br>";
echo "<a href=$REFERER/agrupamentos/agrup.php?parm=BAdd:::&ano=$ano>Novo agrupamento</a>";

 setGlobals();

  if ($_GET["parm"])
    {
     $reg=explode(":::",$_GET["parm"]);
     $fcn=$reg[0];
     $id=$reg[1];
    }


 switch ($fcn)
   {
   case "BEdit":
     doEdit($id,$ano);
     break;
   case "BAdd":
     doAdd($ano);
     break;
   case "BDelete":
     doDelete($id,$ano);
     break;
   case "BESubmit":
     editToDB();
     doGeneric($_POST["TIano"]);
     break;
   case "BASubmit":
     addToDB();
     doGeneric($_POST["TIano"]);
     break;
   case "BDDelete":
     deleteFromDB();
     doGeneric($_POST["TIano"]);
     break;
   case "BSair":
     Header("Location: http://www.cnpma.embrapa.br/$LOCAL_SERVER/$AMBIENTE/");
     break;
   case "BACancel":
   case "BDCancel":
   case "BECancel":
     doGeneric($_POST["TIano"]);
     break;
   case "BNone":
     doGeneric($ano);
     break;
                
   default:
     echo "Illegal function identifier encountered:$fcn:<p>\n";
     break;
   }

echo "<br>";
echo "<br>";
rodape();
//**** END MAIN PROGRAM ****
 ?>
