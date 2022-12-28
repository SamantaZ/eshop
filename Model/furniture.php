<?php
require "model.php";
class Furniture extends Product
{
    public $table = 'furniture_attributes';
    public $modelName = 'Furniture';
    public $singularName = 'furniture';
    protected $_schema = array('id', 'width', 'height', 'length', 'product_id');
    protected $_attributes = array('width'=>array('type'=>'number', 'unit'=>'cm'), 'height'=>array('type'=>'number', 'unit'=>'cm'), 'length'=>array('type'=>'number', 'unit'=>'cm'));
    public $belongsTo = array('Product' => array('className' => 'Product', 'foreignKey' => 'product_id'));
}