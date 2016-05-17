<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
class MyClass3
{
	static  $instances = 0;

	function __construct()
	{
		$this->instance = ++self::$instances;
	}

	public function __clone()
	{
		echo "do clone Myclass\n";
		$this->instance = ++self::$instances;
	}
}

class MyCloneable
{
	public $obj_1;
	public $obj_2;

	public function __clone()
	{
		echo "do clone Myclone\n";
		$this->obj_1 = clone $this->obj_1;
		$this->obj_2 = clone $this->obj_2;
	}
}

$myclone = new MyCloneable();

$myclone->obj_1= new MyClass3();
$myclone->obj_2= new MyClass3();


//複製MyCloneable 完成後，會呼叫 __clone
//MyCloneable __clone 做了clone 兩個屬性
//因obj_1 obj_2 是 MyClass3
//然後 MyClass3 也因為MyCloneable 使用 clone
//因此也做了MyClass3 __clone
$obj = clone $myclone;
var_Dump($obj);
