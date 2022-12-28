<?php
require "Model/product.php";
class ProductsController
{
    public function get()
    {
        try {

            $product = new Product();
            $data = $product->get();
            return $data;
        } catch (Error $e) {
            echo  $e->getMessage();
        }
    }

    public function delete($data)
    {
        try {
            $product = new Product();
            $data = $product->delete($data);
            header("Location:index.php");
        } catch (Error $e) {
            echo  $e->getMessage();
        }
    }

    public function add($product)
    {
        try {
            $product = new Product();
            $product->add($product);
            header("Location:index.php");
        } catch (Error $e) {
            echo  $e->getMessage();
        }
    }

    public function getProductTypes()
    {
        try {
            $productType = new ProductType();
            $data = $productType->get();
            return $data;
        } catch (Error $e) {
            echo  $e->getMessage();
        }
    }

    public function fetchAttributes($className)
    {
        try {
            $model = new $className();
            return  $model->displayAttributes();
        } catch (Error $e) {
            echo  $e->getMessage();
        }
    }
}
