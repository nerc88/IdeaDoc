<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Smarty count_characters modifier plugin
 *
 * Type:     modifier<br>
 * Name:     count_characteres<br>
 * Purpose:  count the number of characters in a text
 * @link http://smarty.php.net/manual/en/language.modifier.count.characters.php
 *          count_characters (Smarty online manual)
 * @author   Monte Ohrt <monte at ohrt dot com>
 * @param string
 * @param boolean include whitespace in the character count
 * @return integer
 */
function smarty_modifier_count_characters($string, $include_spaces = false, $charset='UTF-8')
{
    if ($include_spaces)
       return iconv_strlen($string, $charset);

    return preg_match_all("/[^\s]/",$string, $match);
}

/* vim: set expandtab: */

?>
