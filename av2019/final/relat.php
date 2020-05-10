<?
include ("../../func_avalia.php3");

echo "<br>\n";


   $ret=sql("$BD3","select $BD1.empregados.nome,$BD3.final.*
                           from $BD3.final,$BD1.empregados
                           where $BD1.empregados.matr=$BD3.final.matr
                           and $BD3.final.ano='$ANO_REF'
                           order by $BD3.final.agrup;");

echo "<center>";
echo "<table width=\"60%\">";
while ($lista=mysql_fetch_row($ret))
    {
      echo "<tr>";
      echo "<td>";
      echo $lista[2];
      echo "</td>";
      echo "<td>";
      echo $lista[0];
      echo "</td>";
      echo "<td>";
      echo $lista[4];
      echo "</td>";
      echo "<td>";
      echo $lista[5];
      echo "</td>";
      echo "<td>";
      echo $lista[6];
      echo "</td>";
      echo "<td>";
      echo $lista[7];
      echo "</td>";
/*
      echo "<td>";
      echo $lista[8];
      echo "</td>";
      echo "<td>";
      echo $lista[9];
      echo "</td>";
      echo "<td>";
      echo $lista[10];
      echo "</td>";
      echo "<td>";
      echo $lista[11];
      echo "</td>";
*/
      echo "</tr>";
    }
echo "</table>";
echo "</center>";

?>
