<?php
/**
*
* @package Support Toolkit - Make Founder
* @version $Id: make_founder.php 180 2009-06-16 15:12:44Z erikfrerejean $
* @copyright (c) 2009 phpBB Group
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

/**
* DO NOT CHANGE
*/
if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = array();
}

// DEVELOPERS PLEASE NOTE
//
// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
//
// Placeholders can now contain order information, e.g. instead of
// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
// translators to re-order the output of data while ensuring it remains correct
//
// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
// equally where a string contains only two placeholders which are used to wrap text
// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
//
// Some characters you may want to copy&paste:
// ’ » “ ” …
//

$lang = array_merge($lang, array(
	'MAKE_FOUNDER'				=> 'Make a user Board Founder',
	'MAKE_FOUNDER_CONFIRM'		=> 'Are you sure you want to make <a href="%1$s">%2$s</a> a Board Founder?  This will give <a href="%1$s">%2$s</a> the ability to delete your account, among other powers.',
	'MAKE_FOUNDER_EXPLAIN'		=> 'Here you can change a user’s type to be that of a board founder which has FULL administrative permissions.',
	'MAKE_FOUNDER_SUCCESS'		=> 'Successfully made <a href="%1$s">%2$s</a> a Board Founder.',

	'USER_ALREADY_FOUNDER'		=> '%s is already a Board Founder.',
	'USER_TO_FOUNDER'			=> 'User to make Founder',
	'USER_TO_FOUNDER_EXPLAIN'	=> 'Enter the username or user ID of the user you would like to make a Board Founder.',
));

?>