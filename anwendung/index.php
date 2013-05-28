<?php

// include the MVC
include('controller/controller.php');
include('model/model.php');
include('view/view.php');

$request = array_merge($_GET, $_POST);

// create controller
$controller = new Controller($request);

// display content of controller
echo $controller->display();

?>