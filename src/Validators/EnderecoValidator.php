<?php

namespace App\Validators;

class EnderecoValidator extends BaseValidator {
    function validar(): EnderecoValidator {
        try {
            switch($this->options['mode']) {
                case 'change':
                    if (key_exists("id", $this->content)) {
                        if (!((int) $this->content["id"] > 0)) $this->setError("id", "id inválido");
                    }

                    else $this->setError("id", "id não informado");
                case 'create':
                    if (key_exists("cep", $this->content)) {
                        if (strlen($this->content["cep"]) < 8) $this->setError("cep", "cep inválido");
                    } 
                    
                    else $this->setError("cep", "cep não informado");
                    break;
            }
        }
        
        catch (\Throwable) {
            $this->setError("", "falha ao validar input");
        }

        return $this;
    }
}