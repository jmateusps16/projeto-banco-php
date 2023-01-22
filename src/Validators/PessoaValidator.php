<?php

namespace App\Validators;

class PessoaValidator extends BaseValidator {
    function validar(): PessoaValidator {
        try {
            switch($this->options['mode']) {
                case 'change':
                    if (key_exists("id", $this->content)) {
                        if (!((int) $this->content["id"] > 0)) $this->setError("id", "id inválido");
                    }

                    else $this->setError("id", "id não informado");
                case 'create':
                    if (key_exists("documento", $this->content)) {
                        if (strlen($this->content["documento"]) < 10) $this->setError("documento", "documento inválido");
                    } 
                    
                    else $this->setError("documento", "documento não informado");

                    if (key_exists("endereco_id", $this->content)) {
                        if (!(((int) $this->content["endereco_id"]) > 0)) $this->setError("endereco_id", "endereco_id inválido");
                    } 
                    
                    else $this->setError("endereco_id", "endereco_id não informado");

                    if (key_exists("nome", $this->content)) {
                        if (strlen($this->content["nome"]) < 5) $this->setError("nome", "nome inválido");
                    } 
                    
                    else $this->setError("nome", "nome não informado");

                    if (key_exists("tipo_pessoa", $this->content)) {
                        $tipo = ((int) $this->content["tipo_pessoa"]);
                        if (!($tipo == 1 || $tipo == 2)) $this->setError("tipo_pessoa", "tipo_pessoa inválido");
                    } 
                    
                    else $this->setError("tipo_pessoa", "tipo_pessoa não informado");
                    break;
            }
        }
        
        catch (\Throwable) {
            $this->setError("", "falha ao validar input");
        }

        return $this;
    }
}