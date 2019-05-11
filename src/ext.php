<?php

abstract class RTExtension {
    public abstract function init(ExtensionHandler $handler);
    public abstract function before(DocBuilder $docBuilder);
    public abstract function after(DocBuilder $docBuilder);
    public abstract function applyProp(String $name, String $value, DocBuilder $docBuilder);
}
class ExtensionHandler
{
    private $prop_handler = array();
    private $prop_element = array();

    public function applyProp(String $name, String $value, DocBuilder $docBuilder) {
        if (isset($this->prop_handler[$name])) {
            $this->prop_handler[$name]->applyProp($name, $value, $docBuilder);
        }
    }
    public function registerProp(String $name, RTExtension $ext) {
        $this->prop_handler[$name] = $ext;
    }
    public function registerPropElement(String $elName, String $propName) {
        $this->prop_element[$elName] = $propName;
    }
    public function listPropElements()
    {
        return $this->prop_element;
    }
}

$extensionHandler = new ExtensionHandler();
$ext_objects = array();

function ext_exec_before(DocBuilder $docBuilder) {
    global $ext_objects;

    foreach ($ext_objects as $extObj) {
        $extObj->before($docBuilder);
    }
}
function ext_exec_after(DocBuilder $docBuilder) {
    global $ext_objects;

    foreach ($ext_objects as $extObj) {
        $extObj->after($docBuilder);
    }
}
function ext_apply_prop($name, $value, $docBuilder)
{
    global $extensionHandler;
    $extensionHandler->applyProp($name, $value, $docBuilder);
}
function ext_init() {
    global $ext_objects, $extensionHandler;

    foreach (glob(__DIR__."/../ext/*.php") as $filename) {
        include $filename;
    }
    foreach ($ext_objects as $extObj) {
        $extObj->init($extensionHandler);
    }
}
function ext_reg(RTExtension $extObj) {
    global $ext_objects;

    $ext_objects[] = $extObj;
}

?>