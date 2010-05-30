<?php
/**
 * Ethna_Plugin_Generator_ScaffoldViews.php
 * 
 * @author BoBpp < bobpp@users.sourceforge.jp >
 * @package projBop.Ethna.Scaffold
 */

// Base Class読み込み
require_once 'Ethna_Plugin_Generator_ScaffoldAppObject.php';

/**
 * ScaffoldViews Generator Plugin
 * 
 * @access public
 * @author BoBpp < bobpp@users.sourceforge.jp >
 * @package projBop.Ethna.Scaffold
 */
class Ethna_Plugin_Generator_ScaffoldViews extends Ethna_Plugin_Generator_ScaffoldAppObject
{
	/**
	 * ScaffoldViews を生成する
	 * 
	 * @access public
	 * @param $baseAction string ベースのアクション名
	 * @param $model string モデル名
	 * @param $modelDefine array モデル定義
	 * @param $formDef array フォーム定義
	 */
	function &generate($baseAction,$model, $modelDefine, $idDefine, $formDef)
	{
        $table_id = $this->_getTableId($model);
        $columnName_path = $this->_getColumnNamePath($table_id);
        
        // Viewを生成
        $views = array(
        	"list" => array(
        		'helper' => $this->_getFullAction($baseAction, 'create_do'),
        	),
        	"read" => array(
        		'helper' => $this->_getFullAction($baseAction, 'create_do'),
        	),
        	"form_create" => array(
        		'helper' => $this->_getFullAction($baseAction, 'create_do'),
        	),
        	"form_update" => array(
        		'helper' => $this->_getFullAction($baseAction, 'update_do'),
        	),
        	"delete" => array(
        		'helper' => $this->_getFullAction($baseAction, 'create_do'),
        	),
        );
        foreach ($views as $name=>$value) {
        	$forward_name = $this->_getFullAction($baseAction, $name);
        	
        	$view_dir = $this->ctl->getViewdir();
	        $view_class = $this->ctl->getDefaultViewClass($forward_name, false);
	        $view_path = $this->ctl->getDefaultViewPath($forward_name, false);
	
	        $macro = $value;
	        $macro['model'] = $model;
	        $macro['modelName'] = ucfirst($table_id);
	        $macro['modelUName'] = strtoupper($table_id);
	        $macro['modelPK'] = $idDefine;
	        $macro['project_id'] = $this->ctl->getAppId();
	        $macro['forward_name'] = $forward_name;
	        $macro['view_class'] = $view_class;
	        $macro['view_path'] = $view_path;
	        $macro['column_name_file'] = $columnName_path;
	
	        $user_macro = $this->_getUserMacro();
	        $macro = array_merge($macro, $user_macro);
	
	        Ethna_Util::mkdir(dirname("$view_dir/$view_path"), 0755);
			
			if ($name == 'list') {
				$skelton = 'skel.scaffold-view-list.php';
			} else if ($name == 'delete') {
				$skelton = 'skel.scaffold-view-delete.php';
			} else if ($name == 'read') {
				$skelton = 'skel.scaffold-view-item.php';
			} else if ($name == 'form_create') {
				$skelton = 'skel.scaffold-view-formCreate.php';
			} else if ($name == 'form_update') {
				$skelton = 'skel.scaffold-view-formUpdate.php';
			}
			
	        if (file_exists("$view_dir$view_path")) {
	            printf("file [%s] already exists -> skip\n", "$view_dir$view_path");
	        } else if ($this->_generateFile($skelton, "$view_dir$view_path", $macro) == false) {
	            printf("[warning] file creation failed [%s]\n", "$view_dir$view_path");
	        } else {
	            printf("view script(s) successfully created [%s]\n", "$view_dir$view_path");
	        }
        }
        $true = true;
        return $true;
	}
}
?>