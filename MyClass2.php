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
		return $this->foo . "\n";
	}

	//調用對象時執行, $myclass(213);
	//可用is_callable 來判斷 invoke fun 是否存在
	function __invoke($x) {
		echo "do invoke $x";
		$this->do_a();
	}

	function do_a()
	{
		$this->name = "張三";
	}
}

$myclass = new MyClass2('hello');
echo $myclass . "\n";
var_dump($myclass);

//可通過 echo / printf 出書 toString
//printf 只接受字串型態
printf("class to string :%s\n", $myclass);


//調用fun 方式來調用類別就會執行 __invoke
$myclass(123);
var_dump($myclass);
var_dump(is_callable($myclass));
