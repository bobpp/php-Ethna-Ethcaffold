<?php
/**
 * Ethna_Plugin_Generator_ScaffoldAppObject.php
 * 
 * @author BoBpp < bobpp@users.sourceforge.jp >
 * @package projBop.Ethna.Scaffold
 */

/**
 * ScaffoldAppObject Generator Plugin
 * 
 * ここを基本的に継承してコードを生成させる
 * 
 * @access public
 * @author BoBpp < bobpp@users.sourceforge.jp >
 * @package projBop.Ethna.Scaffold
 */
class Ethna_Plugin_Generator_ScaffoldAppObject extends Ethna_Plugin_Generator
{
	/**
	 * ScaffoldAppObject を生成する
	 * 
	 * @access public
	 * @param $table_name string テーブル名
	 */
	function &generate($table_name)
	{
        $table_id = $this->_getTableId($table_name);

        $app_dir = $this->ctl->getDirectory('app');
        $app_path = ucfirst($this->ctl->getAppId()) . '_' . $table_id .'.php';
        $baseClass_path = ucfirst($this->ctl->getAppId()) . '_AppBase_AppObject.php';

		// マクロ
        $macro = array();
        $macro['model'] = $table_name;
        $macro['modelName'] = $table_id;
        $macro['modelUName'] = strtoupper($table_id);
        $macro['project_id'] = $this->ctl->getAppId();
        $macro['app_path'] = $app_path;
        $macro['app_object'] = ucfirst($this->ctl->getAppId()) . '_' . $table_id;
        $macro['column_name_file'] = $this->_getColumnNamePath($table_id);
        $macro['base_class_file'] = $baseClass_path;
        $user_macro = $this->_getUserMacro();
        $macro = array_merge($macro, $user_macro);

		// ファイル生成
        $path = "$app_dir/$app_path";
        Ethna_Util::mkdir(dirname($path), 0755);
        if (file_exists($path)) {
            printf("file [%s] already exists -> skip\n", $path);
        } else if ($this->_generateFile("skel.scaffold-appobject.php", $path, $macro) == false) {
            printf("[warning] file creation failed [%s]\n", $path);
        } else {
            printf("app-object script(s) successfully created [%s]\n", $path);
        }
        $true = true;
        return $true;
	}
	
	/**
	 * ベースアクション + アクション名を返す
	 * 
	 * @access protected
	 * @param $base string ベースアクション名
	 * @param $action string アクション名
	 * @return string アクション名
	 */
	function _getFullAction($base, $action)
	{
		return $base . "_" . $action;
	}
	
	/**
	 * ColumnNameFileのパスを返す
	 * 
	 * @access protected
	 * @param string $table_id テーブルID
	 * @return string ColumnNameファイルへのパス
	 */
	function _getColumnNamePath($table_id)
	{
		return sprintf("column_name/%s_%s_ColumnName.php", $this->ctl->getAppId(), $table_id);
	}
	
	/**
	 * ActionFormFileのパスを返す
	 * 
	 * @access protected
	 * @param string $table_id テーブルID
	 * @return string ActionFormファイルへのパス
	 */
	function _getActionFormPath($table_id)
	{
		return sprintf("action_form/%s_%s_ActionForm.php", $this->ctl->getAppId(), $table_id);
	}
	
	/**
	 * クラスが用いるテーブルIDを返す
	 * 
	 * @access protected
	 * @param string $model テーブル名
	 * @return string テーブルid
	 */
	function _getTableId($model)
	{
		return preg_replace('/_(.)/e', "strtoupper('\$1')", ucfirst($model));
	}
}
?>