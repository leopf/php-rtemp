<?php

class DocBuilder
{   
    private $head;
    private $body;

    public function addHead($value)
    {
        $this->head = $this->head.$value;
    }
    public function addBody($value)
    {
        $this->body = $this->body.$value;
    }

    public function createHeadElement(DOMDocument $doc)
    {
        if ($this->head) {
            $frag = $doc->createDocumentFragment();
            $frag->appendXML($this->head);
            return $frag;
        }
    }
    public function createBodyElement(DOMDocument $doc)
    {
        if ($this->body) {
            $frag = $doc->createDocumentFragment();
            $frag->appendXML($this->body);
            return $frag;
        }
    }

    public function clear()
    {
        $this->body = "";
        $this->head = "";
    }
}

$docBuilder = new DocBuilder();

function doc_prop_set($name, $value) 
{
    global $docBuilder;
    ext_apply_prop($name, $value, $docBuilder);
}


function doc_render($filename)
{
    global $docBuilder, $doc_config;

    ob_start();

    include $filename;
    $doc_html = ob_get_contents();

    ob_clean();

    $doc = new DOMDocument();
    $doc->loadHTML($doc_html);

    $doc_el_head = $doc->getElementsByTagName("head")->item(0);
    $doc_el_body = $doc->getElementsByTagName("body")->item(0);

    ext_exec_before($docBuilder);

    if ($append_element = $docBuilder->createBodyElement($doc)) {
        if ($doc_el_body->firstChild) {
            $doc_el_body->insertBefore($append_element, $doc_el_body->firstChild);
        }
        else {
            $doc_el_body->appendChild($append_element);
        }
    }
    if ($append_element = $docBuilder->createHeadElement($doc)) {
        if ($doc_el_head->firstChild) {
            $doc_el_head->insertBefore($append_element, $doc_el_head->firstChild);
        }
        else {
            $doc_el_head->appendChild($append_element);
        }
    }

    $docBuilder->clear();
    
    ext_exec_after($docBuilder);

    if ($append_element = $docBuilder->createBodyElement($doc)) {
        $doc_el_body->appendChild($append_element);
    }
    if ($append_element = $docBuilder->createHeadElement($doc)) {
        $doc_el_head->appendChild($append_element);
    }

    echo $doc->saveHTML();
}

?>