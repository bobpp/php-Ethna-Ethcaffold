<?php
/**
 *	{$app_path}
 *
 *	@author		{$author}
 *	@package	{$project_id}
 *	@version		$Id$
 */

// ��ǥ�̾������ե�����
if (file_exists_ex('{$column_name_file}')) {
	require_once '{$column_name_file}';
}

// �١���AppObject, AppManager
require_once '{$base_class_file}';

// ���顼������
// TODO: {$project_id}_Error.php���ͤ��ѹ�������ǰ�ư�����Ƥ�������
define('E_{$modelUName}_ADD_FAILED', 256);
define('E_{$modelUName}_UPDATE_FAILED', 257);
define('E_{$modelUName}_DELETE_FAILED', 258);
define('E_{$modelUName}_NOT_FOUND', 259);

/**
 *	{$app_object}Manager
 *
 *	@author		{$author}
 *	@access		public
 *	@package	{$project_id}
 */
class {$app_object}Manager extends {$project_id}_AppBase_AppManager
{
	/** @var string ���Υޥ͡����㤬�ᥤ��ǻ��Ѥ����ǥ��̾�� */
	var $modelName = "{$modelName}";
	
	/**
	 * {$modelName}���ɲä���
	 *
	 * @access public
	 * @param {$project_id}_{$modelName}Object &${$model} �ɲä��륪�֥�������
	 * @return mixed (Ethna::Error: ���顼, TRUE: ����, FALSE: ����)
	 */
	function &add(&${$model})
	{
		// TODO: �����ɲû��˥����ƥ�¦���ɲä����ͤ�����Ф����˵��Ҥ���
		// �ʤ���created_at��AppObject¦�ǽ��������
		
		$r =& ${$model}->add();
		return $r;
	}
	
	/**
	 * {$modelName}�򹹿�����
	 * 
	 * @access public
	 * @param {$project_id}_{$modelName}Object &${$model} �������륪�֥�������
	 * @return mixed (Ethna::Error: ���顼, TRUE: ����, FALSE: ����)
	 */
	function &update(&${$model})
	{
		// TODO: �����������˥����ƥ�¦���ѹ����ɲä����ͤ�������Ϥ����˵��Ҥ���
		// �ʤ���updated_at��AppObject¦�ǽ��������
		
		$r =& ${$model}->update();
		return $r;
	}
	
	/**
	 * {$modelName}��������
	 * 
	 * @access public
	 * @param {$project_id}_{$modelName}Object &${$model} ������륪�֥�������
	 * @return mixed (Ethna::Error: ���顼, TRUE: ����, FALSE: ����)
	 */
	function &remove(&${$model})
	{
		// TODO: ����������˥����ƥ�¦���ѹ����ɲä����ͤ�������Ϥ����˵��Ҥ���
		// �ʤ���deleted_at��AppObject¦�ǽ��������
		
		$r =& ${$model}->remove();
		return $r;
	}
}

/**
 *	{$app_object}
 *
 *	@author		{$author}
 *	@access		public
 *	@package	{$project_id}
 */
class {$app_object} extends {$project_id}_AppBase_AppObject
{
    /** @var string �ơ��֥�̾ */
    var $table_def = "{$model}";
    
    /**
     * �����ƥ��֤ʥ��֥������Ȥ�ɾ������
     * 
     * @access public
     * @return boolean �������ɤ���
     */
    function isActive()
    {
    	if (parent::isActive() === false) {
    		return false;
    	}
    	// TODO: ���ץꥱ��������٥�ǥ��֥������Ȥ������ʤ�Τ�Ĵ�٤���å��򵭽Ҥ���
    	
    	return true;
    }
    
    /**
     *  �ץ�ѥƥ���ɽ��̾���������
     *
     *  @access public
     */
    function getName($key)
    {
        return $this->get($key);
    }
    
    /**
     * �쥳���ɤ��ɲä���
     * 
     * @access public
     */
    function add()
    {
    	// TODO: �쥳���ɤȤ��ƤΥ�٥���ɲû���ɬ�פʥ��å��򵭽�
    	
    	return parent::add();
    }
    
    /**
     * �쥳���ɤ򹹿�����
     * 
     * @access public
     */
    function update()
    {
    	// TODO: �쥳���ɤȤ��ƤΥ�٥�ǹ�������ɬ�פʥ��å��ε���
    	
    	return parent::update();
    }
    
    /**
     * �쥳���ɤ�������
     * 
     * @access public
     */
    function remove()
    {
    	// TODO: �쥳���ɤȤ��ƤΥ�٥�Ǻ������ɬ�פʥ��å��ε���
    	
    	return parent::remove();
    }
    
    /**
     * �ե������ͤ�ץ�ѥƥ��˥���ݡ��Ȥ���
     * 
     * @access public
     * @param int $option ���ץ����
     */
    function importForm($option=null)
    {
    	// TODO: �ͤ��Ѵ���Ϥ��ߤ������Ϥ�����˵���
    	
    	parent::importForm($option);
    }
    
    /**
     * �ץ�ѥƥ���ե������ͤ˥������ݡ��Ȥ���
     * 
     * @access public
     */
    function exportForm()
    {
    	// TODO: �ͤ��Ѵ���Ϥ��ߤ������Ϥ�����˵���
    	
    	parent::exportForm();
    }
}
?>
