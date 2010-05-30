<?php
/**
 *	{$action_path}
 *
 *	@author		{$author}
 *	@package	{$project_id}
 *	@version		$Id$
 */

// �����̾����μ���
require_once '{$column_name_file}';

// �١���ActionFormClass�μ���
require_once '{$action_form_file}';

/**
 *	{$action_name}�ե�����μ���
 *
 *	@author		{$author}
 *	@access		public
 *	@package	{$project_id}
 *	@version		1.0
 */
class {$action_form} extends {$project_id}_{$modelName}_ActionForm
{
    /** @var    bool    �Х�ǡ����˥ץ饰�����Ȥ��ե饰 */
    var $use_validator_plugin = true;

	/**
	 *	@access	private
	 *	@var	array	�ե����������
	 */
	var	$form = array(
{$form_define}	);
}

/**
 *	{$action_name}���������μ���
 *
 *	@author		{$author}
 *	@access		public
 *	@package	{$project_id}
 *	@version		1.0
 */
class {$action_class} extends {$project_id}_ActionClass
{
	/**
	 *	{$action_name}����������������
	 *
	 *	@access	 public
	 *	@return	string		����̾(���ｪλ�ʤ�null, ������λ�ʤ�false)
	 */
	function prepare()
	{
		if ($this->af->validate() > 0) {
			return '{$view_error_name}';
		}
		return null;
	}

	/**
	 *	{$action_name}���������μ���
	 *
	 *	@access	 public
	 *	@return	string	����̾
	 */
	function perform()
	{
		${$model} =& $this->backend->getObject('{$modelName}', '{$modelPK}', $this->af->get('{$modelPK}'));
		if (${$model}->isActive() === false) {
			$this->ae->add(null, "����" . SCAFFOLD_MODEL_NAME_{$modelUName} . "�����ѤǤ��ޤ���", E_{$modelUName}_NOT_FOUND);
			return '{$view_error_name}';
		}
		
		return '{$view_name}';
	}
}
?>
