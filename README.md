# php_magic_method

## 學習 php 魔術方法




* __set __get
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
}
$myclass = new MyClass();
$myclass->email = '123'; //調用 __set
$email = $myclass->email; //調用 __get
echo $myclass->email; //調用 __get
```


* __isset __unset
-------------------------------
```php
class MyClass
{
    public $name = 'james';

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
}
isset($myclass->email); //調用 __isset
empty($myclass->email);//調用 __get __isset
is_null($myclass->email);// 調用 __get


unset($myclass->email);// 調用 __unset
$myclass->email = null;// 調用 __get
```


* __call __callStatic
-------------------------------
```php
// __call __callStatic 呼叫方法不存在時執行
class MyClass
{
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
$myclass->runTest('in object context');
$myclass::runTest('in static object context');
```

* __sleep __wakeup
-------------------------------
```php
class MyClass
{
    public $data = array('a');
    public $name = 'james'
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
$myclass->name = "test";
var_dump($myclass);

$serialize_class = serialize($myclass);// 屬性 name 序列化前保存在資料裡
var_dump($serialize_class);
$class = unserialize($serialize_class);
var_dump($class);
```
* __toString __invoke
-------------------------------
```php
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
```

* __clone
-------------------------------
```php
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
```
