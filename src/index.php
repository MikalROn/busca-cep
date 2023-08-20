<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Teste de php</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
</head>
<h1 class="text-center"> Busca CEP </h1>

<div class="container">
	<form action="" method="POST">
			<input class='form-control' type="text" name='cep' id="cep" placeholder="Digite aqui o cep !">
			<button type="submit" class="botao btn btn-primary mt-3"> Procurar CEP </button>
		</form>
</div>


<?php

function getInformacaoCep(string $cep): array{

	function tratar_response(string $response): array{
		return json_decode($response, true);
	}


	$url = "https://viacep.com.br/ws/" . $cep . "/json/";
	$r = file_get_contents($url);
	return tratar_response($r);
}

function isCepValido(string $cep): int{
	// retorna 1 se cep e vaslido e 0 caso contrario 
	$patternCep = "/\d{5}-?\d{3}/";
	return preg_match($patternCep, $cep);
}
?>

<table class="table">
<?php
// Lógica da página

	if ($_SERVER['REQUEST_METHOD'] == 'POST'){

		$cep = $_POST['cep'];

		if (isCepValido($cep))
		{
			$cepTratado = str_replace('-', '', $cep);

			try{ 
				$infoCep =  getInformacaoCep($cepTratado);
					foreach ($infoCep as $chave => $valor)
					{
						echo "<tr><td> " . $chave . " : " .  $valor .  " </tr></td>";
					}
	
			} catch (Exception $e)  {
				echo "Não foi possivel concluir a ação! " . $e->getMessage();
			}
		}
		else 
		{
			echo '<script src="aviso.js" ></script>';
		}
	}
	?>
</table>

<style>
	.container{
		padding: 100px;
	}
	form{
		display: flex-box;
		padding: 5px;
		justify-content: center;
	}
	input{
		height: 100%;
		width: 100%;
	}
	.botao{
		width: 100%;
	}
	table{
		padding-inline: 500px;
	}
</style>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></>
</html>
