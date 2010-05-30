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
 
// Scaffold�ѥ��֥������Ȥ���
define('ETHNA_SCAFFOLD_MODELS', "__ethna_appObjects_proto");

/**
 * ��ǥ�Υ����̾��ɽ������
 * 
 * sample:
 * <code>
 * {model_column model="user" column="name"}
 * </code>
 * <code>
 * �桼��̾
 * </code>
 * 
 * @param string $model ��ǥ�̾
 * @param string $column �����̾
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
 * ��ǥ�̾��ɽ������
 * 
 * sample:
 * <code>
 * {model_name model="user"}
 * </code>
 * <code>
 * �桼��
 * </code>
 * 
 * @param string $model ��ǥ�̾
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
