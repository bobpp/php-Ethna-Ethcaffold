<?php
/**
 * Ethna_Plugin_Generator_ScaffoldActionForm.php
 * 
 * @author BoBpp < bobpp@users.sourceforge.jp >
 * @package projBop.Ethna.Scaffold
 */

// Base Class�ɤ߹���
require_once 'Ethna_Plugin_Generator_ScaffoldAppObject.php';

/**
 * ScaffoldActionForm Generator Plugin
 * 
 * @access public
 * @author BoBpp < bobpp@users.sourceforge.jp >
 * @package projBop.Ethna.Scaffold
 */
class Ethna_Plugin_Generator_ScaffoldActionForm extends Ethna_Plugin_Generator_ScaffoldAppObject
{
	/**
	 * ScaffoldActionForm ����������
	 * 
	 * @access public
	 * @param $model string �ơ��֥�̾
	 * @param $modelDefine array ��ǥ����
	 * @param $formDef array �ե��������
	 */
	function &generate($model, $modelDefine, $formDef)
	{
		$table_id = $this->_getTableId($model);
        $project_id = $this->ctl->getAppId();
        
        $dir = $this->ctl->getDirectory('action_form');
        if ($dir == null) {
        	$dir = $this->ctl->getDirectory('app') . "/action_form/";
        }        
        $file = "{$project_id}_{$table_id}_ActionForm.php";
				
		// Macro
		$macro = array();
		$macro['model'] = $model;
        $macro['modelName'] = $table_id;
        $macro['modelUName'] = strtoupper($table_id);
        $macro['project_id'] = $project_id;
        $macro['column_name_file'] = $this->_getColumnNamePath($table_id);
        $macro['form_define'] = $this->_getActionFormDefine($formDef);
        
        $user_macro = $this->_getUserMacro();
        $macro = array_merge($macro, $user_macro);
        
        $skelton = "skel.scaffold-actionform.php";
        
        // �ե���������
        $path = "$dir$file";
        Ethna_Util::mkdir(dirname($path), 0755);
        if (file_exists($path)) {
            printf("file [%s] already exists -> skip\n", $path);
        } else if ($this->_generateFile($skelton, $path, $macro) == false) {
            printf("[warning] file creation failed [%s]\n", $path);
        } else {
            printf("action script(s) successfully created [%s]\n", $path);
        }

		$true = true;
        return $true;
	}
	
	/**
	 * ���������ե�������������ꤹ��
	 * 
	 * @access private
	 * @param array $formDef �ե��������
	 * @return string ActionForm�����
	 */
	function _getActionFormDefine($formDef)
	{
		// FormDefine������
		$form = "";
		foreach ($formDef as $name => $value) {
			$form .= "		'{$name}' => array(\n";
			foreach ($value as $k => $v) {
				$form .= "			'{$k}' => {$v},\n";
			}
			$form .= "		),\n";
		}
		
		return $form;
	}
}
?>