<?php
/**
 * Smarty round modifier plugin
 *
 * Type:     modifier<br>
 * Name:     domain_name<br>
 * Purpose:  возвращает имя домена из url
 * 
 * @param string $string URL
 * @return string
 */
function smarty_modifier_domain_name($string, $punycode_decode=false) {
    if ($domain = parse_url($string, PHP_URL_HOST)) {
    	$string = $domain;
    }
    
    if ($punycode_decode) {
    	require_once (realpath(dirname(__FILE__).'/../../../Net/idna/').'/idna_convert.class.php');
    	$IDN = new idna_convert();
    	return $IDN->decode($string);
    }
    
    return $domain;
}
?>
