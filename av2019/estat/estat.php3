<?php
include ("../../func_avalia.php3");
cabecalho();

function le_empregados()
{
 global $BD1;
 $sql_matr="select matr,nome from empregados where tipo='e' and situacao='a' order by nome";
 $ret=sql($BD1,$sql_matr);
 return($ret);
}
$parm=$_GET["parm"]; 

switch ($parm)
    {
      case g:
             $ret=estat_geral_geral($ANO_REF);
             break;
             
    }
echo "<center><font class=\"title\"><u>A v a l i a c a o  - 2 0 0 9 - A n o &nbsp;&nbsp; B a s e  - $ANO_REF</u></font></center>";

echo "<table border=1>";
echo "<tr>";
echo "<td>";
echo "Competencia";
echo "</td>";
echo "<td>";
echo "Medias";
echo "</td>";
echo "</tr>";

while ($lista=mysql_fetch_row($ret))
{
     echo "<tr>";
     echo "<td>";
          echo $lista[0];
          echo "-";
          echo retorna_texto($lista[0]);
     echo "</td>";
     echo "<td>";
          echo $lista[1];
     echo "</td>";
     echo "</tr>";
}
echo "</table>";
rodape();
?>
