<?php

namespace App\Validators;

class ContaValidator extends BaseValidator {
    function validar(): ContaValidator {
        try {
            switch ($this->options["mode"]) {
                case "change":
                    if (key_exists("id", $this->content)) {
                        if (!((int) $this->content["id"] > 0)) $this->setError("id", "id não informado");
                    } 
                    else $this->setError("id", "id não informado");
                    //se não tem break ele entra no proximo case.
                case "create":
                    if (key_exists("agencia_id", $this->content)) {
                        if (!((int) $this->content["agencia_id"] > 0)) $this->setError("agencia_id", "não informado");
                    } 
                    
                    else $this->setError("agencia_id", "agencia id não informado");
        
                    if (key_exists("tipo_conta", $this->content)) {
                        $type = (int) $this->content["tipo_conta"];
                        if (!in_array($type, [1, 2, 3])) $this->setError("tipo_conta", "tipo_conta não informado");
                    }
                    
                    else $this->setError("tipo_conta", "tipo da conta não informado");
                    break;
            }

        }
        
        catch (\Throwable) {
            $this->setError("", "falha ao validar input");
        }

        return $this;
    }
}