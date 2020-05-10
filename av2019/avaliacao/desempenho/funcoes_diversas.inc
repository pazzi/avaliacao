<?php
/*Embrapa - Empresa Brasileira de Pesquisa Agropecuária
Embrapa Meio Ambiente
Autor: Cláudia Vaz Crecci
Data: 29/06/2005
Sistema: Clientes

***** Atualizações *****
Autor: Cláudia Vaz Crecci
Data: 14/07/2005
Descrição: Tratamento para retornar código referente à opção selecionada nos
DropDownLists: profissões, países, empresas e pessoas físicas.
Autor: Cláudia Vaz Crecci
Data: 21/07/2005
Descrição: Criação dos métodos para obter descrição de determinado país, profissões e empresa.
Data: 26/07/2005
Descrição: Criação do método para validação de data.
Data: 02/08/2005
Descrição: Criação do método para obter as atuações das empresas.
Data: 03/08/2005
Descrição: Criação do método para obter a descrição de determinada atuação.
Data: 08/08/2005
Descrição: Criação dos métodos para atendimento.
Data: 10/08/2005
Descrição: Criação do método para obter o nome de um determinado cliente do tipo
Pessoa Física / Sociedade Civil / ONG.
Data: 11/08/2005
Descrição: Criação dos métodos para obter a descrição de determinado motivo,
contato e assunto genérico do atendimento do cliente.
Data: 17/08/2005
Descrição: Criação dos métodos para verificar se a data do atendimento é maior
que a data atual e validação de e-mail.
Data: 18/08/2005
Descrição: Criação do método para validar CEP.
Data: 24/08/2005
Descrição: Criação dos métodos para validar CPF e CNPJ
Data: 20/12/2005
Descrição: Criação do método para validar data inicial maior que data final.
Data: 21/12/2005
Descrição: O tratamento para o usuário digitar o CPF e CNPJ com máscara foi "retirado" do código (comentado - usuário não digita CPF e CNPJ com máscara).
*/

function mtObtemProfissoes($sel="") {
$profissoes = sql("clientes","select id, descr from profissoes order by descr;");
        $opcoes.= "<option></option>";
            while($lista = mysql_fetch_row($profissoes))
            {
                $opcoes.= "<option value=\"$lista[0]\" ";
    			$opcoes.= ($lista[0]==$sel) ? "selected " : "";
	       		$opcoes.= " > $lista[1]</option>\n";
            }
        return $opcoes;
}

function mtObtemAtuacoesEmpresas($sel="") {
$atuacoes = sql("clientes","select id, descr from atu_empresas order by descr;");
        $opcoes.= "<option></option>";
            while($lista = mysql_fetch_row($atuacoes))
            {
                $opcoes.= "<option value=\"$lista[0]\" ";
    			$opcoes.= ($lista[0]==$sel) ? "selected " : "";
	       		$opcoes.= " > $lista[1]</option>\n";
            }
        return $opcoes;
}

function mtObtemUF($sel="") {
$uf = sql("cnpma","select id, nome from uf order by nome;");
        $opcoes.= "<option></option>";
            while($lista = mysql_fetch_row($uf))
            {
                $opcoes.= "<option value=\"$lista[1]\" ";
    			$opcoes.= ($lista[1]==$sel) ? "selected " : "";
	       		$opcoes.= " >$lista[1]</option>\n";
            }
		return $opcoes;
}

function mtObtemPaises($sel="") {
$paises = sql("cnpma","select id, nome from paises order by nome;");
        $opcoes.= "<option></option>";
            while($lista = mysql_fetch_row($paises))
            {
                $opcoes.= "<option value=\"$lista[0]\" ";
    			$opcoes.= ($lista[0]==$sel) ? "selected " : "";
	       		$opcoes.= " >$lista[1]</option>\n";
            }
		return $opcoes;
}

// Obtem empresa privada (tipo = 1) e empresa pública (tipo = 2)
function mtObtemEmpresas($sel = "") {
        $empresas = sql("clientes","select id, nome, cnpj from cliente where ((tipo = 1) or (tipo = 2)) order by nome;");
        $opcoes.= "<option></option>";
            while($lista = mysql_fetch_row($empresas))
            {
                $opcoes.= "<option value=\"$lista[0]\" ";
    			$opcoes.= ($lista[0]==$sel) ? "selected " : "";
	       		$opcoes.= " >$lista[1]</option>\n";
            }
		return $opcoes;
}

function mtObtemEmpresasPrivadas($sel = "") {
        $empresasPrivadas = sql("clientes","select id, nome, cnpj from cliente where (tipo = 1) order by nome;");
        $opcoes.= "<option></option>";
            while($lista = mysql_fetch_row($empresasPrivadas))
            {
                $opcoes.= "<option value=\"$lista[0]\" ";
    			$opcoes.= ($lista[0]==$sel) ? "selected " : "";
	       		$opcoes.= " >$lista[1]</option>\n";
            }
		return $opcoes;
}

function mtObtemEmpresasPublicas($sel = "") {
        $empresasPublicas = sql("clientes","select id, nome, cnpj from cliente where (tipo = 2) order by nome;");
        $opcoes.= "<option></option>";
            while($lista = mysql_fetch_row($empresasPublicas))
            {
                $opcoes.= "<option value=\"$lista[0]\" ";
    			$opcoes.= ($lista[0]==$sel) ? "selected " : "";
	       		$opcoes.= " >$lista[1]</option>\n";
            }
		return $opcoes;
}

function mtObtemPessoasFisicas($sel="") {
$pessoasFisicas = sql("clientes","select id, nome from cliente where tipo='0' order by nome;");
        $opcoes.= "<option></option>";
            while($lista = mysql_fetch_row($pessoasFisicas))
            {
                $opcoes.= "<option value=\"$lista[0]\" ";
    			$opcoes.= ($lista[0]==$sel) ? "selected " : "";
	       		$opcoes.= " >$lista[1]</option>\n";
            }
		return $opcoes;
}

function mtObtemDescricaoPais($cod_pais) {
    $descricao = sql("cnpma","select nome from paises where id = '$cod_pais';");
            while($lista = mysql_fetch_row($descricao))
            {
                $descPais = $lista[0];
            }
		return $descPais;
}

function mtObtemDescricaoProfissao($cod_profissao) {
    $descricao = sql("clientes","select descr from profissoes where id = '$cod_profissao';");
            while($lista = mysql_fetch_row($descricao))
            {
                $descProfissao = $lista[0];
            }
		return $descProfissao;
}

function mtObtemDescricaoAtuacao($cod_atuacao) {
    $descricao = sql("clientes","select descr from atu_empresas where id = '$cod_atuacao';");
            while($lista = mysql_fetch_row($descricao))
            {
                $descAtuacao = $lista[0];
            }
		return $descAtuacao;
}

function mtObtemDescricaoEmpresa($cod_empresa) {
        $descricao = sql("clientes","select nome from cliente where id = '$cod_empresa';");
            while($lista = mysql_fetch_row($descricao))
            {
                $descEmpresa = $lista[0];
            }
		return $descEmpresa;
}

function mtObtemDescricaoPessoaFisica($cod_cliente) {
        $descricao = sql("clientes","select nome from cliente where id = '$cod_cliente';");
            while($lista = mysql_fetch_row($descricao))
            {
                $descCliente = $lista[0];
            }
		return $descCliente;
}

function mtObtemTiposAtendimentosClientes($sel="") {
$tiposAtendCli = sql("clientes","select id, nome from tipos order by nome;");
            while($lista = mysql_fetch_row($tiposAtendCli))
            {
                $opcoes.= "<option value=\"$lista[0]\" ";
    			$opcoes.= ($lista[0]==$sel) ? "selected " : "";
	       		$opcoes.= " >$lista[1]</option>\n";
            }
		return $opcoes;
}

function mtObtemDescricaoAtendimento($cod_atendimento) {
        $descricao = sql("clientes","select nome from tipos where id = '$cod_atendimento';");
            while($lista = mysql_fetch_row($descricao))
            {
                $descAtendimento = $lista[0];
            }
		return $descAtendimento;
}

function mtObtemAssuntosGenericos($sel="") {
$assuntosGenericos = sql("hp","select codigo, descricao from areas_desc order by descricao;");
        $opcoes.= "<option></option>";
            while($lista = mysql_fetch_row($assuntosGenericos))
            {
                $opcoes.= "<option value=\"$lista[0]\" ";
    			$opcoes.= ($lista[0]==$sel) ? "selected " : "";
	       		$opcoes.= " >$lista[1]</option>\n";
            }
		return $opcoes;
}

function mtObtemDescricaoAssuntoGenerico($cod_assunto) {
        $descricao = sql("hp","select descricao from areas_desc where codigo = '$cod_assunto';");
            while($lista = mysql_fetch_row($descricao))
            {
                $descAssuntoGen = $lista[0];
            }
		return $descAssuntoGen;
}

function mtObtemMotivosAtendimento($sel="") {
        $motivos = sql("clientes","select id, descr from motivo order by descr;");
        $opcoes.= "<option></option>";
            while($lista = mysql_fetch_row($motivos))
            {
                $opcoes.= "<option value=\"$lista[0]\" ";
    			$opcoes.= ($lista[0]==$sel) ? "selected " : "";
	       		$opcoes.= " >$lista[1]</option>\n";
            }
		return $opcoes;
}

function mtObtemDescricaoMotivoAtendimento($cod_motivo) {
        $descricao = sql("clientes","select descr from motivo where id = '$cod_motivo';");
            while($lista = mysql_fetch_row($descricao))
            {
                $descMotivoAtend = $lista[0];
            }
		return $descMotivoAtend;
}

    function mtObtemContatosAtendimento($sel="")
    {
#Oi Claudia...alterei para incluir Silvia Bau

        $statement = "select matr, nome from empregados ";
        $statement .= "where (situacao = 'A') ";
        $statement .= "and (tipo = 'E') ";
        $statement .= "or (matr = '315971') ";
        $statement .= "order by nome";

        $empregados = sql("cnpma",$statement);

        $opcoes.= "<option></option>";

        while($lista = mysql_fetch_row($empregados))
        {
           $opcoes.= "<option value=\"$lista[0]\" ";
    	   $opcoes.= ($lista[0]==$sel) ? "selected " : "";
	       $opcoes.= " >$lista[1]</option>\n";
        }
 	    return $opcoes;
    }


function mtObtemDescricaoContatoAtendimento($matricula) {
        $descricao = sql("cnpma","select nome from empregados where matr = '$matricula';");
            while($lista = mysql_fetch_row($descricao))
            {
                $descContato = $lista[0];
            }
		return $descContato;
}


function mtObtemMatriculaEmpregadoAtendimento($username) {
		
    $matricula = sql("cnpma","select matr from empregados where email = '$username';");

    while($lista = mysql_fetch_row($matricula))
    {
        $matr = $lista[0];
    }

    return $matr;
}

function mtObtemListaLetras($sel="") {
    $letras = Array("A"=>"A","B"=>"B","C"=>"C","D"=>"D","E"=>"E","F"=>"F","G"=>"G","H"=>"H","I"=>"I","J"=>"J","K"=>"K","L"=>"L","M"=>"M","N"=>"N","O"=>"O","P"=>"P","Q"=>"Q","R"=>"R","S"=>"S","T"=>"T","U"=>"U","V"=>"V","W"=>"W","X"=>"X","Y"=>"Y","Z"=>"Z","Outros"=>"Outros");
		$rel_letras = "";
		foreach($letras as $sigla => $letra) {
			$rel_letras.="<option value=\"$sigla\" ";
			$rel_letras.=($sigla==$sel) ? "SELECTED " : "";
			$rel_letras.=">$letra</option>\n";
		}
		return $rel_letras;
	}


//Formato do parâmetro: $data_param = dd/mm/yyyy
function mtValidaData($data_param) {
    $data = explode("/",$data_param);
    return checkdate($data[1],$data[0],$data[2]);
}

//Formato do parâmetro: $data_param = dd/mm/yyyy
function mtValidaDataAtual($data_param) {
    
    $data = explode("/",$data_param);
    $dtParam = mktime ($data[1],$data[0],$data[2]);
    $data  = getDate();
    $dtAtual = mktime ($data[mon],$data[mday],$data[year]);

    if ($dtParam > $dtAtual) {
      return true;
    } else return false;

}

//Formato dos parâmetros: $data_inicial e $data_final = dd/mm/yyyy
function mtValidaDataInicialDataFinal($data_inicial, $data_final) {

    $dataIni = explode("/",$data_inicial);
    $dtParamIni = mktime ($dataIni[1],$dataIni[0],$dataIni[2]);

    $dataFin = explode("/",$data_final);
    $dtParamFin = mktime ($dataFin[1],$dataFin[0],$dataFin[2]);

    if ($dtParamFin >= $dtParamIni)
    {
      return true;
    } else return false;

}

function mtValidaEmail($email) {

    if (strpos($email,"@") <= 0)
        return false;

    $email_param = explode("@",$email);
    $mail = $email_param;

    if ((empty($mail[1])) or (strpos($mail[1],".") <= 0))
        return false;

    $email_param = explode(".",$email);
    $mail = $email_param;

    if (empty($mail[1]))
        return false;

    return true;
}

function mtValidaCEP($cep) {

    if ((!(ereg("([0-9]{5})-([0-9]{3})",$cep,$regs) or ereg("([0-9]{8})",$cep,$regs)))
    or (strpos($cep,"-") <= 0))
    	return false;

	return true;
}

function mtValidaCPF($cpf)
{
    /*//Início: tratamento CPF com máscara
    //O tratamento listado a seguir deve ser usado quando
    //o usuário for digitar o CPF com máscara
    // Verifica se o CPF está com a máscara 999.999.999-99
    if (!(ereg("([0-9]{3})\.([0-9]{3})\.([0-9]{3})-([0-9]{2})",$cpf,$regs)))
    {
        return false;
    }

    // Retira caracteres do CPF
    $digitosCPF1 = explode(".",$cpf);
    $digitosCPF2 = explode("-",$digitosCPF1[2]);

    $digitos_cpf = "$digitosCPF1[0]$digitosCPF1[1]$digitosCPF2[0]$digitosCPF2[1]";

    $cpf_param = $digitos_cpf;
    //Fim: tratamento CPF com máscara*/

    // Retirar essa linha quando usar CPF com máscara
    $cpf_param = $cpf;

    if ((strlen($cpf_param)!=11) or ($cpf_param=="00000000000"))
    {
        return false;
    }
    else
        { // Início: Validação CPF - Regras
            $Numero[1]=intval(substr($cpf_param,1-1,1));
            $Numero[2]=intval(substr($cpf_param,2-1,1));
            $Numero[3]=intval(substr($cpf_param,3-1,1));
            $Numero[4]=intval(substr($cpf_param,4-1,1));
            $Numero[5]=intval(substr($cpf_param,5-1,1));
            $Numero[6]=intval(substr($cpf_param,6-1,1));
            $Numero[7]=intval(substr($cpf_param,7-1,1));
            $Numero[8]=intval(substr($cpf_param,8-1,1));
            $Numero[9]=intval(substr($cpf_param,9-1,1));
            $Numero[10]=intval(substr($cpf_param,10-1,1));
            $Numero[11]=intval(substr($cpf_param,11-1,1));

            $soma=10*$Numero[1]+9*$Numero[2]+8*$Numero[3]+7*$Numero[4]+6*$Numero[5]+5*$Numero[6]+4*$Numero[7]+3*$Numero[8]+2*$Numero[9];

            $soma=$soma-(11*(intval($soma/11)));

            if ($soma==0 || $soma==1)
            {
                $resultado1=0;
            }
            else
                {
                    $resultado1=11-$soma;
                }

            if ($resultado1==$Numero[10])
            {
                $soma=$Numero[1]*11+$Numero[2]*10+$Numero[3]*9+$Numero[4]*8+$Numero[5]*7+$Numero[6]*6+$Numero[7]*5+$Numero[8]*4+$Numero[9]*3+$Numero[10]*2;

                $soma=$soma-(11*(intval($soma/11)));

                if ($soma==0 || $soma==1)
                {
                    $resultado2=0;
                }
                else
                    {
                        $resultado2=11-$soma;
                    }

              if ($resultado2==$Numero[11])
              {
                    return true;
              }
              else
              {
                    return false;
              }
        }
            else
                {
                     return false;
                }
      } // Fim: Validação CPF - Regras

}

function mtValidaCNPJ($cnpj)
{
    /*//Início: tratamento CNPJ com máscara
    //O tratamento listado a seguir deve ser usado quando
    //o usuário for digitar o CNPJ com máscara

    // Verifica se o CNPJ está com a máscara 99.999.999/9999-99
    if (!(ereg("([0-9]{2})\.([0-9]{3})\.([0-9]{3})/([0-9]{4})-([0-9]{2})",$cnpj,$regs)))
    {
        return false;
    }

    // Retira caracteres do CNPJ
    $digitosCNPJ1 = explode(".",$cnpj);
    $digitosCNPJ2 = explode("/",$digitosCNPJ1[2]);
    $digitosCNPJ3 = explode("-",$digitosCNPJ2[1]);

    $digitos_cnpj = "$digitosCNPJ1[0]$digitosCNPJ1[1]$digitosCNPJ2[0]$digitosCNPJ3[0]$digitosCNPJ3[1]";

    $cnpj_param = $digitos_cnpj;
    */

    // Retirar essa linha quando usar CNPJ com máscara
    $cnpj_param = $cnpj;

    if ((strlen($cnpj_param)!=14) or ($cnpj_param=="00000000000000"))
    {
        return false;
    }
    else // Início: Validação CNPJ - regras
       {
            $Numero[1]=intval(substr($cnpj_param,1-1,1));
            $Numero[2]=intval(substr($cnpj_param,2-1,1));
            $Numero[3]=intval(substr($cnpj_param,3-1,1));
            $Numero[4]=intval(substr($cnpj_param,4-1,1));
            $Numero[5]=intval(substr($cnpj_param,5-1,1));
            $Numero[6]=intval(substr($cnpj_param,6-1,1));
            $Numero[7]=intval(substr($cnpj_param,7-1,1));
            $Numero[8]=intval(substr($cnpj_param,8-1,1));
            $Numero[9]=intval(substr($cnpj_param,9-1,1));
            $Numero[10]=intval(substr($cnpj_param,10-1,1));
            $Numero[11]=intval(substr($cnpj_param,11-1,1));
            $Numero[12]=intval(substr($cnpj_param,12-1,1));
            $Numero[13]=intval(substr($cnpj_param,13-1,1));
            $Numero[14]=intval(substr($cnpj_param,14-1,1));

            $soma=$Numero[1]*5+$Numero[2]*4+$Numero[3]*3+$Numero[4]*2+$Numero[5]*9+$Numero[6]*8+$Numero[7]*7+$Numero[8]*6+$Numero[9]*5+$Numero[10]*4+$Numero[11]*3+$Numero[12]*2;

            $soma=$soma-(11*(intval($soma/11)));

            if ($soma==0 || $soma==1)
            {

                  $resultado1=0;
            }
                else
                {
                    $resultado1=11-$soma;
                }

            if ($resultado1==$Numero[13])
            {
                $soma=$Numero[1]*6+$Numero[2]*5+$Numero[3]*4+$Numero[4]*3+$Numero[5]*2+$Numero[6]*9+$Numero[7]*8+$Numero[8]*7+$Numero[9]*6+$Numero[10]*5+$Numero[11]*4+$Numero[12]*3+$Numero[13]*2;

                $soma=$soma-(11*(intval($soma/11)));

                if ($soma==0 || $soma==1)
                {
                    $resultado2=0;
                }
                else
                    {
                        $resultado2=11-$soma;
                    }

                if ($resultado2==$Numero[14])
                {
                    return true;
                }
                else
                    {
                        return false;
                    }
          }
          else
             {
                return false;
             }
  } // Fim: validação CNPJ - regras

}

?>
