<?php
/**
 *	{$app_path}
 *
 *	@author		{$author}
 *	@package	{$project_id}
 *	@version		$Id$
 */

/**
 *	Base AppManager for {$project_id}
 *
 *	@author		{$author}
 *	@access		public
 *	@package	{$project_id}
 *	@version		1.0
 */
class {$project_id}_AppBase_AppManager extends Ethna_AppManager
{
	/** @var string ���Υޥ͡����㤬�ᥤ��ǻȤ���ǥ�̾�� */
	var $modelName = null;
	
	/**
	 * ���֥������Ȥ��������
	 * 
	 * @access public
	 * @param int $offset ���ե��å�
	 * @param int $num �������
	 * @return mixed (Array: ���֥������ȥꥹ��, Ethna::Error: ���顼)
	 */
	function gets($offset=null, $num=null)
	{
		$model =& $this->backend->getObject($this->modelName);
		if (in_array('deleted_at', array_keys($model->getDef()))) {
			$filter = array(
				'deleted_at' => new Ethna_AppSearchObject(NULL, OBJECT_CONDITION_EQ),
			);
		} else {
			$filter = array();
		}
		
		$order = array(
			'id' => OBJECT_SORT_DESC,
		);
		
		$list = $this->getObjectList($this->modelName, $filter, $order, $offset, $num);
		if (Ethna::isError($list))  {
			return $list;
		}
		
		return $list[1];
	}
	
	/**
	 * ���索�֥������ȥꥹ�Ȥ��������
	 * 
	 * @access public
	 * @return mixed (array: ���֥������ȤΥꥹ��, Ethna::Error: ���顼)
	 */
	function getAll()
	{
		return $this->gets();
	}
}

/**
 *	Base AppObject for {$project_id}
 *
 *	@author		{$author}
 *	@access		public
 *	@package	{$project_id}
 *	@version		1.0
 */
class {$project_id}_AppBase_AppObject extends Ethna_AppObject
{
    /**
     * �����ʥ쥳���ɤ����ä����֥������Ȳ�ɾ������
     * 
     * @access public
     * @return boolean �������ɤ���
     */
    function isValid()
    {
    	if (parent::isValid() === false) {
    		return false;
    	}
    	if (isset($this->prop_def['deleted_at']) && $this->get('deleted_at') != null) {
    		return false;
    	}
    	return true;
    }
    
    /**
     * ��ǥ��̾�Τ��������
     * 
     * @access public
     * @return string ��ǥ��̾��
     */
    function getModelName()
    {
    	$name = get_class($this);
		$UName = strtoupper(substr($name, strpos($name, '_')+1));
    	$def = "SCAFFOLD_MODEL_NAME_{$UName}";
    	
    	if (defined($def)) {
    		return constant($def);
    	} else {
    		return ucfirst($UName);
    	}
    }
    
    /**
     * �ץ�ѥƥ��ι���̾���������
     * 
     * @access public
     * @param string $key �ץ�ѥƥ�̾
     * @return string �ץ�ѥƥ��ι���̾
     */
    function getColumnName($key)
    {
    	$name = get_class($this);
		$UName = strtoupper(substr($name, strpos($name, '_')+1));
		$ColumnUName = strtoupper($key);
    	$def = "SCAFFOLD_COLUMN_NAME_{$UName}_{$ColumnUName}";
    	
    	if (defined($def)) {
    		return constant($def);
    	} else {
    		return ucfirst($key);
    	}
    }
    
    /**
     * �쥳���ɤ��ɲä���
     * 
     * @access public
     */
    function add()
    {
    	$date = date('Y-m-d H:i:s');
    	// �ɲ�����������
    	if (isset($this->prop_def['created_at'])) {
    		$this->set('created_at', $date);
    	}
    	// �ǽ���������������
    	if (isset($this->prop_def['updated_at'])) {
    		$this->set('updated_at', $date);
    	}
    	   	
    	return parent::add();
    }
    
    /**
     * �쥳���ɤ򹹿�����
     * 
     * @access public
     */
    function update()
    {
    	if (isset($this->prop_def['updated_at'])) {
    	    $this->set('updated_at', date('Y-m-d H:i:s'));
    	}
    	return parent::update();
    }
    
    /**
     * �쥳���ɤ�������
     * 
     * @access public
     */
    function remove()
    {
    	if (isset($this->prop_def['deleted_at'])) {
    		$this->set('deleted_at', date('Y-m-d H:i:s'));
    		return parent::update();
    	} else {
    		return parent::remove();
    	}
    }
}
?>
