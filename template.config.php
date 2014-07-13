<?php
/**
 * Шаблонизатор
 */
require_once ('templates/GZSmarty.class.php');
$Tpl = new GZSmarty ();
$Tpl->template_dir = 'templates/tpls';
$Tpl->compile_dir = 'templates/tpls_c';
$Tpl->useGZip = true;
$Tpl->gzLevel = 5;
$Tpl->stripWhiteSpaces = false;
$Tpl->transSid = false;
?>