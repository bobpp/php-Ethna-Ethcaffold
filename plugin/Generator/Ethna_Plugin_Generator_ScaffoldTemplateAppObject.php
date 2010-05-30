<?php
/**
 * Ethna_Plugin_Generator_ScaffoldTemplateAppObject.php
 * 
 * @author BoBpp < bobpp@users.sourceforge.jp >
 * @package projBop.Ethna.Scaffold
 */

/**
 * ScaffoldTemplateAppObject Generator Plugin
 * 
 * @access public
 * @author BoBpp < bobpp@users.sourceforge.jp >
 * @package projBop.Ethna.Scaffold
 */
class Ethna_Plugin_Generator_ScaffoldTemplateAppObject extends Ethna_Plugin_Generator
{
	/**
	 * ScaffoldAppObject を生成する
	 * 
	 * @access public
	 */
	function &generate()
	{
        $app_dir = $this->ctl->getDirectory('app');
        $app_path = ucfirst($this->ctl->getAppId()) . '_AppBase_AppObject.php';

        $macro = array();
        $macro['project_id'] = $this->ctl->getAppId();
        $macro['app_path'] = $app_path;
        $user_macro = $this->_getUserMacro();
        $macro = array_merge($macro, $user_macro);

        $path = "$app_dir/$app_path";
        Ethna_Util::mkdir(dirname($path), 0755);
        if (file_exists($path)) {
            printf("file [%s] already exists -> skip\n", $path);
        } else if ($this->_generateFile("skel.scaffold-template-appobject.php", $path, $macro) == false) {
            printf("[warning] file creation failed [%s]\n", $path);
        } else {
            printf("app-object script(s) successfully created [%s]\n", $path);
        }
        
        $true = true;
        return $true;
	}
}
?>