<?php

class TutorialExtension extends RTExtension
{
    public function before(DocBuilder $docBuilder) {
        $docBuilder->addBody("<div style=\"position:fixed;top:0;left:0;width:100%;height:4rem;line-height:4rem;padding-left:2rem;background-color:lightgray;\">My Default Header</div>");
        $docBuilder->addBody("<div style=\"height: 4rem;\"></div>");
    }
    public function after(DocBuilder $docBuilder) {

    }
    public function applyProp(String $name, String $value, DocBuilder $docBuilder) {
        if ($name == "title") {
            $docBuilder->addHead("<meta name=\"title\" content=\"{$value}\"/>");
            $docBuilder->addHead("<title>{$value}</title>");
        }
    }

    protected function listProps() {
        return array("title");
    }
}

ext_reg(new TutorialExtension());

?>