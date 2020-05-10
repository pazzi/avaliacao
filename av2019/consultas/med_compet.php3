
$str_sql="SELECT AvaliacaoComp.Pesq_Satisfacao_Resp_Item.cod_pergunta,
                     AVG(AvaliacaoComp.Pesq_Satisfacao_Resp_Item.cod_tipo_resposta)
                   FROM AvaliacaoComp.Pesq_Satisfacao_Resp_Item
                   WHERE AvaliacaoComp.Pesq_Satisfacao_Resp_Item.codigo_pesquisa IN
                       (SELECT AvaliacaoComp.Pesquisa_Opiniao.codigo_pesquisa
                             FROM AvaliacaoComp.Pesquisa_Opiniao
                             WHERE AvaliacaoComp.Pesquisa_Opiniao.ano_pesq='$ano_base'
                             AND AvaliacaoComp.Pesquisa_Opiniao.codigo_aval='1'
                             AND AvaliacaoComp.Pesquisa_Opiniao.matricula IN
                                                                   (SELECT cnpma.empregados.matr
                                                                           FROM cnpma.empregados
                                                                           WHERE cnpma.empregados.tipo='e'
                                                                           AND cnpma.empregados.situacao='a'
                                                                           AND cnpma.empregados.matr='$matr'))
                   AND AvaliacaoComp.Pesq_Satisfacao_Resp_Item.cod_tipo_resposta<>'5'
                   GROUP BY  AvaliacaoComp.Pesq_Satisfacao_Resp_Item.cod_pergunta"
$result=sql($BD3,$str_sql);
