<?php
/**
 *	{$action_form_path}
 *
 *	@author		{$author}
 *	@package	{$project_id}
 *	@version		$Id$
 */

// カラム名定義の取得
require_once '{$column_name_file}';

/**
 *	{$model}用フォームの実装
 *
 *	@author		{$author}
 *	@access		public
 *	@package	{$project_id}
 *	@version		1.0
 */
class {$project_id}_{$modelName}_ActionForm extends {$project_id}_ActionForm
{
    /** @var    bool    バリデータにプラグインを使うフラグ */
    var $use_validator_plugin = true;

	/**
	 *	@access	private
	 *	@var	array	フォーム値定義
	 */
	var $form_template = array(
{$form_define}	);
}
?>
