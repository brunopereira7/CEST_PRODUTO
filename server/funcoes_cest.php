<?php 
    function insertNCM(){
        include '../server/conexao.php';

        $sql_ncm = "SELECT ID_PRODUTO,
                           NOME_PRODUTO,
                           NCM,
                           PESO_BRUTO,
                           PESO_LIQUIDO,
                           UNIDADE
                      FROM TBL_PRODUTO
                     WHERE NCM = '11010010' 
                        OR NCM = '19012000'";
        $exe_ncm = odbc_exec($db_cliente, $sql_ncm);

        $sql_empresa = odbc_exec($db_cliente, "SELECT CNPJ_CPF FROM TBL_EMPRESA WHERE ID_EMPRESA = 1");

        if ($sql_empresa) {
            $CPF_CNPJ = odbc_result($sql_empresa, "CNPJ_CPF");
        }else{
            $CPF_CNPJ = 'erro_000000000';
        }


        $inseridos = false;

        while (odbc_fetch_row($exe_ncm)) {
            $ID_PRODUTO   = odbc_result($exe_ncm, 'ID_PRODUTO');
            $ID_PRODUTO   = str_replace("'", "''", $ID_PRODUTO);

            $NOME_PRODUTO = odbc_result($exe_ncm, 'NOME_PRODUTO');
            $NOME_PRODUTO   = str_replace("'", "''", $NOME_PRODUTO);

            $NCM          = odbc_result($exe_ncm, 'NCM');
            $PESO_BRUTO   = odbc_result($exe_ncm, 'PESO_BRUTO');
            $PESO_LIQUIDO = odbc_result($exe_ncm, 'PESO_LIQUIDO');
            $UNIDADE      = odbc_result($exe_ncm, 'UNIDADE');

            $sql_produto = "INSERT INTO TBL_PRODUTO(ID_PRODUTO,
                                                    NOME_PRODUTO,
                                                    NCM,
                                                    CPF_CNPJ,
                                                    PESO_BRUTO,
                                                    PESO_LIQUIDO,
                                                    UNIDADE
                                                   ) 
                                            VALUES ('$ID_PRODUTO',
                                                    '$NOME_PRODUTO',
                                                    '$NCM',
                                                    '$CPF_CNPJ',
                                                    $PESO_BRUTO,
                                                    $PESO_LIQUIDO,
                                                    '$UNIDADE'
                                                   )";
            $exe_produto = odbc_exec($db_consulta, $sql_produto);
            if ($exe_produto) {
                $inseridos = true;
            }
        }
        return $inseridos;

    }
?>