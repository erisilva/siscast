<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TCriteria
 *
 * @author erivelton
 */
class TCriteria extends TExpression {

    private $expressions;
    private $operators;
    private $properties;

    function __construct() {
        $this->expressions = array();
        $this->operators = array();
    }

    public function add(TExpression $expression, $operator = self::AND_OPERATOR) {
        // na primeira vez, não precisamos de operador lógico para concatenar
        // força a não colocação do operator para primeira expressao
        if (empty($this->expressions)) {
            $operator = NULL;
        }

        // agrega o resultado da expressão à lista de expressões
        $this->expressions[] = $expression;
        $this->operators[] = $operator;
    }

    public function dump() {
        // concatena a lista de expressões
        if (is_array($this->expressions)) {
            if (count($this->expressions) > 0) {
                $result = '';
                foreach ($this->expressions as $i => $expression) {
                    $operator = $this->operators[$i];
                    // concatena o operador com a respectiva expressão
                    // (bruno > 24 OReri < 24)

                    $result .=  $operator . ' ' . $expression->dump() . ' ';

                }
                $result = trim($result);
                return "({$result})";
            }
        }
    }

    public function setProperty($property, $value) {
        if (isset($value)) {
            $this->properties[$property] = $value;
        } else {
            $this->properties[$property] = NULL;
        }
    }

    public function getProperty($property) {
        if (isset($this->properties[$property])) {
            return $this->properties[$property];
        }
    }

}

?>
