<?php
/**
 * Ethna_Plugin_Generator_ScaffoldSmartyPlugin.php
 * 
 * @author BoBpp < bobpp@users.sourceforge.jp >
 * @package projBop.Ethna.Scaffold
 */

/**
 * ScaffoldSmartyPlugin Generator Plugin
 * 
 * @access public
 * @author BoBpp < bobpp@users.sourceforge.jp >
 * @package projBop.Ethna.Scaffold
 */
class Ethna_Plugin_Generator_ScaffoldSmartyPlugin extends Ethna_Plugin_Generator
{
	/**
	 * ScaffoldSmartyPlugin を生成する
	 * 
	 * @access public
	 */
	function &generate()
	{
 		$app_dir = $this->ctl->getDirectory('app');
        $app_path = ucfirst($this->ctl->getAppId()) . '_ScaffoldSmartyPlugin.php';
		
		$macro = array();
		$macro['project_id'] = $this->ctl->getAppId();
		$macro['file_path'] = $app_path;
		
		$user_macro = $this->_getUserMacro();
		
		$macro = array_merge($macro, $user_macro);
		
		// ファイル生成
		$filePath = "$app_dir/$app_path";
		Ethna_Util::mkdir(dirname($filePath), 0755);
		$skelton = "skel.scaffold-smartyPlugin.php";
        if (file_exists($filePath)) {
            printf("file [%s] already exists -> skip\n", $filePath);
        } else if ($this->_generateFile($skelton, $filePath, $macro) == false) {
            printf("[warning] file creation failed [%s]\n", $filePath);
        } else {
            printf("action script(s) successfully created [%s]\n", $filePath);
        }
        $true = true;
        return $true;
	}
}
?>