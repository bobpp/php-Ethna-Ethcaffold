<?php
/**
 *	{$view_path}
 *
 *	@author		{$author}
 *	@package	{$project_id}
 *	@version		$Id$
 */

// �����̾����μ���
require_once '{$column_name_file}';

/**
 *	{$forward_name}�ӥ塼�μ���
 *
 *	@author		{$author}
 *	@access		public
 *	@package	{$project_id}
 *	@version		1.0
 */
class {$view_class} extends {$project_id}_ViewClass
{
	/**
	 *	����������
	 *
	 *	@access	 public
	 */
	function preforward()
	{
		${$model} =& $this->backend->getObject('{$modelName}', '{$modelPK}', $this->af->get('{$modelPK}'));
		$this->af->setApp('{$modelName}', ${$model}->getNameObject());
		
		// ������륢���ƥ�ID���Ϥ�
		$this->af->setAppNE('hiddens', $this->af->getHiddenVars(array('{$modelPK}')));
	}
}
?>
