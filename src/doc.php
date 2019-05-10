<?php

$doc_head = "";
$doc_body = "";

$doc_handlers_prop = array();
$doc_handlers_events = array(
    "before" => array(),
    "after" => array()
);

function doc_exec_event($type) 
{
    global $doc_handlers_events;
    foreach ($doc_handlers_events[$type] as $funcName) {
        call_user_func($funcName);
    }
}

function doc_handler_prop_reg($funcName, $propName)
{
    global $doc_handlers_prop;
    $doc_handlers_prop[$propName] = $funcName;
}
function doc_handler_event_reg($funcName, $type)
{
    global $doc_handlers_events;
    $doc_handlers_events[$type][] = $funcName;
}

function doc_prop_set($name, $value) 
{
    global $doc_handlers_prop;

    if ($doc_handlers_prop[$name]) {
        call_user_func($doc_handlers_prop[$name], $value);
    }
}

function doc_head_add($value)
{
    global $doc_head;
    $doc_head = $doc_head.$value;
}
function doc_body_add($value)
{
    global $doc_body;
    $doc_body = $doc_body.$value;
}

function doc_render($filename)
{
    global $doc_body, $doc_config, $doc_head;

    ob_start();

    include $filename;
    $doc_html = ob_get_contents();

    ob_clean();

    $doc = new DOMDocument();
    $doc->loadHTML($doc_html);

    $doc_el_head = $doc->getElementsByTagName("head")->item(0);
    $doc_el_body = $doc->getElementsByTagName("body")->item(0);

    doc_exec_event("before");

    if ($doc_body) {
        $doc_frag_before_body = $doc->createDocumentFragment();
        $doc_frag_before_body->appendXML($doc_body);
        if ($doc_el_body->firstChild) {
            $doc_el_body->insertBefore($doc_frag_before_body, $doc_el_body->firstChild);
        }
        else {
            $doc_el_body->appendChild($doc_frag_before_body);
        }
        $doc_body = "";
    }

    if ($doc_head) {
        $doc_frag_before_head = $doc->createDocumentFragment();
        $doc_frag_before_head->appendXML($doc_head);
        if ($doc_el_head->firstChild) {
            $doc_el_head->insertBefore($doc_frag_before_head, $doc_el_head->firstChild);
        }
        else {
            $doc_el_head->appendChild($doc_frag_before_head);
        }
        $doc_head = "";
    }
    
    doc_exec_event("after");

    if ($doc_body) {
        $doc_frag_before_body = $doc->createDocumentFragment();
        $doc_frag_before_body->appendXML($doc_body);
        $doc_el_head->appendChild($doc_frag_before_body);
    }
    if ($doc_head) {
        $doc_frag_before_head = $doc->createDocumentFragment();
        $doc_frag_before_head->appendXML($doc_head);
        $doc_el_head->appendChild($doc_frag_before_head);
    }

    echo $doc->saveHTML();
}

?>