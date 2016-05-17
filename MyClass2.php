<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
class MyClass2
{
	public $foo;
	function __construct($v)
	{
		$this->foo = $v;
	}

	function __toString()
	{
		return $this->foo;
	}
}

$myclass = new MyClass2('hello');
echo $myclass . "\n";
var_dump($myclass);

//可通過 echo / printf 出書 toString
//printf 只接受字串型態
printf("class to string :%s, %d", $myclass);
