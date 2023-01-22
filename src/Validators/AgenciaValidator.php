<?php

namespace App\Validators;

class AgenciaValidator extends BaseValidator {
    function validar(): AgenciaValidator {
        try {
            switch ($this->options["mode"]) {
                case "change":
                    if (key_exists("id", $this->content)) {
                        if (!((int) $this->content["id"] > 0)) $this->setError("id", "id não informado");
                    } 
                    else $this->setError("id", "endereco não informado");
                    //se não tem break ele entra no proximo case.
                case "create":
                    if (key_exists("user_id", $this->content)) {
                        if (!((int) $this->content["user_id"] > 0)) $this->setError("user_id", "user_id não informado");
                    } 
                    
                    else $this->setError("user_id", "user_id não informado");

                    if (key_exists("endereco_id", $this->content)) {
                        if (!((int) $this->content["endereco_id"] > 0)) $this->setError("endereco_id", "não informado");
                    } 
                    
                    else $this->setError("endereco_id", "endereco não informado");
        
                    if (key_exists("gerente_id", $this->content)) {
                        if (!((int) $this->content["gerente_id"] > 0)) $this->setError("gerente_id", "gerente não informado");
                    } 
                    
                    else $this->setError("gerente_id", "gerente não informado");
                    break;
            }

        }
        
        catch (\Throwable) {
            $this->setError("", "falha ao validar input");
        }

        return $this;
    }
}