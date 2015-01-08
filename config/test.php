<?php
$xml = simplexml_load_file("wx_config.xml");
echo $xml->database->name;
?>
