<?php

$ret=$_GET["valor"];
$valor=explode(":::",$ret);

include('./fpdf/fpdf.php');

class PDF extends FPDF
{
}

//Instanciation of inherited class
$pdf=new PDF();
$pdf->SetLeftMargin(20);
$pdf->AliasNbPages();

$Data = date("Y-m-d");
$Data = substr($Data,8,2)."/".substr($Data,5,2)."/".substr($Data,0,4);
$matr1_largura=array(30,20,25,35,35,32);
$matr2_largura=array(45,44,44,44);
 
// --- imprime pdf ---

// Cabecalhp
    $pdf->AddPage();
    $pdf->Ln(5);

  //Logo (distancia da margem esquerda, distancia da margem superior, tamanho)
    $pdf->Image('./icons/embrapa.gif',85,20,0);

    $pdf->Ln(25);
    $pdf->SetFont('Arial','BI',12);
    $pdf->Cell(120,12,'TITULO:Avaliacao de Desempenho Individual','TLRB',0,'C');  // (largura, altura, texto, borda, posicao do cursor, alinhamento)
    $pdf->Cell(5,12,'','0',0,'C');  // (largura, altura, texto, borda, posicao do cursor, alinhamento)
    $pdf->Cell(52,12,'037.009.003.001','TLRB',0,'C');  // (largura, altura, texto, borda, posicao do cursor, alinhamento)


    $pdf->Ln(15);
    $pdf->SetFont('Arial','BI',14);
    $pdf->Cell(170,20,'ANEXO C','',1,'C');  // (largura, altura, texto, borda, posicao do cursor, alinhamento)


    $pdf->Ln(5);
    $pdf->SetFont('Arial','BI',10);
    $pdf->Cell(89,5,'Empregado:'.$valor[0],'TRBL',0,'L');  // (largura, altura, texto, borda, posicao do cursor, alinhamento)
    $pdf->Cell(88,5,$valor[1],'TRBL',0,'L');  // (largura, altura, texto, borda, posicao do cursor, alinhamento)

    $pdf->Ln(5);
    $pdf->SetFont('Arial','BI',10);
    $pdf->Cell(89,5,'Unidade:CNPMA','TRBL',0,'L');  // (largura, altura, texto, borda, posicao do cursor, alinhamento)
    $pdf->Cell(88,5,'Avaliador:'.$valor[2],'TRBL',0,'L');  // (largura, altura, texto, borda, posicao do cursor, alinhamento)

 $linhas=6;
 $ln=40;
 $i=4;
   $pdf->SetFont('Arial','BI',5);
   for ($z=0;$z<=$linhas;$z++)
	{
   		$pdf->SetXY(10,60);
    		$pdf->Ln($ln);
		for ($j=0;$j<=5; $j++)
			{
    				$pdf->Cell($matr1_largura[$j],5,$valor[$i],'BTLR',0,'C',0);  // (largura, altura, texto, borda, posicao do cursor, alinhamento)
				$i++;
			}
		$ln=$ln+5;
	}


 $linhas=3;
 $ln=85;
   for ($z=0;$z<=$linhas;$z++)
	{
   		$pdf->SetXY(30,60);
    		$pdf->Ln($ln);
		for ($j=0;$j<=3; $j++)
			{
    				$pdf->SetFont('Arial','BI',5);
    				$pdf->Cell($matr2_largura[$j],5,$valor[$i],'BTLR',0,'C');  // (largura, altura, texto, borda, posicao do cursor, alinhamento)
				$i++;
			}
		$ln=$ln+5;
	}
    $pdf->Ln(5);
    $pdf->SetFont('Arial','BI',8);
    $pdf->Cell(133,5,'NFI - Nota final dos Indicadores','BRL',0,'R');  // (largura, altura, texto, borda, posicao do cursor, alinhamento)
    $pdf->SetFont('Arial','BI',9);
    $pdf->Cell(44,5,$valor[3],'BRL',0,'C');  // (largura, altura, texto, borda, posicao do cursor, alinhamento)


    $pdf->Ln(75);
    $pdf->SetFont('Arial','B',10);
    $pdf->Cell(89,5,'Jaguariuna-SP: '.$Data,'',0,'C');  // (largura, altura, texto, borda, posicao do cursor, alinhamento)
    $pdf->Cell(88,5,' ','',1,'C');  // (largura, altura, texto, borda, posicao do cursor, alinhamento)
    $pdf->Cell(88,5,' ','',1,'C');  // (largura, altura, texto, borda, posicao do cursor, alinhamento)
    $pdf->Cell(88,5,' ','',1,'C');  // (largura, altura, texto, borda, posicao do cursor, alinhamento)
    $pdf->Cell(89,5,'____________________________________','',0,'C');  // (largura, altura, texto, borda, posicao do cursor, alinhamento)       
    $pdf->Cell(88,5,'____________________________________','',1,'C');  // (largura, altura, texto, borda, posicao do cursor, alinhamento)      
    $pdf->SetFont('Arial','',9);
    $pdf->Cell(89,5,$valor[0],'',0,'C');  // (largura, altura, texto, borda, posicao do cursor, alinhamento)     
    $pdf->Cell(88,5,$valor[2],'',1,'C');  // (largura, altura, texto, bord a, posicao do cursor, alinhamento) 

$pdf->Output();


?>
