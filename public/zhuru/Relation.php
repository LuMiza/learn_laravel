<?php
/***
 * php对象注入
 */

namespace Plugins;


class Relation
{
    /**
     * @var $_reflectionClass 反射对象实例
     */
    private $_reflectionClass = null;

    /**
     * @var $_methodClass 当前反射对象的ReflectionMethod的实例
     */
    private $_methodClass = null;

    /**
     * @var $_className 当前反射对象的类名
     */
    private $_className = null;

    /**
     * @var $_methodName 方法名
     */
    private $_methodName = null;

    /**
     * 创建反射对象
     * @param $className 类名
     * @return ReflectionClass
     * @throws ReflectionException
     */
    public  function __construct($className, $methodName)
    {
        $this->_className = $className;
        $this->_methodName = $methodName;
        $this->_reflectionClass = new \ReflectionClass($this->_className);
        return $this->_reflectionClass;
    }

    /**
     * 最终实现类的注入
     */
    public function invoke()
    {
        $this->instanceMethod();
        $this->instanceParam();
    }

    /**
     * 获取反射对象的所有方法
     */
    private function getMethods()
    {
        return $this->_reflectionClass->getMethods();
    }

    /**
     * 判断当前反射对象中是否存在该方法
     * @param $method 方法名
     * @return mixed
     */
    private function isClassMethod($method=null)
    {
        foreach ($this->getMethods() as $valObj) {
            if ( $valObj->getName()==$method ) {
                return true;
                break;
            }
        }
        return false;
    }

    /**
     * 创建当前反射对象的ReflectionMethod的实例
     * @return null|ReflectionMethod|当前反射对象的ReflectionMethod的实例
     * @throws ReflectionException
     */
    private  function instanceMethod()
    {
        if (!$this->isClassMethod($this->_methodName)) {
            return null;
        }
        $this->_methodClass = new \ReflectionMethod($this->_className, $this->_methodName);
        return $this->_methodClass;
    }

    /**
     * 实例化反射对象方法的参数是对象的  对象
     * @throws ReflectionException
     */
    private function instanceParam()
    {
        $args = [];
        foreach ($this->getParams() as $valObj) {
            if (is_object($valObj->getClass())) {
                //参数为对象
                $args[] = (new \ReflectionClass($valObj->getClass()->getName())) -> newInstance();
            } else {
                //参数为变量
                $args[] = $_GET[$valObj->getName()];
            }
        }
        $this->_methodClass->invokeArgs($this->_reflectionClass->newInstance(), $args);
    }

    /**
     * 获取反射对象方法的 参数列表
     * @return mixed  [Object]
     */
    private function getParams()
    {
        return $this->_methodClass->getParameters();
    }
}