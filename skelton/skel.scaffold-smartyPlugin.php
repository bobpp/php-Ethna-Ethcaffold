<?php
/**
 * {$file_path}
 * 
 * smarty plugins for {$app_id}
 * 
 * @author		BoBpp < bobpp@users.sourceforge.jp >
 * @package	projBop.Ethna.Scaffold
 * @version		$Id$
 */
 
// Scaffold用オブジェクトいれ
define('ETHNA_SCAFFOLD_MODELS', "__ethna_appObjects_proto");

/**
 * モデルのカラム名を表示する
 * 
 * sample:
 * <code>
 * {model_column model="user" column="name"}
 * </code>
 * <code>
 * ユーザ名
 * </code>
 * 
 * @param string $model モデル名
 * @param string $column カラム名
 */
function smarty_function_model_column($params, &$smarty)
{
	if (isset($params['model']) === false || isset($params['column']) === false) {
		return null;
	}
	
	if (isset($GLOBALS[ETHNA_SCAFFOLD_MODELS][$params['model']]) === false) {
		$controller =& Ethna_Controller::getInstance();
		$backend =& $controller->getBackend();
		$GLOBALS[ETHNA_SCAFFOLD_MODELS][$params['model']] =& $backend->getObject($params['model']);
	}
	$model =& $GLOBALS[ETHNA_SCAFFOLD_MODELS][$params['model']];
	
	if (method_exists($model, 'getColumnName')) {
		return $model->getColumnName($params['column']);
	} else {	
		return $params['column'];
	}
}

/**
 * モデル名を表示する
 * 
 * sample:
 * <code>
 * {model_name model="user"}
 * </code>
 * <code>
 * ユーザ
 * </code>
 * 
 * @param string $model モデル名
 */
function smarty_function_model_name($params, &$smarty)
{
	if (isset($params['model']) === false) {
		return null;
	}
	
	if (isset($GLOBALS[ETHNA_SCAFFOLD_MODELS][$params['model']]) === false) {
		$controller =& Ethna_Controller::getInstance();
		$backend =& $controller->getBackend();
		$GLOBALS[ETHNA_SCAFFOLD_MODELS][$params['model']] =& $backend->getObject($params['model']);
	}
	$model =& $GLOBALS[ETHNA_SCAFFOLD_MODELS][$params['model']];
	
	if (method_exists($model, 'getColumnName')) {
		return $model->getModelName();
	} else {	
		return $params['model'];
	}
}
?>
