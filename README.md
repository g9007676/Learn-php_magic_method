# php_magic_method

## 學習 php 魔術方法





-------------------------------
```php
class MyClass
{

	public $name;
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

	//序列化時如果存在 __sleep，自動調用
	//序列化資料時，可以保存屬性
	//必須回傳陣列資料
	//不可帶入值
	function __sleep()
	{
		return array('data', 'name');
	}

	//反序列化後執行
	function __wakeup()
	{
		$this->name = 'aa';
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

$myclass->name = "3212321";
var_dump($myclass);

$serialize_class = serialize($myclass);// 屬性 name 序列化前保存在資料裡
var_dump($serialize_class);
$class = unserialize($serialize_class);
var_dump($class);
```
