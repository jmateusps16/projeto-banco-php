<?php

namespace App\Validators;

class UserValidator extends BaseValidator {
    function validar(): UserValidator {
        try {
            switch($this->options['mode']) {
                case 'change':
                    if (key_exists("id", $this->content)) {
                        if (!((int) $this->content["id"] > 0)) $this->setError("id", "id inválido");
                    }

                    else $this->setError("id", "id não informado");
                case 'create':
                    if (key_exists("email", $this->content)) {
                        if (strlen($this->content["email"]) < 3) $this->setError("email", "email inválido");
                    } 
                    
                    else $this->setError("email", "email não informado");

                    if (key_exists("pessoa", $this->content)) {
                        if (strlen($this->content["pessoa"]) == 0) $this->setError("pessoa", "pessoa inválido");
                    } 
                    
                    else $this->setError("pessoa", "pessoa não informado");
                    break;
            }
        }
        
        catch (\Throwable) {
            $this->setError("", "falha ao validar input");
        }

        return $this;
    }
}