<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of tapp
 * controladora
 *
 * @author erivelton
 */
class TApp {

    private $object; //transaction object
    private $method;
    private $params = null;

    public function __construct() {

        /* @var $url type string - recebe o */ /*
         * tratamento da a url
         * carro-de-corrida/velocidade-maxima/10
         * vira
         * CarroDeCorrida/VelocidadeMaxima/10
         * 
         */

        $url = (isset($_GET['url']) ? $_GET['url'] : NULL);

        if ($url) {
            /*
             * $urlArrayTemp = temporary array to keep all methods to be executed
             * index 0 = object type string
             * index 1 = method type string
             * posicao 2..n = params, sendo eles retornados como vetor
             */
            $urlArrayTemp = explode('/', $url);

            /*
             * Processa o valor do object
             * transforma
             * carro-de-corrida
             * CarroDeCorrida 
             */
            if (isset($urlArrayTemp[0])) {

                $object = explode('-', strtolower($urlArrayTemp[0]));

                $objectTemp = '';
                foreach ($object as $value) {
                    $objectTemp .= (strtoupper(substr($value, 0, 1))) . substr($value, 1);
                }

                $this->object = $objectTemp;
            }
            /*
             *  Processa o method a ser chamado
             */
            if (isset($urlArrayTemp[1])) {

                $method = explode('-', strtolower($urlArrayTemp[1]));

                $methodTemp = '';
                /*
                 * transformar
                 * velocidade-maxima
                 * velocidadeMaxima
                 */

                foreach ($method as $k => $value) {
                    if ($k === 0) {
                        $methodTemp .= $value;
                    } else {
                        $methodTemp .= (strtoupper(substr($value, 0, 1))) . substr($value, 1);
                    }
                }

                $this->method = $methodTemp;
            }

            /*
             * alocando os params dentro de um vetor
             * cada célula conterá um valor do atributo, na sequencia de acordo
             * com o método
             */
            unset($urlArrayTemp[0]);
            unset($urlArrayTemp[1]);

            $this->params = $urlArrayTemp;
// debug
//            print_r($urlArrayTemp);
        } else {

            // força um chamado caso a url seja inválida
            $this->object = 'TPageHome';
            $this->method = 'execute';
            $this->params = NULL; // array nula
        }
    }

    public function executar() {

        //if (in_array($this->object, get_declared_classes())) {
        if (class_exists($this->object, true)) {
            try {
                $objectTemp = new $this->object();
                // if (method_exists($objectTemp, $this->method)) 
                if (is_callable(array($objectTemp, $this->method))) {
                    if ($this->params !== NULL) {
                        $objectTemp->{$this->method}($this->params);
                    } else {
                        $objectTemp->{$this->method}();
                    }
                } else {
                    // caso o metodo não existe
                    echo "<div class=\"alert alert-warning\">";
                    echo "    <strong>Erro</strong> Método não existe.";
                    echo "</div>";
                }
            } catch (Exception $ex) {
                echo $ex->getTraceAsString();
            }
        } else {
            // se o objeto nao existe
            echo "<div class=\"alert alert-warning\">";
            echo "    <strong>Erro</strong> Classe $this->object não existe.";
            echo "</div>";
        }
    }

}

?>
