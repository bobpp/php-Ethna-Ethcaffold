<?php
/**
 *	{$action_path}
 *
 *	@author		{$author}
 *	@package	{$project_id}
 *	@version		$Id$
 */

// カラム名定義の取得
require_once '{$column_name_file}';

// ベースActionFormClassの取得
require_once '{$action_form_file}';

/**
 *	{$action_name}フォームの実装
 *
 *	@author		{$author}
 *	@access		public
 *	@package	{$project_id}
 *	@version		1.0
 */
class {$action_form} extends {$project_id}_{$modelName}_ActionForm
{
    /** @var    bool    バリデータにプラグインを使うフラグ */
    var $use_validator_plugin = true;

	/**
	 *	@access	private
	 *	@var	array	フォーム値定義
	 */
	var	$form = array(
{$form_define}	);
}

/**
 *	{$action_name}アクションの実装
 *
 *	@author		{$author}
 *	@access		public
 *	@package	{$project_id}
 *	@version		1.0
 */
class {$action_class} extends {$project_id}_ActionClass
{
	/**
	 *	{$action_name}アクションの前処理
	 *
	 *	@access	 public
	 *	@return	string		遷移名(正常終了ならnull, 処理終了ならfalse)
	 */
	function prepare()
	{
		if ($this->af->validate() > 0) {
			return '{$view_error_name}';
		}
		return null;
	}

	/**
	 *	{$action_name}アクションの実装
	 *
	 *	@access	 public
	 *	@return	string	遷移名
	 */
	function perform()
	{
		${$model} =& $this->backend->getObject('{$modelName}', '{$modelPK}', $this->af->get('{$modelPK}'));
		if (${$model}->isActive() === false) {
			$this->ae->add(null, "この" . SCAFFOLD_MODEL_NAME_{$modelUName} . "は利用できません", E_{$modelUName}_NOT_FOUND);
			return '{$view_error_name}';
		}
		
		return '{$view_name}';
	}
}
?>
