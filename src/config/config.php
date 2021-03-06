<?php

date_default_timezone_set('America/Sao_Paulo');
setlocale(LC_TIME, 'pt_BR', 'pt_BR.uft-8', 'portuguese');

//Constantes gerais
define('DAILY_TIME', 60 * 60 * 8);

//Pastas
define('CONFIG_PATH', realpath(dirname(__FILE__)));
define('MODEL_PATH', CONFIG_PATH . '/../models');
define('VIEW_PATH', CONFIG_PATH . '/../views');
define('TEMPLATE_PATH', CONFIG_PATH . '/../views/template');
define('CONTROLLER_PATH', CONFIG_PATH . '/../controllers');
define('EXCEPTION_PATH', CONFIG_PATH . '/../exceptions');

//Arquivos
require_once(CONFIG_PATH . '/database.php');
require_once(CONFIG_PATH . '/loader.php');
require_once(CONFIG_PATH . '/session.php');
require_once(CONFIG_PATH . '/date_utils.php');
require_once(CONFIG_PATH . '/utils.php');
require_once(realpath(MODEL_PATH . '/Model.php'));
require_once(realpath(MODEL_PATH . '/User.php'));
require_once(realpath(MODEL_PATH . '/WorkingHours.php'));
require_once(realpath(EXCEPTION_PATH . '/AppException.php'));
require_once(realpath(EXCEPTION_PATH . '/ValidationException.php'));
