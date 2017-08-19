<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TFILTER
 *
 * @author erivelton
 */
class TFilter extends TExpression {

    private $variable;
    private $operador;
    private $value;

    public function __construct($variable, $operador, $value) {
        $this->variable = $variable;
        $this->operador = $operador;
        $this->value = $this->transform($value);
    }

    private function transform($value) {
        if (is_array($value)) {
            foreach ($value as $temp) {
                if (is_integer($temp)) {
                    $foo[] = $temp;
                } else if (is_string($temp)) {
                    $foo[] = "'$temp'"; // adiciona aspas
                }
            }
            // converte o array em uma string separa por virgulas
            $result = '(' . implode(',', $foo) . ')';
        } else if (is_string($value)) {
            $result = "'$value'";
        } else if (is_null($value)) {
            $result = 'NULL';
        } else if (is_bool($value)) {
            $result = $value ? 'TRUE' : 'FALSE';
        }
        else
            $result = $value;

        return $result;
    }

    public function dump() {
        return "{$this->variable} {$this->operador} {$this->value}";
    }

}

?>
