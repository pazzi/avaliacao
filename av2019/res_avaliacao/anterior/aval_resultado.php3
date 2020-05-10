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
    echo "<a href=./index.php3>User-id ou Senha inv\xe1lidos - entre novamente</a>";
    exit();
   }

##Obtem dados de quem logou - matricula a ser avaliada (matr_da)
$sql_matr=sql($BD1,"select matr,nome,local from empregados where email='$user'");
$matr_ret=mysql_result($sql_matr,0,"matr");
$nome=mysql_result($sql_matr,0,"nome");
$local_ret=mysql_result($sql_matr,0,"local");
$sql_elegiveis=sql($BD4,"select * from elegiveis where matr='$matr_ret' and ano='$ANO_REF'");
$agrupamento=mysql_result($sql_elegiveis,0,"cod_agrupamento");
$supervisor=mysql_result($sql_elegiveis,0,"supervisor");
$setor=mysql_result($sql_elegiveis,0,"cod_setor");

$sql_id="SELECT codigo_pesquisa FROM Pesquisa_Opiniao WHERE ano_pesq='$ANO_REF' AND matricula='$matr_ret' AND codigo_aval='2'";
$res_sql_id=sql($BD4,$sql_id);
$codigo=mysql_result($res_sql_id,0,"codigo_pesquisa");



cabecalho();

/*
echo "<br>";
echo "<center>";
echo "<a href=\"index.php3\">Voltar</a>";
echo "</center>";
echo "<br>";
echo "<br>";
echo "<center><font class=\"title\">$matr_ret - $nome</font></center>";
echo "<br>";
echo "<br>";
echo "<center><font class=\"title\"><u>A v a l i a c a o  - $ANO_AVAL - A n o &nbsp;&nbsp; B a s e  - $ANO_REF</u></font></center>";
echo "<br>";
echo "<br>";


$sql_id="SELECT codigo_pesquisa FROM Pesquisa_Opiniao WHERE ano_pesq='$ANO_REF' AND matricula='$matr_ret' AND codigo_aval='1'";
echo $sql_id;

$res_sql_id=sql($BD4,$sql_id);
$codigo=mysql_result($res_sql_id,0,"codigo_pesquisa");

 $ret_func= busca_medias_competencia(1,$matr_ret,$ANO_REF);

 ##$ret_func= busca_medias_competencia_por_codigo($codigo);
 $return=sql($BD4, $ret_func);
 $contador=0;
 $soma_nota=0;
 while ($lista=mysql_fetch_row($return))
         {
          $contador++;
          $soma_nota=$soma_nota+$lista[1];
         }
 $media_sup=$soma_nota/$contador;



#Calculo das nota dos clientes e do ecom
$ret_func= busca_notas_por_formulario(3,$matr_ret,$ANO_REF,$lista0[0]);
$return=sql($BD4, $ret_func);
$soma=0;
$media=0;
$notas="";
$notas_ar=array();
$id_ar=array();
while ($lista=mysql_fetch_row($return))
         {
               $notas_ar[]= $lista[1];
               $id_ar[]= $lista[0];
         }
sort($notas_ar);
$conta_ind= count($notas_ar);
for ( $indice = 1 ; $indice <= $conta_ind - 2 ; $indice++ )
           {
              $soma=$soma+$notas_ar[$indice];
            }
$media_cli=$soma/($indice-1);
$nota_ecom1=(($media_sup * 3)/5) + (($media_cli * 2)/5);
#$nota_ecom=($nota_ecom1 -1)/3;
$nota_ecom=($nota_ecom1)/4;

echo "<table class=\"table\">\n";
echo "<tr>\n";
echo "<td>\n";
 echo "Media do Supervisor:";
echo "</td>\n";
echo "<td>\n";
 echo $media_sup;
echo "</td>\n";
echo "</tr>\n";
echo "<tr>\n";
echo "<td>\n";
echo "Media Clientes final";
echo "</td>\n";
echo "<td>\n";

echo $media_cli;
echo " &nbsp;&nbsp;- &nbsp;&nbsp;&nbsp;Utilizando-se as seguintes medias de clientes ->";
for ( $indice = 1 ; $indice <= $conta_ind - 2 ; $indice++ )
           {
              echo $notas_ar[$indice];
              echo "[Avaliador:";
              echo $id_ar[$indice];
              echo "]";
              echo "&nbsp;&nbsp; ";

            }
echo "<br>";
echo "Medias de clientes desprezadas ->";
echo $notas_ar[0];
echo "[Avaliador:";
echo $id_ar[0];
echo "]";
echo "&nbsp;&nbsp; ";
echo $notas_ar[$conta_ind-1];
echo "[Avaliador:";
echo $id_ar[$conta_ind-1];
echo "]";

echo "</td>\n";
echo "<tr>\n";
echo "<td>\n";
echo "Media Avaliacao";
echo "</td>\n";
echo "<td>\n";
echo $nota_ecom1;
echo "</td>\n";
echo "</tr>\n";
echo "</table>\n";

echo $nota_ecom;
*/

echo "<br>\n";
echo "<br>\n";
echo "<br>\n";
echo "<div class=\"row\">";
	echo "<div class=\"col-md-8\">";
	echo "<div class=\"well\">";
	echo "<h4>TITULO:Avaliacao de Desempenho Individual</h4>";
	echo "</div>";
	echo "</div>";
	echo "<div class=\"col-md-4\">";
	echo "<div class=\"well\">";
	echo "<h4>037.009.003.001</h4>";
	echo "</div>";
	echo "</div>";
echo "</div>";

echo "<center>\n";
echo "<h3>Anexo C</h3>";
echo "</center>\n";
echo "<br>\n";
echo "<br>\n";
$nome_agrupamento=nome_agrupamento($agrupamento);
echo "<div class=\"row\">";
	echo "<div class=\"col-md-8\">";
	echo "<div class=\"well\">";
	echo "<h4>$nome</h4>";
	echo "</div>";
	echo "</div>";
	echo "<div class=\"col-md-4\">";
	echo "<div class=\"well\">";
	echo "<h4>$nome_agrupamento</h4>";
	echo "</div>";
	echo "</div>";
echo "</div>";

echo "<div class=\"row\">";
	echo "<div class=\"col-md-8\">";
	echo "<div class=\"well\">";
	echo "<h4>$LOTACAO</h4>";
	echo "</div>";
	echo "</div>";
	echo "<div class=\"col-md-4\">";
	echo "<div class=\"well\">";
	echo "<h4>".lista_nome($supervisor)."</h4>";
	echo "</div>";
	echo "</div>";
echo "</div>";

$matriz=array();

$matriz[0][0]="AVALIADORES/INDICADORES";
$matriz[1][0]="Superior Imediato";
$matriz[2][0]="Pares(media ponderada)";
$matriz[3][0]="Indicadores de Producao(pesquisa)";
$matriz[4][0]="Indicadores de Engajamento(pesquisa)";
$matriz[5][0]="Valor ponderado por fontes";
$matriz[0][1]="Competencias Comportamentais";
$matriz[0][2]="Peso da Fonte";
$matriz[0][3]="Contribuicao Tecnica";
$matriz[0][4]="Peso da Fonte";
$matriz[0][5]="Engajamento com o Trabalho";
$matriz[0][6]="Peso da Fonte";
$matriz[5][1]=(($matriz[1][1]*$matriz[1][2])/100);

$matriz2=array();
$matriz2[0][0]="Indicadores";
$matriz2[1][0]="Peso dos Indicadores";
$matriz2[2][0]="Valor Ponderado por fontes (acima)";
$matriz2[3][0]="Nota do Indicador";
$matriz2[0][1]="Competencias Comportamentais";
$matriz2[0][2]="Engajamento com o Trabalho";
$matriz2[0][3]="Contribuicao Tecnica";

$ret_peso_indicador_sql ="select distinct(z_indicador.cod_indicador), z_indicador.peso from z_indicador, z_itens where z_indicador.id=z_itens.id_indicador AND z_indicador.cod_agrupamento='$agrupamento'";

$ret_peso_indicador=sql($BD4,$ret_peso_indicador_sql);

while ($list_peso_indicador = mysql_fetch_row($ret_peso_indicador))
{
	switch ($list_peso_indicador[0])
		{	
			case 1:
				$matriz2[1][1]=$list_peso_indicador[1];
				break;
			case 3:
				$matriz2[1][2]=$list_peso_indicador[1];
				break;
			case 2:
				$matriz2[1][3]=$list_peso_indicador[1];
				break;
		}
}
	


$ret_peso_fontes_sql="select * from z_indicador, z_itens where z_indicador.id=z_itens.id_indicador AND z_indicador.cod_agrupamento='$agrupamento'";
$ret_peso_fontes=sql($BD4,$ret_peso_fontes_sql);

while ($list_peso_fontes = mysql_fetch_row($ret_peso_fontes))
{
	switch ($list_peso_fontes[6])
		{	
			case 1:
				$matriz[1][2]=$list_peso_fontes[7];
				break;
			case 2:
				$matriz[2][2]=$list_peso_fontes[7];
				break;
			case 3:
				$matriz[1][4]=$list_peso_fontes[7];
				break;
			case 4:
				$matriz[1][6]=$list_peso_fontes[7];
				break;
			case 6:
				$matriz[3][4]=$list_peso_fontes[7];
				break;
			case 7:
				$matriz[4][6]=$list_peso_fontes[7];
				break;
		}
}



 $ret_func= busca_medias_competencia(1,$matr_ret,$ANO_REF);
 $return=sql($BD4, $ret_func);
 $contador=0;
 $soma_nota=0;
 while ($lista=mysql_fetch_row($return))
         {
          if (($lista[0] <> 4) and ($lista[0] <> 5) and ($lista[0] <> 6) and ($lista[0] <> 7) and ($lista[0] <> 8))
		{
          		$contador++;
          		$soma_nota=$soma_nota+$lista[1];
		}
			else
				{
					$memorial[$lista[0]][$lista[1]];
					switch ($lista[0])
							{
								case 4:
									$matriz[1][5]=$lista[1];
									break;
								case 5:
									$matriz[1][3]=$lista[1];
									break;
								case 6: 
									$matriz[1][5]=$lista[1];
									break;
								case 7: 
									$matriz[3][3]=$lista[1];
									break;
								case 8: 
									$matriz[4][5]=$lista[1];
									break;
							}
				
				}
         }
$media_sup=$soma_nota/$contador;
$matriz[1][1]=$media_sup;



#Calculo das nota dos clientes 
$ret_func= busca_notas_por_formulario(3,$matr_ret,$ANO_REF,$lista0[0]);
$return=sql($BD4, $ret_func);
$soma=0;
$media=0;
$notas="";
$notas_ar=array();
$id_ar=array();
while ($lista=mysql_fetch_row($return))
         {
               $notas_ar[]= $lista[1];
               $id_ar[]= $lista[0];
         }
$conta_ind= count($notas_ar);
for ( $indice = 0 ; $indice <= $conta_ind - 1 ; $indice++ )
           {
              $soma=$soma+$notas_ar[$indice];
            }
$media_cli=$soma/($conta_ind);

$matriz[2][1]=$media_cli;


#Valor ponderado Compet Comportamentais de todos e Indicadores Prod e Engajamento da pesquisa
$matriz[5][1]=(($matriz[1][1]*$matriz[1][2])+($matriz[2][1]*$matriz[2][2])+($matriz[3][1]*$matriz[3][2])+($matriz[4][1]*$matriz[4][2]))/100;
$matriz2[2][1]=$matriz[5][1];

#Valor ponderado da Contr Tecnica
$matriz[5][3]=(($matriz[1][3]*$matriz[1][4])+($matriz[2][3]*$matriz[2][4])+($matriz[3][3]*$matriz[3][4])+($matriz[4][3]*$matriz[4][4]))/100;
$matriz2[2][3]=$matriz[5][3];

#Valor ponderado do Engajamento
$matriz[5][5]=(($matriz[1][5]*$matriz[1][6])+($matriz[2][5]*$matriz[2][6])+($matriz[3][5]*$matriz[3][6])+($matriz[4][5]*$matriz[4][6]))/100;
$matriz2[2][2]=$matriz[5][5];

$matriz2[3][1]=$matriz2[1][1]*$matriz2[2][1]/100;
$matriz2[3][2]=$matriz2[1][2]*$matriz2[2][2]/100;
$matriz2[3][3]=$matriz2[1][3]*$matriz2[2][3]/100;

$nfi=$matriz2[3][1]+$matriz2[3][2]+$matriz2[3][3];


echo "<table class=\"table table-striped\">";
echo "<thead>";
echo "<tr>";
	for ($c=0; $c<=5; $c++)
		{	
			echo "<th>";
			echo $matriz[$c][0];
			echo "</th>";
		}
echo "</tr>";

echo "</thead>";
echo "<tbody>";
	for ($l=1; $l<=6; $l++)
		{
			echo "<tr>";
			for ($c=0; $c<=5; $c++)
				{
					if ($c==0)
						{
							echo "<td>";
						}
						else	{

								echo "<td align=\"center\">";
							}
					#if ((($matriz[$c][$l]=="") or ($matriz[$c][$l]==0)) and ($c>0))
#echo $c;
#echo "###";
#echo $l;

					if (($matriz[$c][$l]=="")  and ($c>0))
						{
							$matriz[$c][$l]="***";
						}
						
					if ( ($c<>0) AND (($l%2)==0) AND ($matriz[$c][$l] <> "***") )
						{
						#	echo $matriz[$c][$l]. "%" . "---".$c . "-". $l;
							echo $matriz[$c][$l]. "%";
						} else{
								echo $matriz[$c][$l];
							}
					
						

					echo "</td>";	
				}
			echo "</tr>";
		} 
echo "</tbody>";

echo "</table>";

$tem_memorial= busca_memorial($codigo);

if ($tem_memorial == 0)
	{

		echo "**Obs: Memorial Tecnico ou Relato do Empregado nao preenchido";
	}

echo "<br>";
echo "<br>";

echo "<table class=\"table table-striped\">";
echo "<thead class=\"thead-inverse\">";
echo "<tr>";
	for ($c=0; $c<=3; $c++)
		{	
			echo "<th>";
			echo $matriz2[$c][0];
			echo "</th>";
		}
echo "</tr>";

echo "</thead>";
echo "<tbody>";
	for ($l=1; $l<=4; $l++)
		{
			echo "<tr>";
			for ($c=0; $c<=3; $c++)
				{
					echo "<td>";
					if ($c==1)
						{
							echo $matriz2[$c][$l]."%";
						}else	{
								echo $matriz2[$c][$l];
							}
					echo "</td>";	
				}
			echo "</tr>";
		} 
echo "</tbody>";

echo "</table>";


echo "<div class=\"row\">";
echo "<div class=\"col-md-10\">";
echo "<div class=\"well\">";
echo "<h4>NFI -  Nota final dos Indicadores</h4>";
echo "</div>";
echo "</div>";
echo "<div class=\"col-md-2\">";
echo "<div class=\"well\">";
echo "<h4>$nfi</h4>";
echo "</div>";
echo "</div>";
echo "</div>";

echo "<br>";
echo "<br>";
echo "<br>";
echo "<div class=\"row\">";
echo "<div class=\"col-md-12\">";
echo "<div class=\"well\">";
echo "$CIDADE";
echo ",&nbsp;&nbsp;";
echo date(d);
echo "/";
echo date(m);
echo "/";
echo date(Y);
echo "</div>";
echo "</div>";
echo "</div>";
echo "<br>\n";

echo "<div class=\"row\">";
echo "<div class=\"col-md-6\">";
echo "<div class=\"well\">";
echo "______________________________________________";
echo "</div>";
echo "</div>";
echo "<div class=\"col-md-6\">";
echo "<div class=\"well\">";
echo "______________________________________________";
echo "</div>";
echo "</div>";
echo "</div>";

echo "<div class=\"row\">";
echo "<div class=\"col-md-6\">";
echo "<div class=\"well\">";
echo $nome;
echo "</div>";
echo "</div>";
echo "<div class=\"col-md-6\">";
echo "<div class=\"well\">";
echo "Superior Imediato";
echo "</div>";
echo "</div>";
echo "</div>";

#Agrupamentos que terao avaliacao de competencia do supervisor
$agrup_sup=array(1,2,3,4,5,6,7,8,9,11,12,13,14,17,18,19,20);
#Agrupamentos que terao avaliacao de pares-360 no setor 
$agrup_sup_360=array(1,3,4,5,6,7,8,9,13,14,17,18,19,20);

if (in_array($agrupamento, $agrup_sup))
{  
	echo "<br>\n";
	echo "<br>\n";
	echo "<br>\n";
	echo "<br>\n";
	echo "<br>\n";
	echo "<br>\n";
	echo "<br>\n";
	echo "<br>\n";
	echo "<br>\n";
	echo "<br>\n";
	echo "<br>\n";
	echo "<br>\n";
	echo "<br>\n";
	echo "<br>\n";
	echo "<br>\n";
	echo "<h2>Detalhamentos</h2>";
	echo "<br>\n";
	echo "<br>\n";



	echo "<br>";
	echo "<br>";
	echo "<table><tr><td valign=\"top\">\n";
	echo "<table border=\"0\" valign=\"top\" cellpadding=1>";
	echo "<tr><td align=\"center\" colspan=2> A v a l i a c a o &nbsp; d o &nbsp;&nbsp; S u p e r v i s o r</td></tr>";
	echo "<tr><td align=\"center\" colspan=2> (Notas em cada item de competencia)</td></tr>";
	echo "<tr><td align=\"center\">Competencia</td><td>Item</td><td>Valor</td><td>Escala</td></tr>";

	 $ret_func= busca_medias(1,$matr_ret,$ANO_REF);
	 ##$ret_func= busca_media_por_codigo($codigo);
	 $return=sql($BD4, $ret_func);
	 $contador=0;
	 $soma_nota=0;
	 while ($lista=mysql_fetch_row($return))
		 {
		  echo "<tr";
		    if (bcmod($contador,2)==0)
			{
			  echo " bgcolor=\"#99ffff\" >\n";
			}
                 else
                     {
                      echo " bgcolor=\"#ffffff\" >\n";
                     }
          echo "<td align=\"center\">\n";
          echo $lista[2];
          echo "</td>\n";
          echo "<td>\n";
          $msg=retorna_texto($lista[0]);
          echo $msg;
          echo "</td>";
          echo "<td>";
          echo $lista[1];
          echo "</td>\n";
          echo "<td>";
          echo ver_escala($lista[1]);
          echo "</td>\n";
          echo "</tr>\n";
         $contador++;
        $soma_nota=$soma_nota+$lista[1];
         }
	echo "</table>";

	echo "</td>";
	echo "<td valign=\"top\">";



	 $ret_func= busca_medias_competencia(1,$matr_ret,$ANO_REF);
	 $return=sql($BD4, $ret_func);
	 

	echo "<table border=\"0\" valign=\"top\" cellpadding=1>";
	 echo "<tr><td align=\"center\" colspan=2>S U P E R V I S O R</td></tr>";
	 $contador=0;
	 $soma_nota=0;
	 while ($lista=mysql_fetch_row($return))
		 {
		  echo "<tr";
		    if (bcmod($contador,2)==0)
			{
                  echo " bgcolor=\"#ffff66\" >\n";
                }
                 else
                     {
                      echo " bgcolor=\"#ffffff\" >\n";
                     }
          echo "<td>\n";
          $msg=retorna_texto_competencia($lista[0]);
          echo $msg;
          echo "</td>";
          echo "<td>";
          echo $lista[1];
          echo "</td>\n";
          echo "</tr>\n";
          if (($lista[0] <> 4) and ($lista[0] <> 5) and ($lista[0] <> 6))
		{
          		$contador++;
          		$soma_nota=$soma_nota+$lista[1];
		}
			else
				{
					$memorial[$lista[0]][$lista[1]];
					switch ($lista[0])
							{
								case 4:
									$matriz[1][5]=$lista[1];
									break;
								case 5:
									$matriz[1][3]=$lista[1];
									break;
								case 6: 
									$matriz[1][5]=$lista[1];
									break;
							}
				
				}
         }
	$media_sup=$soma_nota/$contador;
	$matriz[1][1]=$media_sup;
	echo "<tr><td>Media</td><td bgcolor=\"#ffff00\">$media_sup</td></tr>";
	echo "</table>";
	echo "</td>\n";
	echo "</tr>\n";
	echo "</table>\n";
}

echo "<br>";
echo "<br>";
echo "<br>";


if (in_array($agrupamento, $agrup_sup_360))
{

	echo "<table><tr><td valign=\"top\">\n";
	echo "<table border=\"0\" valign=\"top\" cellpadding=1>";
	echo "<tr><td align=\"center\" colspan=2> A v a l i a c a o &nbsp; d e &nbsp;&nbsp; C l i e n t e s</td></tr>";
	echo "<tr><td align=\"center\" colspan=2> (Notas em cada item de competencia)</td></tr>";
	echo "<tr><td align=\"center\">Competencia</td><td>Item</td><td>Valor</td></tr>";
	 $ret_func= busca_medias(3,$matr_ret,$ANO_REF);
	 $return=sql($BD4, $ret_func);
	 $contador=0;
	 $soma_nota=0;

	 $compet1=0;
	 $compet2=0;
	 $compet3=0;
	 $cont1=0;
	 $cont2=0;
	 $cont3=0;

	 while ($lista=mysql_fetch_row($return))
		 {
		  $texto_competencia=$lista[0];
		  $valor_compet=$lista[1];
		  $num_compet=$lista[2];
		  echo "<tr";
		    if (bcmod($contador,2)==0)
			{
			  echo " bgcolor=\"#99ffff\" >\n";
			}
			 else
			     {
			      echo " bgcolor=\"#ffffff\" >\n";
			     }
		  echo "<td align=\"center\">\n";
		  echo $num_compet;
		  echo "</td>\n";
		  echo "<td>\n";
		  echo retorna_texto($texto_competencia);
		  echo "</td>\n";
		  echo "<td>\n";
		  echo $valor_compet;
		  echo "</td>\n";

		  echo "</tr>\n";

		  switch ($num_compet)
			{
			  case 1:
				 $cont1++;
				 $compet1=$compet1 + $valor_compet;
				 break;
			  case 2:
				 $cont2++;
				 $compet2=$compet2 + $valor_compet;
				 break;
			  case 3:
				 $cont3++;
				 $compet3=$compet3 + $valor_compet;
				 break;
			}

		  $contador++;
          $soma_nota=$soma_nota+$lista[1];
         }
     
	echo "</table>";
	echo "</td>";
	echo "<td valign=\"top\">";


	echo "<table border=\"0\" valign=\"top\" cellpadding=1>";
	echo "<tr><td align=\"center\" colspan=2> A v a l i a c a o &nbsp; d e &nbsp;&nbsp; C l i e n t  e s</td></tr>";
	echo "<tr><td align=\"center\" colspan=2>Medias por competencia</td></tr>";

	$soma_media_pares=0;
	$conta_medias_pares=0;

	echo "<tr bgcolor=\"#ffff66\" >\n";
	echo "<td>\n";
	$msg=retorna_texto_competencia(1);
	echo $msg;
	echo "</td>";

	if ($cont1>0)
	  {
	   echo "<td>";
	   $conta_medias_pares++;
	   $med_competencia_par=$compet1/$cont1;
	   echo $med_competencia_par;
	   $soma_media_pares=$soma_media_pares+$med_competencia_par;
	   echo "</td>\n";
	   echo "</tr>\n";
	 }
	  else
	      {
	       echo "<td>";
	       echo "----";
	       echo "</td>\n";
	       echo "</tr>\n";
	     }


	echo "<tr bgcolor=\"#ffffff\" >\n";
	echo "<td>\n";
	$msg=retorna_texto_competencia(2);
	echo $msg;
	echo "</td>";

	if ($cont2>0)
	  {
	   echo "<td>";
	   $conta_medias_pares++;
	   $med_competencia_par=$compet2/$cont2;
	   echo $med_competencia_par;
	   $soma_media_pares=$soma_media_pares+$med_competencia_par;
	   echo "</td>\n";
	   echo "</tr>\n";
	 }
	  else
	      {
	       echo "<td>";
	       echo "----";
	       echo "</td>\n";
	       echo "</tr>\n";
	     }


	echo "<tr bgcolor=\"#ffff66\" >\n";
	echo "<td>\n";
	$msg=retorna_texto_competencia(3);
	echo $msg;
	echo "</td>";

	if ($cont3>0)
	  {
	   echo "<td>";
	   $conta_medias_pares++;
	   $med_competencia_par=$compet3/$cont3;
	   echo $med_competencia_par;
	   $soma_media_pares=$soma_media_pares+$med_competencia_par;
	   echo "</td>\n";
	   echo "</tr>\n";
	 }
	  else
	      {
	       echo "<td>";
	       echo "----";
	       echo "</td>\n";
	       echo "</tr>\n";
	     }


	echo "<tr bgcolor=\"#ffffff\" >\n";
	echo "<td>\n";
	$msg=retorna_texto_competencia(4);
	echo $msg;
	echo "</td>";

	echo "<tr bgcolor=\"#ffffff\" >\n";
	echo "<td>\n";
	echo "Media pares";
	echo "</td>";
	echo "<td>";
	#$media_pares= $soma_media_pares/$conta_medias_pares;
	#echo $media_pares;
	echo $media_cli;
	echo "</td>\n";
	echo "</tr>\n";
	echo "</table>\n";

	echo "</td>";
	echo "</tr>";
	echo "</table>";




	echo "<br>";
	echo "<br>";
	echo "<font class=\"title\">Detalhe das avaliacoes de clientes</title>";
	echo "<br>";
	echo "Id do par representa um par";
	echo "<br>";
	echo "<br>";
	$ret_func= busca_pares(3,$matr_ret,$ANO_REF);
	$return=sql($BD4, $ret_func);
	echo "<table>";
	echo "<tr bgcolor=\"#FFCC99\">";
	echo "<td align=\"center\">";
	echo "Id do Par";
	echo "</td>";
	echo "<td align=\"center\">";
	echo "Competencia";
	echo "</td>";
	echo "<td align=\"center\">";
	echo "Item";
	echo "</td>";
	echo "<td align=\"center\">";
	echo "Valor";
	echo "</td>";
	echo "<td align=\"center\">";
	echo "Escala";
	echo "</td>";
	echo "</tr>";
	$i=1;
	while($lista=mysql_fetch_row($return))
	      {
		   if ($lista[3]==$num_par)
		   {
		    echo "<tr";
		    if (bcmod($i,2)==0)
			{
			  echo " bgcolor=\"#66ccff\" >\n";
			}
			 else
			     {
			      echo " bgcolor=\"#ffffff\" >\n";
			     }
           echo "<td>";
           echo $lista[3];
           echo "</td>";
           echo "<td>";
           echo $lista[2];
           echo "</td>";
           echo "<td>";
           #echo $lista[0];
           echo retorna_texto($lista[0]);
           echo "</td>";
           echo "<td>";
           echo $lista[1];
           echo "</td>";
           echo "<td>";
           echo ver_escala($lista[1]);
           echo "</td>";
           echo "</tr>";
           $num_par=$lista[3];
           }
            else
                {
                 echo "<tr>";
                 echo "<td colspan=4>";
                 echo "<hr>";
                 echo "</td>";
                 echo "</tr>";
                 echo "<tr";
           #           if (bcmod($lista[0],2)==0)
                      if (bcmod($i,2)==0)
                        {
                           echo " bgcolor=\"#66CCFF\" >\n";
                        }
                           else
                                {
                                 echo " bgcolor=\"#ffffff\" >\n";
                                }
                  echo "<td>";
                  echo $lista[3];
                  echo "</td>";
                  echo "<td>";
                  echo $lista[2];
                  echo "</td>";
                  echo "<td>";
                  echo retorna_texto($lista[0]);
                  echo "</td>";
                  echo "<td>";
                  echo $lista[1];
                  echo "</td>";
                  echo "<td>";
                  echo ver_escala($lista[1]);
                  echo "</td>";
                  echo "</tr>";
                  $num_par=$lista[3];
			}
	       $i++;
	      }
	echo "</table>";
}




$md_sup=0;
$md_par=0;
$md_aut=0;
if ($media_sup>0)
    {
      $md_sup=1;
    }
if ($media_pares>0)
    {
      $md_par=1;
    }
if ($media_auto>0)
    {
      $md_aut=1;
    }
$md_total=$md_sup.$md_par.$md_aut;



echo "<center>";
 echo "<a href=\"cnpma.comitegestorsaad@embrapa.br\" class=\"link\" title=\"comissao de progressao salarial\">Contate a comissao por e-mail</a>";
echo "</center>";



rodape();
?>
