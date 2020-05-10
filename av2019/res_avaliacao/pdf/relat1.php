<?php
include ("/usr/local/www/data/intranet/nosso_ambiente/functions.php3");
include ("func_relat.php");
include ("relat1_parametros.php");
$estagio_id=1359;
cabecalho();
$ret_estagio=sql("intranet","select * from intranet.estag_cad, intranet.estag_estagio WHERE intranet.estag_cad.id=intranet.estag_estagio.id_estag_cad AND intranet.estag_estagio.id='$estagio_id'");	

while($lis=mysql_fetch_row($ret_estagio))
{
$ESTAGIARIO_NOME=$lis[1];
$ESTAGIARIO_RG=$lis[2];
$ESTAGIARIO_CPF=$lis[3];
$ESTAGIARIO_DATA_NASCIMENTO=$lis[4];
$ESTAGIARIO_ENDERECO=$lis[5];
$ESTAGIARIO_BAIRRO=$lis[6];
$ESTAGIARIO_CIDADE=$lis[7];
$ESTAGIARIO_UF=$lis[8];
$INSTITUICAO_ENSINO=$lis[26];
}
?>
</head>
<body>
<center>
<h1>TERMO DE COMPROMISSO DE ESTAGIO OBRIGATORIO</h1>
</center>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<font class="inicio">
TERMO DE COMPROMISSO DE ESTAGIO OBRIGATORIO,<br/> QUE ENTRE SI CELEBRAM A EMPRESA BRASILEIRA DE<br/>PESQUISA AGROPECUARIA - EMBRAPA E O ALUNO: <br/><?php echo $ESTAGIARIO_NOME ?>, COM A INTERVENIENCIA DA INSTITUICAO DE ENSINO <?php echo $INSTITUICAO_ENSINO?> 
</font>
<br/>
<br/>
<font class="texto">
A <font class="texto1">Empresa Brasileira de Pesquisa Agropecuaria - Embrapa</font>, empresa pública federal, vinculada ao Ministerio da Agricultura, Pecuaria e Abastecimento, criada por forca da Lei n? 5.851, de 07.12.72, com Estatuto Social aprovado pelo Decreto n? 2.291, de 04.08.97, por intermedio de sua Unidade 
<font class="texto1">
<?php echo $UNIDADE_EMBRAPA?>, 
</font>
inscrita no CNPJ/MF sob n?
<font class="texto1">
<?php $UNIDADE_EMBRAPA_CGC?>
</font>
, sediada em
 <?php echo $UNIDADE_CIDADE?>
, na 
<?php echo $UNIDADE_ENDERECO?>
, neste ato representada por seu Chefe/Gerente Geral 
<?php echo $NOME_CHEFE_CNPMA?>
, doravante designada simplesmente Embrapa, e, de outro lado, o aluno 
<?php echo $ESTAGIARIO_NOME?>
, nacionalidade _ _ _ _ _ _, estado civil _ _ _ _ _ _ _ _ _ _, data de nascimento __/__/__, portador do RG n? _ _ _ _ _ _ _ _, Orgao Expedidor: _ _ _ _ _ _ _ _ _ _ , data de expedicao: __/__/__, inscrito no CPF/MF sob o N? _ _ _ _ _ _ _ _ _ _ _ _ _, residente e domiciliado em (Cidade/Estado) _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ , endereco _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _, doravante designado simplesmente Estudante, com a interveniencia da Instituicao de Ensino _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _, inscrita no CNPJ/MF sob o n? _ _ _ _ _ _ _ _ _ _ / _ _ _ _ _ _ - _ _ _ , sediada em (Cidade/Estado) _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ , endereco: _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ , neste ato representada por seu (Reitor/Diretor etc.) _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ , nome do representante legal _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _, doravante designada simplesmente Instituicao de Ensino, resolveram celebrar o presente TERMO DE COMPROMISSO DE ESTAGIO OBRIGATORIO, que sera regido pela Lei n? 11.788, de 25.09.2008, e respectivas alteracoes subsequentes, bem como pelas seguintes clausulas e condicoes:

<br/>
<br/>
<font class="texto1">
CLAUSULA PRIMEIRA - Da Vinculacao ao Convenio
</font>
<br/>
Este Termo de Compromisso vincula-se, para todos os efeitos legais, ao Convenio de Concessao de Estagio celebrado em __/__/__, entre a Embrapa e a Instituicao de Ensino, registrado no SAIC/Embrapa sob o n? _ _ _ _ _ _ _ _ _ _.

<br/>
<br/>
<font class="texto1">
CLAUSULA SEGUNDA - Do Curso ou Programa
</font>
<br/>

O Estudante e aluno formalmente matriculado/inscrito e com frequencia regular no Curso/Programa _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _, iniciado no _ _ _ _ _ _ _ semestre do ano de _ _ _ _ _ _ e com sua conclusao prevista para o _ _ _ _ _ _ _ semestre do ano de _ _ _ _, nos horarios de _ _ _ _ a _ _ _ _ _ _ _, tudo de conformidade com a declaracao especifica da Instituicao de Ensino a qual se vincula o citado Curso/Programa, declaracao esta que passa a integrar o presente Termo de Compromisso como Anexo I.


<br/>
<br/>
<font class="texto1">
CLAUSULA TERCEIRA - Do Objeto
</font>

<br/>
A Embrapa, por este instrumento, concede, ao Estudante, estagio com vistas a complementar sua formacao educacional e a sua preparacao para o trabalho produtivo, com sua efetiva atuacao nas atividades pe	rtinentes a area de _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _, junto ao Orgao/Departamento/Setor: _ _ _ _ _ _ _ _ _ _ de sua Unidade: _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ situada no endereco discriminado no preambulo deste instrumento, em consonancia com o "PLANO DE ESTAGIO" que, rubricado pelas partes e pela Instituicao de Ensino, integra este Termo de Compromisso como Anexo II. 

<br/>
<br/>
<font class="texto1">
SUBCLAUSULA UNICA</font>: Supervisionara o estagio do estudante o empregado _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _  .
<br/>
<br/>
<font class="texto1">
CLAUSULA QUARTA - Da jornada de atividade
</font>
<br/>

O Estudante obriga-se a cumprir uma jornada de atividade de _ _ _ (_ _ _ _ _) horas diarias e _ _ _ (_ _ _ _ _ _ _) horas semanais, nos seguintes horarios _ _ _ _  _.

<br/>
<br/>
<font class="texto1">
SUBCLAUSULA PRIMEIRA</font>: O Estudante em nivel de pos-graduacao devera estar vinculado a um projeto de pesquisa ou processo da Unidade da Embrapa, cujo objetivo esteja relacionado ao tema do trabalho de conclusao do curso a ser elaborado.


<br/>
<br/>
<font class="texto1">
SUBCLAUSULA SEGUNDA</font>: A jornada de atividade do Estudante podera ser flexibilizada pelo empregado supervisor, desde que mantida sua supervisao e a carga horaria definida nesta clausula.

<br/>
<br/>
<font class="texto1">
SUBCLAUSULA TERCEIRA</font>: A criterio do empregado supervisor, podera ser adotado o sistema de compensacao de horas, quando compativel com a jornada de atividade definida nesta clausula.

<br/>
<br/>
<font class="texto1">
SUBCLAUSULA QUARTA</font>: Se a instituicao de ensino adotar verificacoes de aprendizagem periodicas ou finais, nos periodos de avaliacao, devidamente comprovados, a carga horaria do estagio sera reduzida a metade.

<br/>
<br/>
<font class="texto1">
CLAUSULA QUINTA - Das Obrigacoes Especiais
</font>
<br/>

Sem prejuizo do disposto nas demais clausulas deste instrumento, o Estudante obriga-se especialmente ao seguinte:

a) atuar com zelo e dedicacao na execucao de suas atribuicoes, de forma a evidenciar desempenho satisfatorio nas avaliacoes periodicas a serem realizadas pelo Empregado Supervisor do estagio;
b) cumprir fielmente todas as instrucoes, recomendacoes de normas relativas ao estagio emanadas da Instituicao de Ensino e da Embrapa, em especial as constantes do "Plano de Estagio";
d) preencher e assinar a proposta de seguro de acidentes pessoais referente ao Plano de Seguro de Vida em Grupo da Embrapa no ato da celebracao deste instrumento;
e) responsabilizar-se por qualquer dano ou prejuizo que venha a causar ao patrimonio da Embrapa por dolo ou culpa;
f) manter assiduidade e aproveitamento escolar satisfatorios em relacao ao curso/programa de que trata a clausula segunda durante a vigencia do estagio;
g) manter conduta compativel com a etica, os bons costumes e a probidade administrativa no desenvolvimento de estagio, evitando a pratica de atos que caracterizem falta grave;
h) observar a regulamentacao interna da Embrapa no exercicio de suas atividades, conforme orientacao do empregado supervisor. 

<br/>
<br/>
<font class="texto1">
CLAUSULA SEXTA - Do Acesso as Instalacoes
</font>

<br/>
O acesso a infra-estrutura e instalacoes da Embrapa, pelo Estudante, sera o estritamente necessario a execucao das atividades objeto do estagio, observada a regulamentacao interna da Embrapa.

<br/>
<br/>
<font class="texto1">
CLAUSULA SETIMA - Dos Resultados
</font>
<br/>

A exploracao, a qualquer titulo, dos resultados dos trabalhos realizados pelo Estudante, privilegiaveis ou nao, pertencera automatica e exclusivamente a Embrapa, especialmente Direitos da Propriedade Industrial, Direito sobre Cultivares e Direitos Autorais.

<br/>
<br/>
<font class="texto1">
CLAUSULA OITAVA - Do Seguro
</font>
<br/>

A Embrapa obriga-se a contratar e a custear, direta ou indiretamente, seguro de acidentes pessoais em favor do Estudante, que tenham como causa direta o desempenho das atividades decorrentes do estagio, pela seguradora _ _ _ _ _ _ _ _ _ _ _ _, apolice n? _ _ _ _ _ _ _ _ _ _ _ .

<br/>
<br/>
<font class="texto1">
CLAUSULA NONA - Do Recesso
</font>
<br/>
E assegurado ao Estudante, sempre que o estagio tenha duracao igual ou superior a 1 (um) ano, um periodo de recesso de 30 (trinta) dias, a ser gozado preferencialmente durante suas ferias escolares.

<br/>
<br/>
<font class="texto1">
SUBCLAUSULA UNICA</font>: Os dias de recesso previstos nesta clausula serao concedidos de maneira proporcional nos casos de o estagio ter duracao inferior a 1 (um) ano.

<br/>
<br/>
<font class="texto1">
CLAUSULA DECIMA - Do Certificado de Estagio
</font>
<br/>

	Ao termino do estagio com aproveitamento, a Embrapa emitira o correspondente certificado de estagio, do qual constara:
a) a identificacao do Estudante (nome, nacionalidade, RG, CPF e outros);
b) a identificacao do curso e da Instituicao de Ensino frequentados pelo Estudante;
c) a unidade de lotacao;
d) o periodo de realizacao do estagio e respectiva carga horaria;
e) as atividades desenvolvidas no estagio, conforme previsto no plano de estagio; e
f) a avaliacao quanto ao aproveitamento do Estudante.

<br/>
<br/>
<font class="texto1">
SUBCLAUSULA UNICA</font>: A emissao do certificado de estagio ficara condicionada a entrega, pelo Estudante, da seguinte documentacao:
a) nada consta da biblioteca da Embrapa;
b) frequencias apuradas durante toda a realizacao do estagio;
c) formulario de avaliacao do Estudante preenchido, assinado e datado pelo empregado supervisor;
d) formulario de avaliacao do estagio preenchido, assinado e datado pelo estagiario;
e) cracha, quando for utilizado;
f) relatorio do projeto, caso o Estudante esteja vinculado a algum.

<br/>
<br/>
<font class="texto1">
CLAUSULA DECIMA PRIMEIRA - Da Vigencia
</font>
<br/>

O estagio tera vigencia inicial de _ _ _ (_ _ _ _ _ _ _ _) mes(es), com inicio em __/__/__ e termino em __/__/__, podendo ser prorrogado, no interesse das partes, mediante celebracao de Termo Aditivo por iguais periodos, ate completar o limite maximo de 2 (dois) anos, observadas as condicoes legais especificas e as exigencias regulamentares da Instituicao de Ensino.

<br/>
<br/>
<font class="texto1">
CLAUSULA DECIMA SEGUNDA - Da Rescisao
</font>
<br/>

A Embrapa podera rescindir o presente Termo de Compromisso, independentemente de previa interpelacao judicial ou extrajudicial, por descumprimento de qualquer de suas clausulas ou condicoes pelo Estudante, respondendo este pelos prejuizos ocasionados, salvo hipotese de caso fortuito ou de forca maior.

<br/>
<br/>
<font class="texto1">
SUBCLAUSULA UNICA</font>: Alem do acima exposto, o presente Termo de Compromisso extingui-se automaticamente nas seguintes hipoteses:

a) conduta reprovavel do Estudante no ambiente de trabalho;
b) conclusao, abandono de curso ou trancamento da matricula pelo Estudante junto a Instituicao de Ensino interveniente;
c) quando atingido o prazo limite de 2 (dois) anos;
d) ao final do prazo estabelecido no Termo de Compromisso de Estagio, se o mesmo nao for prorrogado;
e) extincao do convenio com a Instituicao de Ensino;
f) insuficiencia de desempenho do estagiario no cumprimento do plano de estagio.

<br/>
<br/>
<font class="texto1">
CLAUSULA DECIMA TERCEIRA - Da Denuncia
</font>
<br/>

Quaisquer das partes, independentemente de justo motivo e quando bem lhe convier, podera denunciar o presente Termo de Compromisso, desde que o faca por escrito, mediante aviso previo de, pelo menos, 05 (cinco) dias uteis.


<br/>
<br/>

<font class="texto1">
CLAUSULA DECIMA QUARTA - Do Foro
</font>
<br/>

Para solucao de quaisquer controversias porventura oriundas da execucao deste Convenio, as participes elegem o Foro da Justica Federal, Secao Judiciaria de _ _ _ _.

<br/>
<br/>
Estando assim justas e acordes, firmam o presente em 03 (tres) vias de igual teor e forma, para um so efeito legal, na presenca das testemunhas instrumentarias abaixo nomeadas e subscritas.

<br/>
<br/>
<font class="fim">
<?php echo $UNIDADE_CIDADE?>
,<?php echo date(d)?> de <?php echo date(M)?> de <?php echo date(Y)?>
</font>
<br/>
<br/>
<br/>
<br/>

<table>
<tr>
<td align="center">
__________________________________________________________
</td>
<td align="center">
__________________________________________________________

</td>
</tr>
<tr>
<td align="center">
Pela Embrapa
</td>
<td align="center">
Pela Instituicao de Ensino
</td>
</tr>
</table>
<br/>
<br/>
<table>
<tr>
<td colspan="2" align="center">
__________________________________________________________
</td>
</tr>
<tr>
<td colspan="2" align="center">
Estudante
</td>
</tr>
</table>
<br/>
<br/>
<table>
<tr>
<td align="center">
__________________________________________________________
</td>
<td align="center">
__________________________________________________________
</td>
</tr>
<tr>
<td align="left">
Nome:
</td>
<td align="left">
Nome:
</td>
<tr>
<td align="left">
CPF:
</td>
<td align="left">
CPF:
</td>
</tr>
</table>
</font>

<br/>
<br/>
<br/>
</body>
</html>
<?php
require_once("./dompdf/dompdf_config.inc.php");
$dompdf = new DOMPDF();
$dompdf->load_html($html);
$dompdf->set_paper('letter', 'landscape');
$dompdf->render();
$dompdf->stream("exemplo-01.pdf");
?>
