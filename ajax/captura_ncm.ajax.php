<?php 
    include '../server/conexao.php';
    include '../server/funcoes.php';
    @session_start();

    $sql_ncm = "SELECT ID_PRODUTO,
                       NOME_PRODUTO,
                       NCM,
                       AJUSTADO,
                       CPF_CNPJ
                  FROM TBL_PRODUTO
                 WHERE AJUSTADO = 'N'
              ORDER BY NOME_PRODUTO";
    $exe_ncm = odbc_exec($db_consulta, $sql_ncm);
    
    while ( $linha = odbc_fetch_object($exe_ncm) ) {
      $produtos[] = array( 'NCM' => $linha->NCM,
                           'ID_PRODUTO' => $linha->ID_PRODUTO,
                           'NOME_PRODUTO' => string_db_to_upper($linha->NOME_PRODUTO),
                           'AJUSTADO' => $linha->AJUSTADO,
                           'CPF_CNPJ' => $linha->CPF_CNPJ,
                         );
    }
    echo json_encode($produtos);
?>