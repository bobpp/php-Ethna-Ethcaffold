<?php
/**
 *	{$action_form_path}
 *
 *	@author		{$author}
 *	@package	{$project_id}
 *	@version		$Id$
 */

// �����̾����μ���
require_once '{$column_name_file}';

/**
 *	{$model}�ѥե�����μ���
 *
 *	@author		{$author}
 *	@access		public
 *	@package	{$project_id}
 *	@version		1.0
 */
class {$project_id}_{$modelName}_ActionForm extends {$project_id}_ActionForm
{
    /** @var    bool    �Х�ǡ����˥ץ饰�����Ȥ��ե饰 */
    var $use_validator_plugin = true;

	/**
	 *	@access	private
	 *	@var	array	�ե����������
	 */
	var $form_template = array(
{$form_define}	);
}
?>
