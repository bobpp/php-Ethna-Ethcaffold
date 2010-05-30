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
		${$model}Manager =& $this->backend->getManager('{$modelName}');
		${$model}ObjectList = ${$model}Manager->getAll();
		${$model}PropList = array();
		if (Ethna::isError(${$model}ObjectList)) {
			$this->ae->add(null, SCAFFOLD_MODEL_NAME_{$modelUName} . "のリスト取得に失敗しました", E_{$modelUName}_GET_LIST_FAILED);
		} else {
			foreach (${$model}ObjectList as ${$model}) {
				${$model}PropList[] = ${$model}->getNameObject();
			}
		}
		$this->af->setApp('{$modelName}List', ${$model}PropList);
	}
}
?>
