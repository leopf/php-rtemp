<?php

include "src/route.php";
include "src/doc.php";

foreach (glob("ext/*.php") as $filename) {
    include $filename;
}

$filepath = route_get_path();

if (file_exists($filepath)) {
    doc_render($filepath);
}
else {
    header("HTTP/1.0 404 Not Found");
}

?>