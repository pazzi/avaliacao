<?php
include ("../func_avalia.php3");


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

#$cod_ret=1;

   if ($cod_ret == 0)
   {
    echo "<a href=./index.php>User-id ou Senha inválidos - entre novamente</a>";
    exit();
   }


cabecalho();


$sql_str="select matr,nome from empregados where email='$user'";
$sql_matr=sql($BD1,"select matr,nome from empregados where email='$user'");
$matr_ret=mysql_result($sql_matr,0,"matr"); 
$nome=mysql_result($sql_matr,0,"nome"); 


//*****************************

$final="select matr,eaf,ecom,epp,n_ref,ref,tipo,obs,NFI from final where matr='$matr_ret' AND ano='$ANO_REF';";

$final_str=sql("$BD4",$final);
echo  "<br>\n";
echo  "<br>\n";
echo  "<center>\n";
echo "<h3>Progressão Salarial - $ANO_AVAL (ref. $ANO_REF)</H3>";
echo  "<br>\n";
echo  "<br>\n";

echo "<table class=\"table table-striped\" >\n";
while ($lista12=mysql_fetch_row($final_str))
 {

	echo "<tr class=\"info\">\n";
	echo "<td  colspan=\"2\" align=\"center\">\n";
	echo "<h4>\n";
	$matr=$lista12[0];
	echo $matr;
	echo " - ";
	echo $nome;
	echo "</h4>\n";
	echo "</td>\n";
	echo "</tr>\n";

   echo "<tr>\n";
   echo "<td align=\"left\">\n";
   echo "Agrupamento Funcional";
   echo "</td>\n";
   echo "<td align=\"center\">\n";

  $str_agrup_final="SELECT final.agrup 
                    FROM final 
                    WHERE final.ano='$ANO_REF'
                    AND final.matr='$matr_ret'";
   $result_agrup_final=sql($BD4,$str_agrup_final);  
   $agrup_final= mysql_result($result_agrup_final,0,0);

   echo $agrup_final;
   echo "</td>\n";
   echo "</tr>\n";

   echo "<tr>";
   echo "<td>";
   echo "NFI";
   echo "</td>";
   echo "<td align=\"center\">\n";
   echo $lista12[8]; 
   echo "</td>\n";
   echo "</tr>\n";

   echo "<tr>\n";
   echo "<td align=\"left\">\n";
   echo "Número de referências salariais obtidas";
   echo "</td>\n";
   echo "<td align=\"center\">\n";
   echo $lista12[4];
   echo "</td>\n";
   echo "</tr>\n";

   echo "<tr>\n";
   echo "<td align=\"left\">\n";
   echo "Nova referência salarial";
   echo "</td>\n";

   if ($lista12[6]=="E")
      {
        echo "<td align=\"center\">\n";
        echo $lista12[5]; 
        echo "</td>\n";
      }
        else
             {
               echo "<td align=\"center\">\n";
               echo "<b>Empregado inelegível</b>";
               echo "</td>\n";
             }

   echo "</td>\n";
   echo "</tr>\n";

   echo "<tr>\n";
   echo "<td align=\"left\">\n";
   echo "Observacoes";
   echo "</td>\n";
   echo "<td align=\"center\">\n";
   echo $lista12[7]; 
   echo "</td>\n";
   echo "</tr>\n";
}

echo "</table>\n";
echo "</center>\n";

#$sql_dados="select count(final.id) as num,max(final.eaf) as eaf_max,max(final.ecom) as ecom_max,max(final.epp), min(final.eaf),min(final.ecom), min(final.epp), avg(final.eaf), avg(final.ecom), avg(final.epp)
$sql_dados="select count(final.id) as num,max(final.NFI) as NFI_max, min(final.NFI), avg(final.NFI)
             from final
             where final.agrup='$agrup_final'
             and final.tipo='e' 
             and final.ano='$ANO_REF';";

$dados=sql($BD4,$sql_dados);

echo "<br>\n";
echo "<br>\n";
echo "<center>\n";
echo "<H4> I n f o r m a c o e s  &nbsp;&nbsp;&nbsp;&nbsp; A d i c i o n a i s</H4>";
echo "<H5> Do agrupamento funcional</H5>";
echo "<br>";
echo "</center>\n";
echo "<center>\n";
echo "<H6>\n";
echo "Agrupamento ";
echo $agrup_final; 
$num_empr_agrup=mysql_result($dados,0,0);
echo "  com ". $num_empr_agrup . " empregados elegiveis";
echo "</H6>\n";

echo "<table class=\"table table-striped\" >\n";
echo "<tr>\n";
echo "<td>\n";
echo "NFI maximo do agrupamento" ;
echo "</td>\n";
echo "<td align=\"center\">\n";
echo mysql_result($dados,0,1);
echo "</td>\n";
echo "</tr>\n";

echo "<tr>\n";
echo "<td>\n";
echo "NFI minimo do agrupamento" ;
echo "</td>\n";
echo "<td align=\"center\">\n";
echo mysql_result($dados,0,2);
echo "</td>\n";
echo "</tr>\n";

echo "<tr>\n";
echo "<td>\n";
echo " NFI medio do agrupamento" ;
echo "</td>\n";
echo "<td align=\"center\">\n";
echo round(mysql_result($dados,0,3),4);
echo "</td>\n";
echo "</tr>\n";
echo "</table>\n";
echo "</center>\n";



echo "<br>\n";



/*
$res_distr=sql($BD4,"SELECT agrup,n_ref, count( n_ref ) FROM `final` where final.ano='$ANO_REF' AND tipo='e'  and agrup='$agrup_final' GROUP BY agrup, n_ref");

echo "<br>";
echo "<center>";
echo "<H6>Quadro de distribuicao de referencias do agrupamento ";
echo $agrup_final;
echo "</H6>";
echo "</center>";
echo "<center>";
echo "<table class=\"table table-striped\">";
echo "<tr>";
echo "<td>\n";
echo "Numero de referencias";
echo "</td>";
echo "<td align=right>\n";
echo "Empregados contemplados";
echo "</td align=left>";
echo "</tr>";
while ($lis_dist=mysql_fetch_row($res_distr))
   {
     echo "<tr>\n";
     echo "<td>\n";
     echo $lis_dist[1];
     echo "</td>\n";
     echo "<td align=right>\n";
     echo $lis_dist[2];
     echo "</td>\n";
     echo "</tr>\n";
   }
echo "</table>";
echo "</center>";
echo "<br>";
echo "<br>";
*/


echo "<center>";
echo "<H5> Da Unidade</H5>";
echo "</center>";
$sql_dados="select count(id) as id,max(NFI),min(NFI), avg(NFI) from final where tipo='e' and ano='$ANO_REF';";
$dados=sql("$BD4",$sql_dados);

echo "<center>\n";
echo "<H6>\n";
echo "Medias da Unidade";
echo "  com ". mysql_result($dados,0,0) . " empregados elegiveis";
echo "</H6>\n";

echo "<table class=\"table table-striped\" >\n";
echo "<tr>\n";
echo "<td>\n";
echo "NFI maximo dos empregados elegiveis" ;
echo "</td>\n";
echo "<td align=\"center\">\n";
echo mysql_result($dados,0,1);
echo "</td>\n";
echo "</tr>\n";
echo "<tr>\n";
echo "<td>\n";
echo "NFI minimo dos empregados elegiveis" ;
echo "</td>\n";
echo "<td align=\"center\">\n";
echo mysql_result($dados,0,2);
echo "</td>\n";
echo "</tr>\n";
echo "<tr>\n";
echo "<td>\n";
echo "NFI medio dos empregados elegíveis" ;
echo "</td>\n";
echo "<td align=\"center\">\n";
echo round(mysql_result($dados,0,3),4);
echo "</td>\n";
echo "</tr>\n";
echo "</table>\n";
echo "</center>\n";
echo "<br>";
echo "<br/>";
echo "<center>";
echo "<H6>Caso queira opinar sobre a automacao das rotinas de avaliacao de competencias, por favor responda 3 
<a href=\"https://spreadsheets.google.com/spreadsheet/viewform?formkey=dGplOGtRT1plOHM0VmlEV1Z3dWFXMlE6MQ\">questoes</a> e deixe ou nao seus comentarios.";
echo "<br>";
echo "</center>";
echo "<br/>";
echo "<br/>";
echo "<br/>";


/*
$res_distr=sql($BD4,"SELECT n_ref, count( n_ref ), agrup FROM `final`  WHERE tipo='e' and ano='$ANO_REF'  GROUP BY agrup, n_ref");

echo "<br>";
echo "<center>";
echo "<H3>Q U A D R O &nbsp;&nbsp;D E&nbsp;&nbsp;D I S T R I B U I Ç Ã O &nbsp;&nbsp; D E &nbsp;&nbsp; R E F E R Ê N C I A S&nbsp;&nbsp; D A&nbsp;&nbsp; U N I D A D E</H3>";
echo "</center>";
echo "<center>";
echo "<table class=\"table table-bordered\">";
echo "<tr>";
echo "<td align=\"center\">\n";
echo "Agrupamento";
echo "</td>";
echo "<td align=\"center\">\n";
echo "Numero de referencias";
echo "</td>";
echo "<td align=\"center\">\n";
echo "Empregados contemplados";
echo "</td>";
echo "</tr>";
while ($lis_dist=mysql_fetch_row($res_distr))
   {
     echo "<tr>\n";
     echo "<td>\n";
     echo $lis_dist[2];
     echo "</td>\n";
     echo "<td>\n";
     echo $lis_dist[0];
     echo "</td>\n";
     echo "<td>\n";
     echo $lis_dist[1];
     echo "</td>\n";
     echo "</tr>\n";
   }
echo "</table>";
echo "</center>";
echo "</br>";
echo "</br>";

/*

?>
