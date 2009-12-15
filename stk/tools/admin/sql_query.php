<?php
/**
*
* @package Support Toolkit
* @version $Id: sql_query.php 192 2009-07-02 14:58:39Z erikfrerejean $
* @copyright (c) 2009 phpBB Group
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

/**
 * @ignore
 */
if (!defined('IN_PHPBB'))
{
	exit;
}

class sql_query
{
	/**
	* Display Options
	*
	* Output the options available
	*/
	function display_options()
	{
		return array(
			'title'	=> 'SQL_QUERY',
			'vars'	=> array(
				'legend1'			=> 'SQL_QUERY_LEGEND',
				'sql_query'			=> array('lang' => 'SQL_QUERY', 'type' => 'textarea:20:255', 'explain' => true),
				'show_results'		=> array('lang' => 'SHOW_RESULTS', 'type' => 'checkbox', 'explain' => true),
			)
		);
	}

	/**
	* Run Tool
	*
	* Does the actual stuff we want the tool to do after submission
	*/
	function run_tool(&$error)
	{
		global $cache, $db, $dbms, $table_prefix, $template;

        if (!check_form_key('sql_query'))
		{
			$error[] = 'FORM_INVALID';
			return;
		}

		$sql_query = utf8_normalize_nfc(request_var('sql_query', '', true));

		// Replace phpbb_ with the correct table prefix.  Do the double replace otherwise you can have issues with prefixes like phpbb_3
		$sql_query = str_replace('phpbb_', $table_prefix, str_replace($table_prefix, 'phpbb_', $sql_query));

		if (!$sql_query)
		{
			$error[] = 'NO_SQL_QUERY';
			return;
		}

		if (!function_exists('remove_comments'))
		{
			include(PHPBB_ROOT_PATH . 'includes/functions_admin.' . PHP_EXT);
		}
		if (!function_exists('split_sql_file'))
		{
			include(PHPBB_ROOT_PATH . 'includes/functions_install.' . PHP_EXT);
		}

		$dbmd = get_available_dbms($dbms);
        $remove_remarks = $dbmd[$dbms]['COMMENTS'];
		$delimiter = $dbmd[$dbms]['DELIM'];
		$remove_remarks($sql_query);
		$sql_query = split_sql_file($sql_query, $delimiter);

		foreach ($sql_query as $sql)
		{
			$result = $db->sql_query($sql);

			if (isset($_POST['show_results']))
			{
				// Display the query
				$template->assign_block_vars('queries', array('QUERY' => $sql));

				$cnt = 0;
				while ($row = $db->sql_fetchrow($result))
				{
					if ($cnt == 0)
					{
						// Assign the return fields
						foreach(array_keys($row) as $key)
						{
							$template->assign_block_vars('queries.headings', array('FIELD_NAME' => $key));
						}
					}

					// Set row class
					$template->assign_block_vars('queries.resultdata', array('ROWSTYLE' => ($cnt % 2 == 0) ? 1 : 2));

					// Output resultset
					foreach ($row as $value)
					{
						$template->assign_block_vars('queries.resultdata.resultdatafields', array('VALUE' => $value));
					}

					$cnt++;
				}
			}
			$db->sql_freeresult($result);
		}

		// Purge the cache
		$cache->purge();

		trigger_error('SQL_QUERY_SUCCESS');
	}
}

?>