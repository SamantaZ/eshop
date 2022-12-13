<?php
require "model.php";
class Product extends Model
{
    public $sku;
    public $name;
    public $price;
    public $type_id;

    public $table = 'products';
    public $modelName = 'Product';
    public $singularName = 'product';

    protected $_schema = array('id', 'sku', 'name', 'price', 'type_id', 'created');
    public $belongsTo = array('ProductType' => array('className' => 'ProductType', 'foreignKey' => 'type_id'));
    public $hasMany = array(
        'Dvd' => array('className' => 'Dvd', 'foreignKey' => 'product_id'),
        'Book' => array('className' => 'Book', 'foreignKey' => 'product_id'),
        'Furniture' => array('className' => 'Furniture', 'foreignKey' => 'product_id'),
    );

}

class ProductType extends Model
{
    public $name;

    public $table = 'product_types';
    public $modelName = 'ProductType';
    public $singularName = 'producttype';

    protected $_schema = array('id', 'name');
}

class Dvd extends Product
{
    public $size;
    public $product_id;

    public $table = 'dvd_attributes';
    public $modelName = 'Dvd';
    public $singularName = 'dvd';
    protected $_schema = array('id', 'size', 'product_id');
    protected $_attributes = array('size'=>array('type'=>'number', 'unit'=>'MB'));
    public $belongsTo = array('Product' => array('className' => 'Product', 'foreignKey' => 'product_id'));
}

class Book extends Product
{
    public $weight;
    public $product_id;
    public $table = 'book_attributes';
    public $modelName = 'Book';
    public $singularName = 'book';
    protected $_schema = array('id', 'weight', 'product_id');
    protected $_attributes = array('weight'=>array('type'=>'number', 'unit'=>'kg'));
    public $belongsTo = array('Product' => array('className' => 'Product', 'foreignKey' => 'product_id'));
}

class Furniture extends Product
{
    public $height;
    public $length;
    public $width;
    public $product_id;
    public $table = 'furniture_attributes';
    public $modelName = 'Furniture';
    public $singularName = 'furniture';
    protected $_schema = array('id', 'width', 'height', 'length', 'product_id');
    protected $_attributes = array('width'=>array('type'=>'number', 'unit'=>'cm'), 'height'=>array('type'=>'number', 'unit'=>'cm'), 'length'=>array('type'=>'number', 'unit'=>'cm'));
    public $belongsTo = array('Product' => array('className' => 'Product', 'foreignKey' => 'product_id'));
}