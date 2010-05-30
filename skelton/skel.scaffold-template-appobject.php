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
	/** @var string このマネージャがメインで使うモデル名称 */
	var $modelName = null;
	
	/**
	 * オブジェクトを取得する
	 * 
	 * @access public
	 * @param int $offset オフセット
	 * @param int $num 取得件数
	 * @return mixed (Array: オブジェクトリスト, Ethna::Error: エラー)
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
	 * 全件オブジェクトリストを取得する
	 * 
	 * @access public
	 * @return mixed (array: オブジェクトのリスト, Ethna::Error: エラー)
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
     * 正当なレコードが入ったオブジェクト化評価する
     * 
     * @access public
     * @return boolean 正当かどうか
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
     * モデルの名称を取得する
     * 
     * @access public
     * @return string モデルの名称
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
     * プロパティの項目名を取得する
     * 
     * @access public
     * @param string $key プロパティ名
     * @return string プロパティの項目名
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
     * レコードを追加する
     * 
     * @access public
     */
    function add()
    {
    	$date = date('Y-m-d H:i:s');
    	// 追加日時の設定
    	if (isset($this->prop_def['created_at'])) {
    		$this->set('created_at', $date);
    	}
    	// 最終更新日時の設定
    	if (isset($this->prop_def['updated_at'])) {
    		$this->set('updated_at', $date);
    	}
    	   	
    	return parent::add();
    }
    
    /**
     * レコードを更新する
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
     * レコードを削除する
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
