<?php

include './parser.php';

$parser = new WmParser();

echo "Cases:\n";
print_r($parser->getCases());

echo "\n\nCountries:\n";
print_r($parser->getCountries());

?>