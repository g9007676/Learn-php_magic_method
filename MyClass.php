<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
class MyClass
{

	private $data = array();

	//寫入屬性時，自動跳用此函式
	function __set($k, $v)
	{
		echo "Setting Data\n";
		$this->data[$k] = $v;
	}

	//讀取屬性時，自動跳用此函式 // 除了 isset()
	function __get($k)
	{
		echo "Getting Data\n";
		return $this->data[$k];
	}

	//use isset() / empty() 自動調用此函式
	function __isset($name)
	{
		echo "is '$name' set?\n";
		return isset($this->data[$name]);
	}

	function __unset($name)
	{
		echo "Unsetting '$name'\n";
		unset($this->data[$name]);
	}

	//實體化呼叫
	public function __call($name, $arguments)
	{
		echo "Calling object method '$name' "
			. implode(', ', $arguments). "\n";
	}

	//靜態方法呼叫
	// 5.3 支援
	public static function __callStatic($name, $arguments)
	{
		echo "Calling static method '$name' "
			. implode(', ', $arguments). "\n";
	}
}

$myclass = new MyClass();
$myclass->email = '123'; //調用 __set
$email = $myclass->email; //調用 __get
echo $myclass->email; //調用 __get

isset($myclass->email); //調用 __isset
empty($myclass->email);//調用 __get __isset
is_null($myclass->email);// 調用 __get


unset($myclass->email);// 調用 __unset
$myclass->email = null;// 調用 __get


$myclass->runTest('in object context');

$myclass::runTest('in static object context');
