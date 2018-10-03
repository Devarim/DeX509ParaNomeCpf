<?php 
class DeX509ParaNomeCpf {

    private function fromHex($hex) {
        $retorno = "";
        foreach(str_split($hex, 3) as $c) {
            $retorno .= hex2bin(str_replace(" ","",$c)); 
        }
        return $retorno;
    }

    private function certToHex($cert) {
        $val = unpack("C*an",$cert);
    
        $retornoHex = "";
        foreach($val as $valor) {
            $hex = bin2hex(chr($valor));
            $retornoHex .= $hex." ";
        }
        return $retornoHex;
    }

    private function obterNome($nome) {
        preg_match('/(06 03 55 04 03 13 .. (?P<nome>.*))/', $nome, $retornoHex);
    
        $nome = $this->fromHex($retornoHex["nome"]);
    
        if(preg_match('/[^\x20-\x7f]/', $nome)) $nome = $this->obterNome($retornoHex["nome"]);
    
        return $nome;
    }

    private function obterNomeCpf($certHex) {
        preg_match('/(06 03 55 04 03 13 .. (?P<nome>.*)3a (?P<cpf>.*) .. 82 01 22 )/', $certHex, $retornoHex);
    
        $cpf = $this->fromHex($retornoHex["cpf"]);
        $nome = $this->fromHex($retornoHex["nome"]);
    
        if(preg_match('/[^\x20-\x7f]/', $nome)) $nome = $this->obterNome($retornoHex["nome"]);
        
        return [ 
            "nome" => $nome, 
            "cpf" => $cpf 
        ];
    }

    public function obterDeArquivo($arquivo) {
        return $this->obterDeCertificado(file_get_contents($arquivo));
    }

    public function obterDeCertificado($certificado) {
        return $this->obterNomeCpf($this->certToHex(base64_decode($certificado)));
    }
}
