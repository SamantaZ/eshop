<?php
require "Model/product.php";
class ProductsController
{
    public function get()
    {
        try {

            $this->Product = new Product();
            $data = $this->Product->get();
            return $data;
        } catch (Error $e) {
            echo  $e->getMessage();
        }
    }

    public function delete($data)
    {
        try {
            $this->Product = new Product();
            $data = $this->Product->delete($data);
            header("Location:index.php");
        } catch (Error $e) {
            echo  $e->getMessage();
        }
    }

    public function add($product)
    {
        try {
            $this->Product = new Product();
            $data = $this->Product->add($product);
            header("Location:index.php");
        } catch (Error $e) {
            echo  $e->getMessage();
        }
    }

    public function getProductTypes()
    {
        try {
            $this->ProductType = new ProductType();
            $data = $this->ProductType->get();
            return $data;
        } catch (Error $e) {
            echo  $e->getMessage();
        }
    }
}