<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TExpression
 *
 * @author erivelton
 */
abstract class TExpression {

    const AND_OPERATOR = 'AND';
    const OR_OPERATOR = 'OR';

    abstract public function dump();
}

?>
