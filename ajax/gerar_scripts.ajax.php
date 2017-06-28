<?php 
	include '../server/conexao.php';
	$sql_ncm = "SELECT ID_PRODUTO,
					   CEST
				  FROM TBL_UPDATE
			  ORDER BY ID_UPDATE DESC";
	$exe_ncm = odbc_exec($db_consulta, $sql_ncm);

	while ( odbc_fetch_row($exe_ncm) ) {
		$CEST = odbc_result($exe_ncm, 'CEST');
		$ID_PRODUTO  = odbc_result($exe_ncm, 'ID_PRODUTO');
		$update = "UPDATE TBL_PRODUTO SET CEST = '$CEST' WHERE ID_PRODUTO = '$ID_PRODUTO';";

		$updates_gerados[] = array('UPDATE' => $update,);
	}
	echo json_encode($updates_gerados);
?>