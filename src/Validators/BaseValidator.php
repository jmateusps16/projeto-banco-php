<?php

namespace App\Validators;

class BaseValidator {
    protected array $content = [];
    public array $errors = [];
    protected array $options = [];

    function __construct(array $json, array $options)
    {
        $this->content = $json;
        $this->options = $options;
    }

    function setError(string $field, string $message): void {
        array_push($this->errors, [ "field" => $field, "message" => $message ]);
    }

    function validar(): BaseValidator {
        return $this;
    }

    function falha(): bool {
        return count($this->errors) > 0;
    }

    static function obter(array $json, string $className, array $options = []): BaseValidator {
        return (new $className($json, $options))->validar();
    }
}