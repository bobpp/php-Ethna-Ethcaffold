<?php
/**
 *	{$app_path}
 *
 *	@author		{$author}
 *	@package	{$project_id}
 *	@version		$Id$
 */

// モデル名称定義ファイル
if (file_exists_ex('{$column_name_file}')) {
	require_once '{$column_name_file}';
}

// ベースAppObject, AppManager
require_once '{$base_class_file}';

// エラー定数定義
// TODO: {$project_id}_Error.phpに値を変更した上で移動させてください
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
	/** @var string このマネージャがメインで使用するモデルの名称 */
	var $modelName = "{$modelName}";
	
	/**
	 * {$modelName}を追加する
	 *
	 * @access public
	 * @param {$project_id}_{$modelName}Object &${$model} 追加するオブジェクト
	 * @return mixed (Ethna::Error: エラー, TRUE: 成功, FALSE: 失敗)
	 */
	function &add(&${$model})
	{
		// TODO: 何か追加時にシステム側で追加する値があればここに記述する
		// なお、created_atはAppObject側で処理される
		
		$r =& ${$model}->add();
		return $r;
	}
	
	/**
	 * {$modelName}を更新する
	 * 
	 * @access public
	 * @param {$project_id}_{$modelName}Object &${$model} 更新するオブジェクト
	 * @return mixed (Ethna::Error: エラー, TRUE: 成功, FALSE: 失敗)
	 */
	function &update(&${$model})
	{
		// TODO: 何か更新時にシステム側で変更、追加する値がある場合はここに記述する
		// なお、updated_atはAppObject側で処理される
		
		$r =& ${$model}->update();
		return $r;
	}
	
	/**
	 * {$modelName}を削除する
	 * 
	 * @access public
	 * @param {$project_id}_{$modelName}Object &${$model} 削除するオブジェクト
	 * @return mixed (Ethna::Error: エラー, TRUE: 成功, FALSE: 失敗)
	 */
	function &remove(&${$model})
	{
		// TODO: 何か削除時にシステム側で変更、追加する値がある場合はここに記述する
		// なお、deleted_atはAppObject側で処理される
		
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
    /** @var string テーブル名 */
    var $table_def = "{$model}";
    
    /**
     * アクティブなオブジェクトか評価する
     * 
     * @access public
     * @return boolean 正当かどうか
     */
    function isActive()
    {
    	if (parent::isActive() === false) {
    		return false;
    	}
    	// TODO: アプリケーションレベルでオブジェクトが正当なものか調べるロジックを記述する
    	
    	return true;
    }
    
    /**
     *  プロパティの表示名を取得する
     *
     *  @access public
     */
    function getName($key)
    {
        return $this->get($key);
    }
    
    /**
     * レコードを追加する
     * 
     * @access public
     */
    function add()
    {
    	// TODO: レコードとしてのレベルで追加時に必要なロジックを記述
    	
    	return parent::add();
    }
    
    /**
     * レコードを更新する
     * 
     * @access public
     */
    function update()
    {
    	// TODO: レコードとしてのレベルで更新時に必要なロジックの記述
    	
    	return parent::update();
    }
    
    /**
     * レコードを削除する
     * 
     * @access public
     */
    function remove()
    {
    	// TODO: レコードとしてのレベルで削除時に必要なロジックの記述
    	
    	return parent::remove();
    }
    
    /**
     * フォーム値をプロパティにインポートする
     * 
     * @access public
     * @param int $option オプション
     */
    function importForm($option=null)
    {
    	// TODO: 値の変換をはさみたい場合はこちらに記述
    	
    	parent::importForm($option);
    }
    
    /**
     * プロパティをフォーム値にエクスポートする
     * 
     * @access public
     */
    function exportForm()
    {
    	// TODO: 値の変換をはさみたい場合はこちらに記述
    	
    	parent::exportForm();
    }
}
?>
