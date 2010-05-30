<?php
/**
 * Ethna_Plugin_Handle_Scaffold.php
 * 
 * @author BoBpp < bobpp@users.sourceforge.jp >
 * @package projBop.Ethna.Scaffold
 */

/**
 * Scaffold Command Plugin
 * 
 * @access public
 * @author BoBpp < bobpp@users.sourceforge.jp >
 * @package projBop.Ethna.Scaffold
 */
class Ethna_Plugin_Handle_Scaffold extends Ethna_Plugin_Handle
{
	/**
	 * コマンドの概要を表示する
	 * 
	 * @access public
	 * @return string コマンド概要
	 */
	function getDescription()
	{
		return <<<EOS
Create Action, View, Template, AppObject, AppManager and SmartyPlugin for CRUD:
    {$this->id} [-b|--basedir=dir] [-o|--overwrite=(force|interactive)] [-s|--skelton-namespace=namespace (Not Implemented)] [base action] [model]

EOS;
	}
	
	/**
	 * 使用法を表示する
	 * 
	 * @access private
	 * @return コマンド使用方法
	 */
	function getUsage()
	{
		return <<<EOS
ethna {$this->id} [-b|--basedir=dir] [-s|--skelton-namespace=namespace] [base action] [model]
EOS;
	}
	
	/**
	 * コマンドの実装
	 * 
	 * @access public
	 * @return mixed 成否結果(true=>成功, Ethna_Error=>失敗)
	 */
	function &perform()
	{
		// 引数取得
		$r = $this->_getopt(array("basedir=", "overwrite=","skelton-namespace="));
		if (Ethna::isError($r)) {
			return $r;
		}
		list($optlist, $arglist) = $r;
		
		$r =& Ethna_Controller::checkActionName($arglist[0]);
		if (Ethna::isError($r)) {
			return $r;
		}
		
		// 引数処理
		$app_dir = isset($optlist['basedir']) ? $optlist['basedir'] : getcwd();
		$baseAction = $arglist[0];
		$model = $arglist[1];
		
		// アプリケーションController取得
		$c =& Ethna_Handle::getAppController($app_dir);
		if (Ethna::isError($c)) {
			echo 'Not found Project Directory!';
			return $c;
		}
		
		// Backend取得
		$backend =& $c->getBackend();
		
		$generator =& new Ethna_Generator();		
		
		// Template AppObject生成
		$r =& $generator->generate('ScaffoldTemplateAppObject', $app_dir);
		if (Ethna::isError($r)) {
			return $r;
		}
		
		// AppObject生成
		$r =& $generator->generate('ScaffoldAppObject', $app_dir, $model);
		if (Ethna::isError($r)) {
			return $r;
		}
		
		// AppObject取得
		$appObj =& $backend->getObject($model);
		$modelDefine = $appObj->prop_def;
		$idDefine = $appObj->getIdDef();
		
		// ActionForm定義
		$formDefine = $this->_getActionFormDefine($model, $modelDefine);
		
		// カラム名定義
		$r =& $generator->generate('ScaffoldColumnName', $app_dir, $model, $modelDefine);
		if (Ethna::isError($r)) {
			return $r;
		}
		
		// BaseActionForm Generator
		$r =& $generator->generate('ScaffoldActionForm', $app_dir, $model, $modelDefine, $formDefine);
		if (Ethna::isError($r)) {
			return $r;
		}
		
		// Actions Generator
		$r =& $generator->generate('ScaffoldActions', $app_dir, $baseAction, $model, $modelDefine, $idDefine, $formDefine);
		if (Ethna::isError($r)) {
			return $r;
		}
		
		// Views Generator
		$r =& $generator->generate('ScaffoldViews', $app_dir, $baseAction, $model, $modelDefine, $idDefine, $formDefine);
		if (Ethna::isError($r)) {
			return $r;
		}
		
		// Templates Generator
		$r =& $generator->generate('ScaffoldTemplates', $app_dir, $baseAction, $model, $modelDefine, $idDefine, $formDefine);
		if (Ethna::isError($r)) {
			return $r;
		}
		
		// Smarty Plugin
		$r =& $generator->generate('ScaffoldSmartyPlugin', $app_dir);
		if (Ethna::isError($r)) {
			return $r;
		}
		
		// UnitTestCase Generator
		// UnitTestCase GeneratorはEthcaffoldの標準に含まれているものではないため無い場合がある
		$r =& $generator->generate('UnitTestCase', $app_dir, $model);
		if (Ethna::isError($r)) {
			if ($r->getCode() !== E_PLUGIN_NOTFOUND) {
				return $r;
			}
		}
		
		$true = true;
		return $true;
	}
			
	/**
	 * ActionFormの定義を返す
	 * 
	 * @access public
	 * @param string $model モデル名
	 * @param array $modelDefine モデル定義
	 * @return array フォーム定義
	 */
	function _getActionFormDefine($model, $modelDefine)
	{
		// システムで自動的に付加される値
		$autoColumn = array('created_at', 'updated_at', 'deleted_at');
		
		$table_id = preg_replace('/_(.)/e', "strtoupper('\$1')", ucfirst($model));
		
		// フォーム定義生成
		$formDef = array();
		foreach ($modelDefine as $name=>$value) {
			if (in_array($name, $autoColumn) === false && isset($value['form_name'])) {
				$formDef[$value['form_name']] = array();
				
				// フォーム名
				$modelDefName = strtoupper($table_id);
				$nameDefName = strtoupper($name);
				$formDef[$value['form_name']]['name'] = "SCAFFOLD_COLUMN_NAME_{$modelDefName}_{$nameDefName}";
				
				// 値タイプ
				switch($value['type']) {
				case VAR_TYPE_INT:
					$type = "VAR_TYPE_INT";
					break;
				
				case VAR_TYPE_DATETIME:
					$type = "VAR_TYPE_DATETIME";
					break;
				
				case VAR_TYPE_STRING:
				default:
					$type = "VAR_TYPE_STRING";
					break;
				}
				$formDef[$value['form_name']]['type'] = $type;
				
				// フォーム種類
				$formDef[$value['form_name']]['form_type'] = "FORM_TYPE_TEXT";
				
				// 日付である場合はデフォルト値を設定
				if ($value['type'] == VAR_TYPE_DATETIME) {
					$formDef[$value['form_name']]['default'] = "'0000-00-00 00:00:00'";
				}
				
				// 必須チェック
				if (isset($value['required'])) {
					$required = ($value['required']) ? "true" : "false";
				} else {
					$required = "false";
				}
				$formDef[$value['form_name']]['required'] = $required;
				
				// 最大値の設定
				// Bugs on MyTrac[#42]
				if ($value['type'] == VAR_TYPE_STRING && isset($value['length'])) {
					$formDef[$value['form_name']]['max'] = intval($value['length']);
				}
			}
		}
		
		return $formDef;
	}
}
?>
