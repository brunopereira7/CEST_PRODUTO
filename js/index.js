function aviso(codigo_aviso){
	if (codigo_aviso == 1) {
		if (confirm("Deseja realmente LIMPAR a tabela de NCM para inserir novos dados?") == true) {
			//aqui vai uma funcao para deletar tudo
			deltaNCM();
		}
	}
	if (codigo_aviso == 2) {
		if (confirm("Deseja importar novos NCMs?") == true) {
			//aqui vai uma funcao para importar
			importaNCM();
		}
	}
}
function deltaNCM() {


	$.getJSON('ajax/deleta_ncm.ajax.php',{
		ajax: 'true',
	}, 
	function(j){
		if (j[0].resultado) {
			alert('NCMs deletados com sucesso.');
		}else{
			alert('Erro ao deletar NCMs.');
		}
	});
}
function importaNCM() {


	$.getJSON('ajax/importa_ncm.ajax.php',
	function(j){
		if (j[0].resultado) {
			captura_ncm();
			alert('Processo de importação finalizado.');
		}else{
			alert('Erro na importação NCMs.');
		}
	});
}

function captura_ncm() {

	$.getJSON('ajax/captura_ncm.ajax.php', 
	function(j){

		var tabela = '';
		var tr = '';
		var classe_do_btn = '';
		tabela = '\n<tr>';
		tabela += '\n	<th>#</th>';
		tabela += '\n	<th>ID</th>';
		tabela += '\n	<th>PRODUTO</th>';
		tabela += '\n	<th>NCM</th>';
		tabela += '\n	<th>CNPJ</th>';
		tabela += '\n</tr>'; 
		for (var i = 0; i < j.length; i++) {
			tr += '\n<tr>';
			tr += '\n	<td>'+(i+1)+'</td>';
			tr += '\n	<td>'+j[i].ID_PRODUTO+'</td>';
			tr += '\n	<td>'+j[i].NOME_PRODUTO+'</td>';
			tr += '\n	<td>'+j[i].NCM+'</td>';
			tr += '\n	<td>'+j[i].CPF_CNPJ+'</td>';
			if (j[i].AJUSTADO == 'S'){
				tr += '\n	<td><button data-toggle="modal" data-target=".bs-example-modal-lg" class="btn btn-success">Ajuste</button></td>';
			}else{
				tr += '\n	<td><button id="'+j[i].ID_PRODUTO+'" name="'+j[i].NCM+'" onclick="verificaNCM(id,name)" data-toggle="modal" data-target=".bs-example-modal-lg" class="btn btn-danger">Ajuste</button></td>';
			}
			tr += '\n</tr>';
		}
		var concatenado = tabela + tr;
		document.getElementById('tabela_ncm').innerHTML = concatenado;
	});
}

function verificaNCM(id_produto,NCM){
	$.getJSON('ajax/verifica_ncm.ajax.php',{
		NCM: NCM,
		id_produto: id_produto
	},
	function(j){
		var tabela = '';
		var tr = '';

		tabela = '\n<tr>';
		tabela += '\n	<th>ID</th>';
		tabela += '\n	<th>NCM</th>';
		tabela += '\n	<th>QTD Caracter NCM</th>';
		tabela += '\n	<th>CEST</th>';
		tabela += '\n	<th>DESCRIÇÃO</th>';
		tabela += '\n	<th>SEGMENTO</th>';
		tabela += '\n	<th>!</th>';
		tabela += '\n</tr>'; 
		for (var i = 0; i < j.length; i++) {
			tr += '\n<tr>';
			tr += '\n	<td>'+j[i].ID_CEST+'</td>';
			tr += '\n	<td>'+j[i].NCM+'</td>';
			tr += '\n	<td>'+j[i].NCM.length+'</td>';
			tr += '\n	<td>'+j[i].CEST+'</td>';
			tr += '\n	<td>'+j[i].DESCRICAO+'</td>';
			tr += '\n	<td>'+j[i].SEGMENTO+'</td>';
			tr += '\n	<td><button id="'+id_produto+'" name="'+j[i].CEST+'" onclick="ajustaNCM(id,name)" type="button" class="btn btn-warning">Atualizar</button></td>';
			tr += '\n</tr>';
		}
		var concatena;
		concatena = tabela + tr;
		document.getElementById('nomeNCM').innerHTML = 'NCM: '+NCM;
		document.getElementById('produtoNome').innerHTML = 'Descrição Produto: '+ j[0].NOME_PRODUTO;
		document.getElementById('produtoPesoBruto').innerHTML = 'Peso Bruto: '+ j[0].PESO_BRUTO;
		document.getElementById('produtoPesoLiquido').innerHTML = 'Peso Líquido: '+ j[0].PESO_LIQUIDO;
		document.getElementById('produtoUnidade').innerHTML = 'Unidade: '+ j[0].UNIDADE;
		document.getElementById('resultado_ncm').innerHTML = concatena;
	});
}

function ajustaNCM(id_produto,cest) {
	$.getJSON('ajax/ajusta_ncm.ajax.php',{
		ID_PRODUTO: id_produto,
		CEST: cest,
	},function(j){
		if (j[0].resultado){
			$('#'+id_produto).removeClass("btn-danger");
			$('#'+id_produto).addClass("btn-success");
			$('#myModal').modal('hide');
		}else{
			alert('Erro ao fazer ajuste ID_NCM: '+id_produto);
		}
		captura_ncm();
	});
}

function arrumaNCM() {
	
	$.getJSON('ajax/arruma_ncm.ajax.php',
	function(j){
		if (j[0].resultado){
			alert('NCMs ajustados com sucesso!');
		}else{
			alert('Erro ao fazer ajustar NCMs');
		}
	});
}

function listarUpdate() {

	$.getJSON('ajax/gerar_scripts.ajax.php',
	function(j){
		var tabela_update = '';
		tabela_update = '<tr>'+
						'	<th>Total: '+j.length+'</th>'+
						'	<th>UPDATE</th>'+
						'</tr>';

		for (var i = 0; i < j.length; i++) {
			tabela_update += '<tr>';
			tabela_update += '	<td></td>';
			tabela_update += '	<td>'+j[i].UPDATE+'</td>';
			tabela_update += '</tr>';
		}
		document.getElementById('tabela_update').innerHTML = tabela_update;
	});
}