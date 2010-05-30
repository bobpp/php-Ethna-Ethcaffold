<?php
/**
 * Ethna_Plugin_Generator_ScaffoldTemplates.php
 * 
 * @author BoBpp < bobpp@users.sourceforge.jp >
 * @package projBop.Ethna.Scaffold
 */

// Base Class�ɤ߹���
require_once 'Ethna_Plugin_Generator_ScaffoldAppObject.php';

/**
 * ScaffoldTemplates Generator Plugin
 * 
 * @access public
 * @author BoBpp < bobpp@users.sourceforge.jp >
 * @package projBop.Ethna.Scaffold
 */
class Ethna_Plugin_Generator_ScaffoldTemplates extends Ethna_Plugin_Generator_ScaffoldAppObject
{
	/**
	 * ScaffoldTemplates ����������
	 * 
	 * @access public
	 * @param string $baseAction �١����Υ��������̾
	 * @param string  $model ��ǥ�̾
	 * @param array $modelDefine ��ǥ����
	 * @param string $idDefine �祭��̾
	 * @param array $formDef �ե��������
	 */
	function &generate($baseAction, $model, $modelDefine, $idDefine, $formDef)
	{
        // Template Directory
        $tpl_dir = $this->ctl->getTemplatedir();
        if ($tpl_dir{strlen($tpl_dir)-1} != '/') {
            $tpl_dir .= '/';
        }
        
        $table_id = $this->_getTableId($model);
        
        // Generating Templates
        $templates = array(
        	'list' => array(
        		'title' => sprintf("Listing {model_name model='%s'}", $table_id),
        		'template' => 'list',
        		'headerTag' => $this->_getListHeaderTags($modelDefine, $table_id),
        		'mainTag' => $this->_getListMainTags($modelDefine, $table_id),
        	),
        	'read' => array(
        		'title' => sprintf("Show {model_name model='%s'}", $table_id),
        		'template' => 'item',
        		'itemTag' => $this->_getItemMainTag($modelDefine, $table_id),
        	),
        	'form_create' => array(
        		'title' => sprintf("New {model_name model='%s'}", $table_id),
        		'template' => 'form',
        		'formTag' => $this->_getFormMainTag($formDef, null, array($idDefine)),
        		'action' => $this->_getFullAction($baseAction, 'create_do'),
        	),
        	'form_update' => array(
        		'title' => sprintf("Editing {model_name model='%s'}", $table_id),
        		'template' => 'form',
        		'formTag' => $this->_getFormMainTag($formDef, null, array($idDefine)),
        		'action' => $this->_getFullAction($baseAction, 'update_do'),
        	),
        	'delete' => array(
        		'title' => sprintf("Are you sure?", $model),
        		'template' => 'delete',
        		'itemTag' => $this->_getItemMainTag($modelDefine, $table_id),
        	),
        	
        	// Box File.
        	'_errorbox' => array(
        		'_fileName' => '_errorMessages.tpl.html',
        		'template' => 'errorMessages',
        	),
        	'_noticebox' => array(
        		'_fileName' => '_noticeMessages.tpl.html',
        		'template' => 'noticeMessages',
        	),
        );
        
        // Create BoxFilePath
        foreach ($templates as $name=>$value) {
        	if ($name{0} == '_') {
		        $tpl_path = $this->ctl->getDefaultForwardPath($this->_getFullAction($baseAction, 'test'));
		   		$path = explode("/", $tpl_path);
				$path[count($path) - 1] = $value['_fileName'];
				
				$templates[$name]['path'] = implode("/", $path);
        	}
        }
		
		
		// Project OverAll Macro
		$projMacro = array();
		$projMacro['listAction'] = $this->_getFullAction($baseAction, 'index');
    	$projMacro['readAction'] = $this->_getFullAction($baseAction, 'read');
    	$projMacro['createAction'] = $this->_getFullAction($baseAction, 'create');
    	$projMacro['createDoAction'] = $this->_getFullAction($baseAction, 'create_do');
    	$projMacro['updateAction'] = $this->_getFullAction($baseAction, 'update');
    	$projMacro['updateDoAction'] = $this->_getFullAction($baseAction, 'update_do');
    	$projMacro['deleteAction'] = $this->_getFullAction($baseAction, 'delete');
    	$projMacro['deleteDoAction'] = $this->_getFullAction($baseAction, 'delete_do');
    	$projMacro['errorBoxFile'] = $templates['_errorbox']['path'];
    	$projMacro['noticeBoxFile'] = $templates['_noticebox']['path'];
    	$projMacro['model'] = $model;
    	$projMacro['modelName'] = ucfirst($table_id);
    	$projMacro['modelPK'] = $idDefine;
    	$projMacro['project_id'] = $this->ctl->getAppId();
		
        foreach ($templates as $name => $value) {
        	$tpl_path = $this->ctl->getDefaultForwardPath($this->_getFullAction($baseAction, $name));
        	
        	// FormBox TemplateFile.
        	if (isset($value['path'])) {
        		$tpl_path = $value['path'];
        	}
        	
        	$macro = array_merge($value, $projMacro);
        	
        	// �ե���������
        	Ethna_Util::mkdir(dirname("$tpl_dir/$tpl_path"), 0755);
			$skel = "skel.scaffold-template-{$value['template']}.tpl";
	        if (file_exists("$tpl_dir$tpl_path")) {
	            printf("file [%s] already exists -> skip\n", "$tpl_dir$tpl_path");
	        } else if ($this->_generateFile($skel, "$tpl_dir$tpl_path", $macro) == false) {
	            printf("[warning] file creation failed [%s]\n", "$tpl_dir$tpl_path");
	        } else {
	            printf("template file(s) successfully created [%s]\n", "$tpl_dir$tpl_path");
	        }
        }
        $true = true;
        return $true;
	}
	
	/**
	 * �ꥹ�ȤΥإå���ʬ����������
	 * 
	 * @access private
	 * @param $model array ��ǥ����
	 * @return string ����
	 */
	function _getListHeaderTags($model, $modelName)
	{
		$tag = "";
		
		$tagColumn = array();
		foreach($model as $name => $value) {
			$tagColumn[] = "			<th>{model_column model='{$modelName}' column='{$name}'}</th>";
		}
		
		$tag = implode("\n", $tagColumn);
		
		return $tag;
	}
	
	/**
	 * �ꥹ�ȤΥᥤ����ʬ�Υ�������������
	 * 
	 * @access private
	 * @param $model array ��ǥ����
	 * @return string ����
	 */
	function _getListMainTags($model)
	{
		$tag = "";
		
		$tagColumn = array();
		foreach ($model as $name => $value) {
			$tagColumn[] = "			<td>{\$item.{$name}}</td>";
		}
		
		$tag = implode("\n", $tagColumn);
		
		return $tag;
	}
	
	/**
	 * �����ƥ�Υᥤ����ʬ�Υ�������������
	 * 
	 * @access private
	 * @param $model array ��ǥ����
	 * @return string ����
	 */
	function _getItemMainTag($model, $modelName)
	{
		$tag = "";
		$tagColumn = array();
		foreach ($model as $name=>$value) {
			$tagColumn[] = "		<tr><th>{model_column model='{$modelName}' column='{$name}'}</th>" . '<td>{$app.{$modelName}.' . "{$name}" . '}</td></tr>';
		}
		
		$tag = implode("\n", $tagColumn);
		
		return $tag;
	}
	
	/**
	 * �ե�����Υ�������������
	 * 
	 * @access private
	 * @param $model array ActionForm���
	 * @return string ����
	 */
	function _getFormMainTag($formDef, $allow=null, $deny=null)
	{
		$tag = "";
		$tagColumn = array();
		foreach ($formDef as $name => $value) {
			if (is_array($deny) && in_array($name, $deny)) {
				continue;
			}
			
			if ((is_array($allow) && in_array($name, $allow)) || $allow == null) {
				$tagColumn[] = "		<tr><th>{form_name name=\"{$name}\"}</th><td>{form_input name=\"{$name}\"}</td></tr>";
			}
		}
		
		$tag = implode("\n", $tagColumn);
		
		return $tag;
	}
}
?>