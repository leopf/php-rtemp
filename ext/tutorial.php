<?php

function ext_tutorial_header()
{
    doc_body_add("<div style=\"position:fixed;top:0;left:0;width:100%;height:4rem;line-height:4rem;padding-left:2rem;background-color:lightgray;\">My Default Header</div>");
    doc_body_add("<div style=\"height: 4rem;\"></div>");
}
function ext_tutorial_p_title($value)
{
    doc_head_add("<meta name=\"title\" content=\"{$value}\"/>");
    doc_head_add("<title>{$value}</title>");
}

doc_handler_prop_reg("ext_tutorial_p_title", "title");
doc_handler_event_reg("ext_tutorial_header", "before");

?>