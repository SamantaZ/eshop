<?php
require "model.php";

class Dvd extends Product
{
    public $table = 'dvd_attributes';
    public $modelName = 'Dvd';
    public $singularName = 'dvd';
    protected $_schema = array('id', 'size', 'product_id');
    protected $_attributes = array('size'=>array('type'=>'number', 'unit'=>'MB'));
    public $belongsTo = array('Product' => array('className' => 'Product', 'foreignKey' => 'product_id'));
}