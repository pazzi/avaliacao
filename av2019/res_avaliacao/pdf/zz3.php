<?php
include("../func_estagio.php3");
require('./fpdf/fpdf.php');

class PDF extends FPDF
{
var $B;
var $I;
var $U;
var $HREF;


function Header()
{
    $this->Ln(40);
}


function Footer()
{
    // Go to 1.5 cm from bottom
    //$this->SetY(-160);
    //$this->Ln(80);
     // $this->SetAutoPageBreak(0,30);
     // $this->Rect(0, 20, 200, 4 ,F);

}

function PDF($orientation='P', $unit='mm', $size='A4')
{
    // Call parent constructor
    $this->FPDF($orientation,$unit,$size);
    // Initialization
    $this->B = 0;
    $this->I = 0;
    $this->U = 0;
    $this->HREF = '';
}

function WriteHTML($html)
{
    // HTML parser
    $html = str_replace("\n",' ',$html);
    $a = preg_split('/<(.*)>/U',$html,-1,PREG_SPLIT_DELIM_CAPTURE);
    foreach($a as $i=>$e)
    {
        if($i%2==0)
        {
            // Text
            if($this->HREF)
                $this->PutLink($this->HREF,$e);
            else
                $this->Write(5,$e);
        }
        else
        {
            // Tag
            if($e[0]=='/')
                $this->CloseTag(strtoupper(substr($e,1)));
            else
            {
                // Extract attributes
                $a2 = explode(' ',$e);
                $tag = strtoupper(array_shift($a2));
                $attr = array();
                foreach($a2 as $v)
                {
                    if(preg_match('/([^=]*)=["\']?([^"\']*)/',$v,$a3))
                        $attr[strtoupper($a3[1])] = $a3[2];
                }
                $this->OpenTag($tag,$attr);
            }
        }
    }
}

function OpenTag($tag, $attr)
{
    // Opening tag
    if($tag=='B' || $tag=='I' || $tag=='U')
        $this->SetStyle($tag,true);
    if($tag=='A')
        $this->HREF = $attr['HREF'];
    if($tag=='BR')
        $this->Ln(5);
}

function CloseTag($tag)
{
    // Closing tag
    if($tag=='B' || $tag=='I' || $tag=='U')
        $this->SetStyle($tag,false);
    if($tag=='A')
        $this->HREF = '';
}

function SetStyle($tag, $enable)
{
    // Modify style and select corresponding font
    $this->$tag += ($enable ? 1 : -1);
    $style = '';
    foreach(array('B', 'I', 'U') as $s)
    {
        if($this->$s>0)
            $style .= $s;
    }
    $this->SetFont('',$style);
}

function PutLink($URL, $txt)
{
    // Put a hyperlink
    $this->SetTextColor(0,0,255);
    $this->SetStyle('U',true);
    $this->Write(5,$txt,$URL);
    $this->SetStyle('U',false);
    $this->SetTextColor(0);
}
}


#include ("/usr/local/www/data/intranet/nosso_ambiente/functions.php3");
#include ("func_relat.php");
include ("relat1_parametros.php");
$estagio_id=$_POST["HILid"];
$ret_estagio=sql("intranet","select * from intranet.estag_cad, intranet.estag_estagio WHERE intranet.estag_cad.id=intranet.estag_estagio.id_estag_cad AND intranet.estag_estagio.id='$estagio_id'");

while($lis=mysql_fetch_row($ret_estagio))
{
$ESTAGIARIO_NOME=$lis[1];
$ESTAGIARIO_RG=$lis[2];
$ESTAGIARIO_CPF=$lis[3];
$ESTAGIARIO_DATA_NASCIMENTO=$lis[4];
$ESTAGIARIO_ENDERECO=utf8_encode($lis[5]);
$ESTAGIARIO_BAIRRO=utf8_encode($lis[6]);
$ESTAGIARIO_CIDADE=utf8_encode($lis[7]);
$ESTAGIARIO_UF=$lis[8];
$ESTAGIARIO_NACIONALIDADE=$lis[14];
$ESTAG_EST_CIV=$lis[15];
switch($ESTAG_EST_CIV)
     {
      case 0: $ESTAGIARIO_ESTADO_CIVIL="Solteiro(a)";
              break;
      case 1: $ESTAGIARIO_ESTADO_CIVIL="Casado(a)";
              break;
      case 2: $ESTAGIARIO_ESTADO_CIVIL="Separado(a)";
              break;
     }

$ESTAGIARIO_RG_ORG_EXP=$lis[16];
$ESTAGIARIO_RG_DATA_EXP=$lis[17];
$ESTAGIARIO_CURSO=$lis[31];
$ESTAGIARIO_CARGA_HORARIA_SEMANAL=$lis[32];
$ESTAGIARIO_ID_ORIENTADOR=$lis[29];
$ret_orientador=sql("cnpma","SELECT nome FROM empregados WHERE matr='$ESTAGIARIO_ID_ORIENTADOR'");
$ESTAGIARIO_ORIENTADOR=mysql_result($ret_orientador,0,0);
$ret_inst_ensino= sql($BD8,"select * from  t_inst_inter where t_inst_inter_id='$lis[30]' ;");
$INSTITUICAO_ENSINO= utf8_encode(mysql_result($ret_inst_ensino,0,1));
$INSTITUICAO_ENSINO_CIDADE= utf8_encode(mysql_result($ret_inst_ensino,0,2));
$INSTITUICAO_ENSINO_ENDERECO= utf8_encode(mysql_result($ret_inst_ensino,0,3));
$INSTITUICAO_ENSINO_UF= utf8_encode(mysql_result($ret_inst_ensino,0,6));
$INSTITUICAO_ENSINO_CGC= utf8_encode(mysql_result($ret_inst_ensino,0,9));
$ret_setor=sql("cnpma","select descricao FROM setores_novo WHERE codigo='$lis[28]'");
$SETOR_ATUACAO=utf8_encode(mysql_result($ret_setor,0,0));
$ESTAGIO_INICIO=$lis[20];
$ESTAGIO_FIM=$lis[21];
$res_periodo=sql("cnpma","SELECT PERIOD_DIFF($ESTAGIO_INICIO,$ESTAGIO_FIM)");
$ESTAGIO_PERIODO=mysql_result($res_periodo,0,0);
switch ($ESTAGIO_PERIODO)
   {
     case 6:$ESTAGIO_PERIODO_ESCRITO="seis";
            break;
     case 12:$ESTAGIO_PERIODO_ESCRITO="doze";
            break;
     case 18:$ESTAGIO_PERIODO_ESCRITO="dezoito";
            break;
     case 24:$ESTAGIO_PERIODO_ESCRITO="vinte e quatro";
            break;
     case 30:$ESTAGIO_PERIODO_ESCRITO="trinta";
            break;
     case 36:$ESTAGIO_PERIODO_ESCRITO="trinta e seis";
            break;
     case 42:$ESTAGIO_PERIODO_ESCRITO="quarenta e dois";
            break;
     case 48:$ESTAGIO_PERIODO_ESCRITO="quarenta e oito";
            break;
   }

}

switch ($TIhoras_diarias)
    {
      case 4:$HORAS_DIARIAS_ESCRITA="quatro";
             $HORAS_SEMANAIS =20;
             $HORAS_SEMANAIS_ESCRITA="vinte";
             break;
      case 6:$HORAS_DIARIAS_ESCRITA="seis";
             $HORAS_SEMANAIS =30;
             $HORAS_SEMANAIS_ESCRITA="trinta";
             break;
         
    }

$mes=array("nomemes","janeiro","fevereiro","março","abril","maio","junho","julho","agosto","setembro","outubro","novembro","dezembro");

$mes_texto=$mes[$_POST["mes"]];


$texto0="                   TERMO DE COMPROMISSO DE ESTÁGIO OBRIGATÓRIO";
$texto0 = utf8_decode($texto0);

$texto1="TERMO DE COMPROMISSO DE ESTÁGIO OBRIGATÓRIO, QUE ENTRE SI CELEBRAM A EMPRESA BRASILEIRA DE PESQUISA AGROPECUÁRIA - EMBRAPA E O ALUNO ".$ESTAGIARIO_NOME.", COM A INTERVENIÊNCIA DA INSTITUIÇÃO DE ENSINO ".$INSTITUICAO_ENSINO;
$texto1 = utf8_decode($texto1);



#$html = 'You can now easily print text mixing different styles: <b>bold</b>, <i>italic</i>,
#<u>underlined</u>, or <b><i><u>all at once</u></i></b>!<br><br>You can also insert links on
#text, such as <a href="http://www.fpdf.org">www.fpdf.org</a>, or on an image: click on the logo.';


$html="A <b><i>Empresa Brasileira de Pesquisa Agropecuária - Embrapa</i></b>, empresa pública federal, vinculada ao Ministerio da Agricultura, Pecuaria e Abastecimento, criada por forca da Lei número 5.851, de 07.12.72, com Estatuto Social aprovado pelo Decreto número 2.291, de 04.08.97, por intermedio de sua Unidade ". $UNIDADE_EMBRAPA.", inscrita no CNPJ/MF sob numero ".$EMBRAPA_CGC. ", sediada em ". $UNIDADE_CIDADE. ", na ".$UNIDADE_ENDERECO.", neste ato representada por seu Chefe Geral ".$NOME_CHEFE_CNPMA. ", doravante designada simplesmente Embrapa, e, de outro lado, o aluno ".$ESTAGIARIO_NOME. ", nacionalidade ".$ESTAGIARIO_NACIONALIDADE.", estado civil ".$ESTAGIARIO_ESTADO_CIVIL.", data de nascimento ". $ESTAGIARIO_DATA_NASCIMENTO.", portador do RG número ".$ESTAGIARIO_RG.", Orgao Expedidor:".$ESTAGIARIO_RG_ORG_EXP.", data de expedicao:".$ESTAGIARIO_RG_DATA_EXP.", inscrito no CPF/MF sob o número ".$ESTAGIARIO_CPF.", residente e domiciliado em (Cidade/Estado) ".$ESTAGIARIO_CIDADE." - ".$ESTAGIARIO_UF.", endereco ".$ESTAGIARIO_ENDERECO." - ".$ESTAGIARIO_BAIRRO.", doravante designado simplesmente Estudante, com a interveniencia da Instituicao de Ensino ". $INSTITUICAO_ENSINO.", inscrita no CNPJ/MF sob o número".$INSTITUICAO_ENSINO_CGC.", sediada em ".$INSTITUICAO_ENSINO_CIDADE." - ".$INSTITUICAO_ENSINO_UF.", endereco:".$INSTITUICAO_ENSINO_ENDERECO.", neste ato representada por seu ".$TIrepresentante_instituicao.", doravante designada simplesmente Instituicao de Ensino, resolveram celebrar o presente TERMO DE COMPROMISSO DE ESTAGIO OBRIGATORIO, que sera regido pela Lei número 11.788, de 25.09.2008, e respectivas alteracoes subsequentes, bem como pelas seguintes clausulas e condicoes:

<br>
<br>
<b>CLAUSULA PRIMEIRA - Da Vinculacao ao Convenio
</b>
<br>
Este Termo de Compromisso vincula-se, para todos os efeitos legais, ao Convenio de Concessao de Estagio celebrado em ".$_POST["dia"]." de ".$mes_texto." de ".$_POST["ano"].", entre a Embrapa e a Instituicao de Ensino, registrado no SAIC/Embrapa sob o numero ".$_POST["TIsaic"].".
<br>
<br>
<b>CLAUSULA SEGUNDA - Do Curso ou Programa
</b>
<br>
O Estudante e aluno formalmente matriculado/inscrito e com frequencia regular no Curso/Programa ".$ESTAGIARIO_CURSO.", iniciado no ".$_POST["TIcurso_inicio_semestre"]." semestre do ano de ".$_POST["TIcurso_inicio_ano"]." e com sua conclusao prevista para o ".$_POST["TIcurso_conclusao_semestre"]." semestre do ano de ".$_POST["TIcurso_conclusao_ano"].", nos horarios ".$_POST["TIcurso_horario"].", tudo de conformidade com a declaracao especifica da Instituicao de Ensino a qual se vincula o citado Curso/Programa, declaracao esta que passa a integrar o presente Termo de Compromisso como Anexo I.


<br>
<br>
<b>CLAUSULA TERCEIRA - Do Objeto
</b>
<br>
A Embrapa, por este instrumento, concede, ao Estudante, estagio com vistas a complementar sua formacao educacional e a sua preparacao para o trabalho produtivo, com sua efetiva atuacao nas atividades pertinentes a area de ".$SETOR_ATUACAO.", junto ao Setor de ".$_POST["TIarea_atuacao"]." de sua Unidade ". $UNIDADE_EMBRAPA." situada no endereco discriminado no preambulo deste instrumento, em consonancia com o \"PLANO DE ESTAGIO\" que, rubricado pelas partes e pela Instituicao de Ensino, integra este Termo de Compromisso como Anexo II.
<br>
<br>
<b>SUBCLAUSULA UNICA</b>: Supervisionará o estagio do estudante o empregado ".$ESTAGIARIO_ORIENTADOR.".
<br>
<br>
<b>CLAUSULA QUARTA - Da jornada de atividade
</b>
<br>
O Estudante obriga-se a cumprir uma jornada de atividade de ".$_POST["TIhoras_diarias"]." (".$HORAS_DIARIAS_ESCRITA.") horas diarias e ".$HORAS_SEMANAIS." (".$HORAS_SEMANAIS_ESCRITA.") horas semanais, nos seguintes horarios ".$_POST["TIestagio_horario"].".

<br>
<br>
<b>SUBCLAUSULA PRIMEIRA</b>: O Estudante em nivel de pos-graduacao devera estar vinculado a um projeto de pesquisa ou processo da Unidade da Embrapa, cujo objetivo esteja relacionado ao tema do trabalho de conclusao do curso a ser elaborado.
<br>
<br>
<b>SUBCLAUSULA SEGUNDA</b>: A jornada de atividade do Estudante podera ser flexibilizada pelo empregado supervisor, desde que mantida sua supervisao e a carga horaria definida nesta clausula.
<br>
<br>
<b>SUBCLAUSULA TERCEIRA</b>: A criterio do empregado supervisor, podera ser adotado o sistema de compensacao de horas, quando compativel com a jornada de atividade definida nesta clausula.
<br>
<br>
<b>
SUBCLAUSULA QUARTA</b>: Se a instituicao de ensino adotar verificacoes de aprendizagem periodicas ou finais, nos periodos de avaliacao, devidamente comprovados, a carga horaria do estagio sera reduzida a metade.
<br>
<br>
<b>
CLAUSULA QUINTA - Das Obrigacoes Especiais</b>
<br>
Sem prejuizo do disposto nas demais clausulas deste instrumento, o Estudante obriga-se especialmente ao seguinte:
<br>
a) atuar com zelo e dedicacao na execucao de suas atribuicoes, de forma a evidenciar desempenho satisfatorio nas avaliacoes periodicas a serem realizadas pelo Empregado Supervisor do estagio;
<br>
b) cumprir fielmente todas as instrucoes, recomendacoes de normas relativas ao estagio emanadas da Instituicao de Ensino e da Embrapa, em especial as constantes do Plano de Estagio;
<br>
d) preencher e assinar a proposta de seguro de acidentes pessoais referente ao Plano de Seguro de Vida em Grupo da Embrapa no ato da celebracao deste instrumento;
<br>
e) responsabilizar-se por qualquer dano ou prejuizo que venha a causar ao patrimonio da Embrapa por dolo ou culpa;
<br>
f) manter assiduidade e aproveitamento escolar satisfatorios em relacao ao curso/programa de que trata a clausula segunda durante a vigencia do estagio;
<br>
g) manter conduta compativel com a etica, os bons costumes e a probidade administrativa no desenvolvimento de estagio, evitando a pratica de atos que caracterizem falta grave;
<br>
h) observar a regulamentacao interna da Embrapa no exercicio de suas atividades, conforme orientacao do empregado supervisor. 

<br>
<br>
<b>
CLAUSULA SEXTA - Do Acesso as Instalacoes</b>
<br>
O acesso a infra-estrutura e instalacoes da Embrapa, pelo Estudante, sera o estritamente necessario a execucao das atividades objeto do estagio, observada a regulamentacao interna da Embrapa.
<br>
<br>
<b>CLAUSULA SETIMA - Dos Resultados</b>
<br>
A exploracao, a qualquer titulo, dos resultados dos trabalhos realizados pelo Estudante, privilegiaveis ou nao, pertencera automatica e exclusivamente a Embrapa, especialmente Direitos da Propriedade Industrial, Direito sobre Cultivares e Direitos Autorais.
<br>
<br>
<b>CLAUSULA OITAVA - Do Seguro</b>
<br>
A Embrapa obriga-se a contratar e a custear, direta ou indiretamente, seguro de acidentes pessoais em favor do Estudante, que tenham como causa direta o desempenho das atividades decorrentes do estagio, pela seguradora ".$_POST["TIseguradora"].", apolice numero ".$_POST["TIapolice"].".

<br>
<br>
<b>CLAUSULA NONA - Do Recesso</b>
<br>
E assegurado ao Estudante, sempre que o estagio tenha duracao igual ou superior a 1 (um) ano, um periodo de recesso de 30 (trinta) dias, a ser gozado preferencialmente durante suas ferias escolares.
<br>
<br>
<b>SUBCLAUSULA UNICA</b>: Os dias de recesso previstos nesta clausula serao concedidos de maneira proporcional nos casos de o estagio ter duracao inferior a 1 (um) ano.
<br>
<br>
<b>CLAUSULA DECIMA - Do Certificado de Estagio</b>
<br>

	Ao termino do estagio com aproveitamento, a Embrapa emitira o correspondente certificado de estagio, do qual constara:
<br>
a) a identificacao do Estudante (nome, nacionalidade, RG, CPF e outros);
<br>
b) a identificacao do curso e da Instituicao de Ensino frequentados pelo Estudante;
<br>
c) a unidade de lotacao;
<br>
d) o periodo de realizacao do estagio e respectiva carga horaria;
<br>
e) as atividades desenvolvidas no estagio, conforme previsto no plano de estagio; e
<br>
f) a avaliacao quanto ao aproveitamento do Estudante.

<br>
<br>
<b>SUBCLAUSULA UNICA</b>: A emissao do certificado de estagio ficara condicionada a entrega, pelo Estudante, da seguinte documentacao:
<br>
a) nada consta da biblioteca da Embrapa;
<br>
b) frequencias apuradas durante toda a realizacao do estagio;
<br>
c) formulario de avaliacao do Estudante preenchido, assinado e datado pelo empregado supervisor;
<br>
d) formulario de avaliacao do estagio preenchido, assinado e datado pelo estagiario;
<br>
e) cracha, quando for utilizado;
<br>
f) relatorio do projeto, caso o Estudante esteja vinculado a algum.

<br>
<br>
<b>CLAUSULA DECIMA PRIMEIRA - Da Vigencia</b>
<br>

O estagio tera vigencia inicial de ".$ESTAGIO_PERIODO."  (".$ESTAGIO_PERIODO_ESCRITO.") mes(es), com inicio em ".$ESTAGIO_INICIO." e termino em ".$ESTAGIO_FIM.", podendo ser prorrogado, no interesse das partes, mediante celebracao de Termo Aditivo por iguais periodos, ate completar o limite maximo de 2 (dois) anos, observadas as condicoes legais especificas e as exigencias regulamentares da Instituicao de Ensino.

<br>
<br>
<b>CLAUSULA DECIMA SEGUNDA - Da Rescisao</b>
<br>
A Embrapa podera rescindir o presente Termo de Compromisso, independentemente de previa interpelacao judicial ou extrajudicial, por descumprimento de qualquer de suas clausulas ou condicoes pelo Estudante, respondendo este pelos prejuizos ocasionados, salvo hipotese de caso fortuito ou de forca maior.
<br>
<br>
<b>SUBCLAUSULA UNICA</b>: Alem do acima exposto, o presente Termo de Compromisso extingui-se automaticamente nas seguintes hipoteses:

<br>
a) conduta reprovavel do Estudante no ambiente de trabalho;
<br>
b) conclusao, abandono de curso ou trancamento da matricula pelo Estudante junto a Instituicao de Ensino interveniente;
<br>
c) quando atingido o prazo limite de 2 (dois) anos;
<br>
d) ao final do prazo estabelecido no Termo de Compromisso de Estagio, se o mesmo nao for prorrogado;
<br>
e) extincao do convenio com a Instituicao de Ensino;
<br>
f) insuficiencia de desempenho do estagiario no cumprimento do plano de estagio.

<br>
<br>
<b>CLAUSULA DECIMA TERCEIRA - Da Denuncia</b>
<br>
Quaisquer das partes, independentemente de justo motivo e quando bem lhe convier, podera denunciar o presente Termo de Compromisso, desde que o faca por escrito, mediante aviso previo de, pelo menos, 05 (cinco) dias uteis.
<br>
<br>
<b>CLAUSULA DECIMA QUARTA - Do Foro</b>
<br>
Para solucao de quaisquer controversias porventura oriundas da execucao deste Convenio, as participes elegem o Foro da Justica Federal, Secao Judiciaria de Campinas-SP.
<br>
<br>
Estando assim justas e acordes, firmam o presente em 03 (tres) vias de igual teor e forma, para um so efeito legal, na presenca das testemunhas instrumentarias abaixo nomeadas e subscritas.
<br>
<br>
<b>".$UNIDADE_CIDADE. ",".$_POST ["dia"]." de ".$mes_texto." de ".$_POST["ano"].".</b>
<br>
<br>
<br>
___________________________________       _____________________________________
<br>
                Pela Embrapa                                                    Pela Instituicao de Ensino
<br>
<br>
___________________________________
<br>
            Estudante
<br>
<br>
___________________________________     
<br>
Nome:
<br>
CPF:
<br>
<br>
___________________________________
<br>
Nome:
<br>
CPF:
";

$html = utf8_decode($html);

#$pdf->SetFont('Arial','B',12);
#$pdf->Write(5,$texto0);
#$pdf->SetMargins(100,2,10);
#$pdf->SetFont('Arial','B',10);
#$pdf->Ln(10);
#$pdf->Write(5,$texto1);
#$pdf->SetMargins(10,2,10);

$pdf = new PDF();
$pdf->AddPage('P','A4');
$pdf->SetFont('Arial','B',12);
##$pdf->ln(70);
$pdf->Write(5,$texto0);

$pdf->SetMargins(100,2,10);
$pdf->SetFont('Arial','B',10);
$pdf->Ln(10);
$pdf->Write(5,$texto1);

$pdf->SetMargins(10,2,10);
$pdf->SetFont('Arial','',10);
#$pdf->SetLink($link);
#$pdf->Image('logo.png',10,12,30,0,'','http://www.fpdf.org');
$pdf->SetLeftMargin(15);
$pdf->SetFontSize(9);
$pdf->Ln(10);
$pdf->WriteHTML($html);
$pdf->Output();
?>
