<?php
require 'vendor/autoload.php';
use Smarty\Smarty;

$smarty = new Smarty();

$smarty->setTemplateDir(__DIR__ . '/../views/templates/');
$smarty->setCompileDir(__DIR__ . '/../views/templates_c/');
$smarty->setCacheDir(__DIR__ . '/../views/cache/');
$smarty->setConfigDir(__DIR__ . '/../views/configs/');

$smarty->escape_html = true;
$smarty->caching = false;
$smarty->debugging = false;
