<?php
/**
 * Ethna_Plugin_Generator_ScaffoldActions.php
 * 
 * @author BoBpp < bobpp@users.sourceforge.jp >
 * @package projBop.Ethna.Scaffold
 */

// Base Class読み込み
require_once 'Ethna_Plugin_Generator_ScaffoldAppObject.php';

/**
 * ScaffoldActions Generator Plugin
 * 
 * @access public
 * @author BoBpp < bobpp@users.sourceforge.jp >
 * @package projBop.Ethna.Scaffold
 */
class Ethna_Plugin_Generator_ScaffoldActions extends Ethna_Plugin_Generator_ScaffoldAppObject
{
	/**
	 * ScaffoldActions を生成する
	 * 
	 * @access public
	 * @param $baseAction string ベースのアクション名
	 * @param $model string モデル名
	 * @param $modelDefine array モデル定義
	 * @param $formDef array フォーム定義
	 */
	function &generate($baseAction, $model, $modelDefine, $idDefine, $formDef)
	{
		$table_id = $this->_getTableId($model);
				
		// Project Macro
		$projectMacro = array();
		$projectMacro['model'] = $model;
        $projectMacro['modelName'] = $table_id;
        $projectMacro['modelUName'] = strtoupper($table_id);
        $projectMacro['modelPK'] = $idDefine;
        $projectMacro['project_id'] = $this->ctl->getAppId();
        $projectMacro['column_name_file'] = $this->_getColumnNamePath($table_id);
        $projectMacro['action_form_file'] = $this->_getActionFormPath($table_id);
        
		// Actionの生成
		$actions = array(
			"base" => array(
				'view_name' => $this->_getFullAction($baseAction, 'list'),
			),
			"index" => array(
				'view_name' => $this->_getFullAction($baseAction, 'list'),
			),
			"create" => array(
				'view_name' => $this->_getFullAction($baseAction, 'form_create'),
			),
			"create_do" => array(
				'view_error_name' => $this->_getFullAction($baseAction, 'form_create'),
				'view_name' => $this->_getFullAction($baseAction, 'list'),
				'form_define' => $this->_getActionFormDefine($formDef, null, array($idDefine)),
			),
			"update" => array(
				'view_error_name' => $this->_getFullAction($baseAction, 'list'),
				'view_name' => $this->_getFullAction($baseAction, 'form_update'),
				'form_define' => $this->_getActionFormDefine($formDef, array($idDefine)),
			),
			"update_do" => array(
				'view_error_name' => $this->_getFullAction($baseAction, 'form_update'),
				'view_name' => $this->_getFullAction($baseAction, 'list'),
				'form_define' => $this->_getActionFormDefine($formDef),
			),
			"read" => array(
				'view_error_name' => $this->_getFullAction($baseAction, 'list'),
				'view_name' => $this->_getFullAction($baseAction, 'read'),
				'form_define' => $this->_getActionFormDefine($formDef, array($idDefine)),
			),
			"delete" => array(
				'view_error_name' => $this->_getFullAction($baseAction, 'list'),
				'view_name' => $this->_getFullAction($baseAction, 'delete'),
				'form_define' => $this->_getActionFormDefine($formDef, array($idDefine)),
			),
			"delete_do" => array(
				'view_error_name' => $this->_getFullAction($baseAction, 'delete'),
				'view_name' => $this->_getFullAction($baseAction, 'list'),
				'form_define' => $this->_getActionFormDefine($formDef, array($idDefine)),
			),
		);
		foreach ($actions as $action => $value) {
			if ($action != "base") {
				$action_name = $this->_getFullAction($baseAction, $action);
			} else {
				$action_name = $baseAction;
			}
			
			$action_dir = $this->ctl->getActiondir(GATEWAY_WWW);
	        $action_class = $this->ctl->getDefaultActionClass($action_name, GATEWAY_WWW);
	        $action_form = $this->ctl->getDefaultFormClass($action_name, GATEWAY_WWW);
	        $action_path = $this->ctl->getDefaultActionPath($action_name);
	        
	        $macro = $value;
	        $macro['action_name'] = $action_name;
		    $macro['action_class'] = $action_class;
		    $macro['action_form'] = $action_form;
		    $macro['action_path'] = $action_path;
	
	        $user_macro = $this->_getUserMacro();
	        $macro = array_merge($projectMacro, $macro, $user_macro);
	
	        Ethna_Util::mkdir(dirname("$action_dir$action_path"), 0755);
	
	        $skelton = "skel.scaffold-action-" . $action . ".php";
	
	        if (file_exists("$action_dir$action_path")) {
	            printf("file [%s] already exists -> skip\n", "$action_dir$action_path");
	        } else if ($this->_generateFile($skelton, "$action_dir$action_path", $macro) == false) {
	            printf("[warning] file creation failed [%s]\n", "$action_dir$action_path");
	        } else {
	            printf("action script(s) successfully created [%s]\n", "$action_dir$action_path");
	        }
		}
		$true = true;
        return $true;
	}
	
	/**
	 * アクションフォーム定義を設定する
	 * 
	 * @access private
	 * @param array $formDef フォーム定義
	 * @return string ActionFormの定義
	 */
	function _getActionFormDefine($formDef, $allow=null, $ignore=null)
	{
		// FormDefineの生成
		$form = "";
		foreach ($formDef as $name => $value) {
			if (is_array($ignore) && in_array($name, $ignore)) {
				continue;
			}
			
			if ((is_array($allow) && in_array($name, $allow)) || $allow == null) {
				$form .= "		'{$name}' => array(),\n";
			}
		}
		
		return $form;
	}
}
?>