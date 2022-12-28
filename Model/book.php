<?php
require "model.php";

class Book extends Product
{
    public $table = 'book_attributes';
    public $modelName = 'Book';
    public $singularName = 'book';
    protected $_schema = array('id', 'weight', 'product_id');
    protected $_attributes = array('weight'=>array('type'=>'number', 'unit'=>'kg'));
    public $belongsTo = array('Product' => array('className' => 'Product', 'foreignKey' => 'product_id'));
}