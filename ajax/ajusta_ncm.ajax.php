<?php 
	include '../server/conexao.php';

	$ID_PRODUTO = addslashes($_REQUEST['ID_PRODUTO']);
	$CEST   = addslashes($_REQUEST['CEST']);

	$sql_ncm = "UPDATE TBL_PRODUTO SET CEST = '$CEST', AJUSTADO = 'S' WHERE ID_PRODUTO = '".$ID_PRODUTO."'";
	$exe_ncm = odbc_exec($db_consulta, $sql_ncm);
	if ($exe_ncm) {
		$sql_insert = "INSERT INTO TBL_UPDATE ( CEST, ID_PRODUTO, MANUAL )
									   VALUES ('$CEST', '$ID_PRODUTO', 'S' )";
		$exe_insert = odbc_exec($db_consulta, $sql_insert);
	}

	$resultado = ($exe_ncm) ? true : false ;

	$ajustado[] = array('resultado' => $resultado, );
	echo json_encode($ajustado);

?>