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
	 *	@access	 private
	 *	@var	array	�ե����������
	 */
	var $form = array(
{$form_define}
	);
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
		// {$modelName}Manager�μ���
		${$model}Manager =& $this->backend->getManager('{$modelName}');
		
		// {$modelName}���ɲ�
		${$model} =& $this->backend->getObject('{$modelName}');
		${$model}->importForm(OBJECT_IMPORT_IGNORE_NULL);
		$r =& ${$model}Manager->add(${$model});
		if (Ethna::isError($r) || $r === false) {
			$this->ae->add(null, SCAFFOLD_MODEL_NAME_{$modelUName} . "���ɲä˼��Ԥ��ޤ���", E_{$modelUName}_ADD_FAILED);
			return '{$view_error_name}';
		}
		
		// Notice Message Pattern
		$_notices = array();
		$_notices[] = SCAFFOLD_MODEL_NAME_{$modelUName} . "���ɲä���λ���ޤ���";
		$this->af->setApp('notices', $_notices);
		
		return '{$view_name}';
	}
}
?>
