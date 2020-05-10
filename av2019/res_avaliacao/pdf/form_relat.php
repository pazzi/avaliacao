<?
include("../func_estagio.php3");

$ip=$REMOTE_ADDR;
if (verificaUser($cookie_user, $cookie_stamp, $ip, "ak")!=1){
header("Location:http://$HTTP_HOST/$VAR_SIST_SEG/main.php3");
exit();
}

$id=$_GET["parm"];
echo "<center><font size=\"+1\"><b>Emissao de relatorios dados adicionais</b></font> <br><br>";
echo "<form action=\"zz3.php\" method=\"POST\">\n";
echo "<input type=\"hidden\" name=\"HILid\" value=\"$id\">";
echo "<table border=1 width=80%><tr>\n";

/*
echo "<tr>\n";
echo "<td>";
echo "Representante: </td><td>\n";
echo "<input type=\"text\" name=\"TIcarga_hor\" value=\"$carga_hor\" size=11 maxlength=10>";
echo "</td></tr>\n";
*/

echo "<tr>\n";
echo "<td>";
echo "Data do convenio de estagio: </td><td>\n";
#echo "<input type=\"text\" name=\"TIdia\"  size=31 maxlength=30>";
 echo "<select name=dia>";
 for ($i=1;$i <= 30; $i++)
      {
       echo "<option value=\"$i\"" ;echo ">$i";
      }
 echo "</select>";
 echo "<select name=mes>";
 for ($i=1;$i <= 12; $i++)
      {
       echo "<option value=\"$i\"" ;echo ">$i";
      }
 echo "</select>";
 $year1=date(Y)-1;
 $year2=date(Y)+1;
 echo "<select name=ano>";
 for ($i=$year1;$i <= $year2; $i++)
      {
       echo "<option value=\"$i\"" ;echo ">$i";
      }
 echo "</select>";
echo "</td></tr>\n";

echo "<tr>\n";
echo "<td>";
echo "Numero do SAIC: </td><td>\n";
echo "<input type=\"text\" name=\"TIsaic\"  size=31 maxlength=30>";
echo "</td></tr>\n";


echo "<td>";
echo "Representante da Instituicao de ensino: </td><td>\n";
echo "<input type=\"text\" name=\"TIrepresentante_instituicao\" size=80 maxlength=80 value=\"Reitor Abbbb Cddddd Ghhhhh\">";
echo "</td></tr>\n";

 echo "<tr>";
 echo "<td>";
 echo "Semestre de inicio do curso:</td> ";
 echo "<td>";
 echo "<select name=TIcurso_inicio_semestre>";
 echo "<option value=\"primeiro\"" ;echo ">primeiro";
 echo "<option value=\"segundo\"" ;echo ">segundo";
 echo "</select>";
 echo "&nbsp;&nbsp;&nbsp;&nbsp;Ano de inicio do curso:";
 #echo "<input type=\"text\" name=\"TIcurso_inicio_ano\" size=11 maxlength=10>";
 $year1=date(Y)-4;
 $year2=date(Y);
 echo "<select name=TIcurso_inicio_ano>";
 for ($i=$year1;$i <= $year2; $i++)
      {
       echo "<option value=\"$i\"" ;echo ">$i";
      }
 echo "</select>";
 echo "</td></tr>";

 echo "<tr>";
 echo "<td>";
 echo "Semestre de fim do curso:</td> ";
 echo "<td>";
 echo "<select name=TIcurso_conclusao_semestre>";
 echo "<option value=\"primeiro\"" ;echo ">primeiro";
 echo "<option value=\"segundo\"" ;echo ">segundo";
 echo "</select>";
 echo "&nbsp;&nbsp;&nbsp;&nbsp;Ano de conclusao do curso:";
 #echo "<input type=\"text\" name=\"TIcurso_conclusao_ano\" size=11 maxlength=10>";
 $year1=date(Y);
 $year2=date(Y)+4;
 echo "<select name=TIcurso_conclusao_ano>";
 for ($i=$year1;$i <= $year2; $i++)
      {
       echo "<option value=\"$i\"" ;echo ">$i";
      }
 echo "</select>";
 echo "</td></tr>";

echo "<tr>\n";
echo "<td>";
echo "Horario do curso </td><td>\n";
echo "<input type=\"text\" name=\"TIcurso_horario\" size=31 maxlength=30 value=\"das 19 as 23 horas\"> ";
echo "</td></tr>\n";

echo "<tr>\n";
echo "<td>";
echo "Horario do estagio </td><td>\n";
echo "<input type=\"text\" name=\"TIestagio_horario\" size=31 maxlength=30 value=\"das 13 as 17 horas\">";
echo "</td></tr>\n";

 echo "<tr>";
 echo "<td>";
 echo "Quantidade de hora diarias do estagio:</td> ";
 echo "<td>";
 echo "<select name=TIhoras_diarias>";
 echo "<option value=\"4\"" ;echo ">4";
 echo "<option value=\"6\"" ;echo ">6";
 echo "</select>";
 echo "</td></tr>\n";


echo "<tr>\n";
echo "<td>";
echo "Seguradora: </td><td>\n";
echo "<input type=\"text\" name=\"TIseguradora\"  size=61 maxlength=60>";
echo "</td></tr>\n";

echo "<tr>\n";
echo "<td>";
echo "Apolice: </td><td>\n";
echo "<input type=\"text\" name=\"TIapolice\"  size=21 maxlength=20>";
echo "</td></tr>\n";

 echo "<tr>";
 echo "<td>";
 echo "Estagio na area de:</td> ";
 echo "<td>";
 echo "<select name=TIarea_atuacao>";
 echo "<option value=\"Administracao\"" ;echo ">Administracao";
 echo "<option value=\"Transferencia de Tecnologia\"" ;echo ">Transferencia de Tecnologia";
 echo "<option value=\"Pesquisa e Desenvolvimento\"" ;echo ">Pesquisa e Desenvolvimento";
 echo "</select>";
 echo "</td></tr>\n";

echo "<tr>\n";
echo "<td>";
echo "<input type=\"submit\" value=\"Submit\">";
echo "</td><td>";
echo "<input type=\"reset\" value=\"Cancel\">";
echo "</td></tr></table>";
print "</form>\n";
rodape();
 //**** END MAIN PROGRAM ****
?>
