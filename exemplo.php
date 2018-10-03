<?php 

// Importe o arquivo
include('DeX509ParaNomeCpf.php');

$exemploDeArquivo = (new DeX509ParaNomeCpf())->obterDeArquivo('cadeiacert.1');
print_r($exemploDeArquivo);
// Array
// (
//     [nome] => EXEMPLO DE USUARIO
//     [cpf] => 55555555555
// )

$exemploDeCetificado = (new DeX509ParaNomeCpf())->obterDeCertificado(file_get_contents('cadeiacert.1'));
print_r($exemploDeCetificado);
// Array
// (
//     [nome] => EXEMPLO DE USUARIO
//     [cpf] => 55555555555
// )
