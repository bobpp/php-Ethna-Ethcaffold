<?php
/**
 *	{$view_path}
 *
 *	@author		{$author}
 *	@package	{$project_id}
 *	@version		$Id$
 */

// カラム名定義の取得
require_once '{$column_name_file}';

/**
 *	{$forward_name}ビューの実装
 *
 *	@author		{$author}
 *	@access		public
 *	@package	{$project_id}
 *	@version		1.0
 */
class {$view_class} extends {$project_id}_ViewClass
{
	/**
	 *	遷移前処理
	 *
	 *	@access	 public
	 */
	function preforward()
	{
	}
}
?>
