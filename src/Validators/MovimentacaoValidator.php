<?php

namespace App\Validators;

class MovimentacaoValidator extends BaseValidator {
    function validar(): MovimentacaoValidator {
        try {
            switch ($this->options["mode"]) {
                case "change":
                    if (key_exists("id", $this->content)) {
                        if (!((int) $this->content["id"] > 0)) $this->setError("id", "id não informado");
                    } 
                    else $this->setError("id", "id não informado");
                    //se não tem break ele entra no proximo case.
                case "create":
                    if (key_exists("conta_id", $this->content)) {
                        if (!((int) $this->content["conta_id"] > 0)) $this->setError("conta_id", "conta_id não informado");
                    } 
                    
                    else $this->setError("conta_id", "conta_id não informado");

                    if (key_exists("conta_destino_id", $this->content)) {
                        if (!((int) $this->content["conta_destino_id"] > 0)) $this->setError("conta_destino_id", "conta_destino_id não informado");
                    } 
                    
                    else $this->setError("conta_destino_id", "conta_destino_id não informado");
        
                    if (key_exists("status", $this->content)) {
                        $type = (int) $this->content["status"];
                        if (!in_array($type, [1, 2])) $this->setError("status", "status não informado");
                    }
                    
                    else $this->setError("status", "status não informado");

                    if (key_exists("tipo", $this->content)) {
                        $type = (int) $this->content["tipo"];
                        if (!in_array($type, [1, 2, 3])) $this->setError("tipo", "tipo não informado");
                    }
                    
                    else $this->setError("tipo", "tipo não informado");

                    if (key_exists("valor", $this->content)) {
                        $val = (float) $this->content["valor"];
                        if (!($val > 0)) $this->setError("valor", "valor não informado");
                    }
                    
                    else $this->setError("valor", "valor não informado");
                    break;
                case "create1":
                    if (key_exists("conta_id", $this->content)) {
                        if (!((int) $this->content["conta_id"] > 0)) $this->setError("conta_id", "conta_id não informado");
                    } 
                    
                    else $this->setError("conta_id", "conta_id não informado");
        
                    if (key_exists("status", $this->content)) {
                        $type = (int) $this->content["status"];
                        if (!in_array($type, [1, 2])) $this->setError("status", "status não informado");
                    }
                    
                    else $this->setError("status", "status não informado");

                    if (key_exists("tipo", $this->content)) {
                        $type = (int) $this->content["tipo"];
                        if (!in_array($type, [1, 2, 3])) $this->setError("tipo", "tipo não informado");
                    }
                    
                    else $this->setError("tipo", "tipo não informado");

                    if (key_exists("valor", $this->content)) {
                        $val = (float) $this->content["valor"];
                        if (!($val > 0)) $this->setError("valor", "valor não informado");
                    }
                    
                    else $this->setError("valor", "valor não informado");
                    break;
            }

        }
        
        catch (\Throwable) {
            $this->setError("", "falha ao validar input");
        }

        return $this;
    }
}