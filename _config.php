<?php

//Directory Root
define('ROOT', dirname(__FILE__));

//HTML Path Root
define('base_path', str_replace(dirname(__DIR__), '', ROOT));

//Include our authentication helpers
include_once(ROOT . "/includes/_authentication_helpers.php");
define('ADMIN', is_admin());
define('AUTH', is_auth());

//Include our common helpers
include_once(ROOT . "/includes/_helpers.php");