<?php

require_once 'Templator.php';

new Templator();

$vars = $_POST['data'];
$template = $_POST['filename'];

Templator::load($template, $vars, true);