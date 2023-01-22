<?php

namespace App\Validators;

class SolicitacaoValidator extends BaseValidator {

    function validarAberturaConta() {
        if (key_exists('nome', $this->content)) {
            if (strlen($this->content['nome']) < 4)
                $this->setError("nome", "nome do deve ser maior que 4 caracteres");
        }

        else $this->setError("nome", "nome do usuario não informado");

        if (key_exists('tipo_pessoa', $this->content)) {
            if (!is_int($this->content['tipo_pessoa']))
                $this->setError("tipo_pessoa", "tipo_pessoa deve ser inteiro");
            else {
                if (!in_array($this->content['tipo_pessoa'], [1, 2]))
                    $this->setError("tipo_pessoa", "tipo_pessoa de pessoa inválido");
            }
        }

        else $this->setError("tipo_pessoa", "tipo_pessoa do usuario não informado");

        if (key_exists('tipo_conta', $this->content)) {
            if (!is_int($this->content['tipo_conta']))
                $this->setError("tipo_conta", "tipo_conta deve ser inteiro");
            else {
                if (!in_array($this->content['tipo_conta'], [1, 2, 3]))
                    $this->setError("tipo_conta", "tipo_conta de pessoa inválido");
            }
        }

        else $this->setError("tipo_conta", "tipo_conta do usuario não informado");

        if (key_exists('documento', $this->content)) {
            if (strlen($this->content['documento'] < 8))
                $this->setError("documento", "documento muito curto");
        }

        else $this->setError("documento", "documento do usuario não informado");

        if (key_exists('codigo_endereco', $this->content)) {
            if (!is_int($this->content['codigo_endereco']))
                $this->setError("codigo_endereco", "codigo_endereco deve ser inteiro");
        }

        else $this->setError("codigo_endereco", "codigo_endereco do usuario não informado");
    }

    function validateType() {
        if (is_int($this->content['tipo']) == false) { 
            $this->setError("tipo", "tipo da solicitacao deve ser inteiro");
            return;
        }

        switch ($this->content['tipo']) {
            case 1:
                $this->validarAberturaConta();
                break;
        }
    }

    function validar(): SolicitacaoValidator {
        try {
            switch($this->options['mode']) {
                case 'change':
                    if (key_exists("id", $this->content)) {
                        if (!((int) $this->content["id"] > 0)) $this->setError("id", "id inválido");
                    }

                    else $this->setError("id", "id não informado");
                case 'create':
                    if (key_exists('codigo_agencia', $this->content)) {
                        if (!is_int($this->content['codigo_agencia']))
                            $this->setError("codigo_agencia", "codigo_agencia deve ser inteiro");
                    }
                    else $this->setError("codigo_agencia", "codigo_agencia deve ser informado");

                    if (key_exists('tipo', $this->content))
                    { $this->validateType(); }
                    else 
                    { $this->setError("tipo", "tipo da solicitacao não informado"); }
                    
                    break;
            }
        }
        
        catch (\Throwable $error) {
            $this->setError("", "falha ao validar input");
        }

        return $this;
    }
}