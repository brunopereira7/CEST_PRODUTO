<?php 
	include '../server/conexao.php';
	include '../server/funcoes.php';
	$ncm = addslashes($_REQUEST['NCM']);
	$ID_PRODUTO = addslashes($_REQUEST['id_produto']);

	$NCM_ORIGINAL = $ncm;
	// $ncm = str_split($ncm);
	// $ncm_2 = $ncm[0] . $ncm[1];
	// $ncm_3 = $ncm_2 . $ncm[2];
	// $ncm_4 = $ncm_3 . $ncm[3];
	// $ncm_5 = $ncm_4 . $ncm[4];
	// $ncm_6 = $ncm_5 . $ncm[5];
	// $ncm_7 = $ncm_6 . $ncm[6];
	// $ncm_8 = $ncm_7 . $ncm[7];

	$sql_repetido = "SELECT ID_CEST,
							NCM,
							CEST,
							DESCRICAO,
							SEGMENTO
					   FROM TBL_CEST 
					  WHERE NCM = '".$NCM_ORIGINAL."'
					";
	$exe_repetido = odbc_exec($db_consulta, $sql_repetido);

	$sql_produto  = "SELECT NOME_PRODUTO,
							PESO_BRUTO, 
							PESO_LIQUIDO, 
							UNIDADE 
					   FROM TBL_PRODUTO 
					  WHERE ID_PRODUTO = '".$ID_PRODUTO."'";
	$exe_produto  = odbc_exec($db_consulta, $sql_produto);
	$NOME_PRODUTO = string_db_to_upper(odbc_result($exe_produto, 'NOME_PRODUTO'));
	$PESO_BRUTO   = odbc_result($exe_produto, 'PESO_BRUTO');
	$PESO_LIQUIDO = odbc_result($exe_produto, 'PESO_LIQUIDO');
	$UNIDADE      = string_db_to_upper(odbc_result($exe_produto, 'UNIDADE'));

	for ($i=0; $tupla = odbc_fetch_object($exe_repetido) ; $i++) {
		$lista_cest[] = array(
			'ID_CEST' => $tupla->ID_CEST,
			'NCM' => $tupla->NCM,
			'CEST' => $tupla->CEST,
			'DESCRICAO' => string_db_to_upper($tupla->DESCRICAO),
			'SEGMENTO' => string_db_to_upper($tupla->SEGMENTO),
			'NCM_ORIGINAL' => $NCM_ORIGINAL,
			'NOME_PRODUTO' => $NOME_PRODUTO,
			'PESO_BRUTO' => $PESO_BRUTO,
			'PESO_LIQUIDO' => $PESO_LIQUIDO,
			'UNIDADE' => $UNIDADE,
		);
	}
	echo json_encode( $lista_cest ) ;
?>