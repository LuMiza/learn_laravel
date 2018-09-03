<?php 

	class UserController
	{
		public function add()
		{

		}

		public function index(Request $request, DB $db)
		{
			$request->all();
			$request->only();
			$db -> get();
		}
	}

	class Request
	{
		public function all()
		{
			echo '获取所有的参数....<hr>';
		}

		public function only()
		{
			echo '获取部分参数.....<hr>';
		}
	}

	class DB
	{
		public function get()
		{
			echo '获取所有的结果集...<hr>';
		}
	}

	// $request = new Request;
	//利用php的反射机制
	// $request = new ReflectionClass('Request');
	// $obj = $request->newInstance();

	//声明方向
	$className = 'UserController';
	$methodName = 'index';

	//创建反射对象
	$class = new ReflectionClass($className);
	$method = new ReflectionMethod($className, $methodName);

	//获取当前方法的参数列表
	$params = $method->getParameters();

	// $cnames = [];
	//执行方法时的参数列表
	$args = [];
	foreach ($params as $key => $value) {
		// $cnames[] = $value->getClass()->getName();
		$args[] = (new ReflectionClass($value->getClass()->getName())) -> newInstance();
	}

	//执行指定方法中的代码 index
	$method->invokeArgs($class->newInstance(), $args);

 ?>