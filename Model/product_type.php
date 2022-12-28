<?php
require "model.php";
class ProductType extends Model
{
    public $table = 'product_types';
    public $modelName = 'ProductType';
    public $singularName = 'producttype';

    protected $_schema = array('id', 'name');
}