<?php
require "Controller/ProductsController.php";

if (isset($_POST)) {
    $className = $_POST['productType']['name'];
    $model = new $className();
    $model->displayAttributes();
}