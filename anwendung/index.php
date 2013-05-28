<?php

// include the MVC
include('mvc/controller.php');
include('mvc/model.php');
include('mvc/view.php');

$request = array_merge($_GET, $_POST);

// create controller
$controller = new Controller($request);

// display content of controller
echo $controller->display();

?>