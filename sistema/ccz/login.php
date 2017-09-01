<?php
session_start();
/*
 * constants
 */
require_once '/config/TConfig.php';

/*
 *  session
 */
require_once 'libs/Autoloader.php';


$loader = new Autoloader();
$loader->directories = array('libs');
$loader->register();

/*
 * header
 */
header('Content-Type: text/html; charset=utf-8');
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', dirname(__FILE__) . '/log/log.txt');
ini_set('error_reporting', E_ALL ^ E_NOTICE);


// recebe as variáveis para login
$loginusuario = (isset($_POST['loginusuario']) ? $_POST['loginusuario'] : NULL);
$senhausuario = (isset($_POST['senhausuario']) ? $_POST['senhausuario'] : NULL);

/*
 *  inicia a conexão se necessário
 */
TDBConnection::getConnection();

// verifica credenciais do login do usuario
TDBConnection::beginTransaction();
TDBConnection::prepareQuery("select * from user
                    where 1 = 1 and
                        user.isOut = 'N' and 
                       user.password = MD5( CONCAT('erivelton', :senha_param, MD5(:login_param) ) ) and
                       (user.login = :login_param);");
TDBConnection::bindParamQuery(':senha_param', $senhausuario, PDO::PARAM_STR);
TDBConnection::bindParamQuery(':login_param', $loginusuario, PDO::PARAM_STR);
$result = TDBConnection::single();
$nRows = TDBConnection::rowCount();
TDBConnection::endTransaction();

//**************************************************************
//************************************VALIDA O LOGIN OU EMAIL***
//**************************************************************

if ($nRows == 1) { // aceitou o login

    /*     * ********************INICIA A SESSAO******************** */
    /*     * ******************************************************* */
    $_SESSION['sessao_usuario_id'] = (isset($result->id) ? $result->id : NULL);
    $_SESSION['sessao_usuario_name'] = (isset($result->name) ? $result->name : NULL);
    $_SESSION['sessao_usuario_login'] = (isset($result->login) ? $result->login : NULL);
    $_SESSION['sessao_usuario_profile_id'] = (isset($result->profile_id) ? $result->profile_id : NULL);


    echo 1;
} else {
    echo 0;
}







