<?php
/**
 * Ethna_Plugin_Generator_ScaffoldColumnName.php
 * 
 * @author BoBpp < bobpp@users.sourceforge.jp >
 * @package projBop.Ethna.Scaffold
 */

// Base Class読み込み
require_once 'Ethna_Plugin_Generator_ScaffoldAppObject.php';

/**
 * ScaffoldColumnName Generator Plugin
 * 
 * @access public
 * @author BoBpp < bobpp@users.sourceforge.jp >
 * @package projBop.Ethna.Scaffold
 */
class Ethna_Plugin_Generator_ScaffoldColumnName extends Ethna_Plugin_Generator_ScaffoldAppObject
{
	/**
	 * ScaffoldColumnDefine を生成する
	 * 
	 * @access public
	 * @param string $model モデル名
	 * @param array $modelDefine モデル定義
	 */
	function &generate($model, $modelDefine)
	{
		$table_id = $this->_getTableId($model);
		$file = ucfirst($this->ctl->getAppId()) . '_' . $table_id . '_ColumnName.php';
		
		// Directory
		$dir = $this->ctl->getDirectory('column_name');
		if ($dir == null) {
			$dir = $this->ctl->getDirectory('app') . "/column_name/";
		}
		
		// ModelName
		$modelUName = strtoupper($table_id);
		$modelName = ucfirst(strtolower($table_id));
		
		// ColumnName
		foreach ($modelDefine as $name=>$def) {
			$columnUName = strtoupper($name);
			$columnName = ucfirst(strtolower($name));
			$columnDefine[] = "define('SCAFFOLD_COLUMN_NAME_{$modelUName}_{$columnUName}', \"{$columnName}\");";
		}
		
		// Macro Setting
		$macro = array();
		$macro['modelNameDefine'] = "define('SCAFFOLD_MODEL_NAME_{$modelUName}', \"{$modelName}\");";
		$macro['columnNameDefine'] = implode("\n", $columnDefine);
		$macro['model'] = $model;
		$macro['project_id'] = $this->ctl->getAppId();
		$macro['app_path'] = $file;
		$macro = array_merge($macro, $this->_getUserMacro());
		
		// Creating File
		$skelton = "skel.scaffold-ColumnNameDefine.php";
        
		$path = "$dir$file";
        Ethna_Util::mkdir(dirname($path), 0755);
        if (file_exists($path)) {
            printf("file [%s] already exists -> skip\n", $path);
        } else if ($this->_generateFile($skelton, $path, $macro) == false) {
            printf("[warning] file creation failed [%s]\n", $path);
        } else {
            printf("ColumnName script(s) successfully created [%s]\n", $path);
        }
        $true = true;
        return $true;
	}
}
?>