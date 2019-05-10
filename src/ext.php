<?php

abstract class RTExtension {

    private $props;

    public function init() {
        $this->props = $this->listProps() | array();
    }

    public abstract function before(DocBuilder $docBuilder);
    public abstract function after(DocBuilder $docBuilder);

    public abstract function applyProp(String $name, String $value, DocBuilder $docBuilder);
    public function getProps() {
        return $this->props;
    }

    protected abstract function listProps();
}

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
    global $ext_objects;

    foreach ($ext_objects as $extObj) {
        if (in_array($name, $extObj->getProps())) {
            $extObj->applyProp($name, $value, $docBuilder);
        }
    }
}

function ext_init() {
    global $ext_objects;

    foreach (glob(__DIR__."/../ext/*.php") as $filename) {
        include $filename;
    }
    foreach ($ext_objects as $extObj) {
        $extObj->init();
    }
}
function ext_reg(RTExtension $extObj) {
    global $ext_objects;

    $ext_objects[] = $extObj;
}

?>