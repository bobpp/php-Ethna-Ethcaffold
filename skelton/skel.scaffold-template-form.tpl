<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=EUC-JP" />

<title>{$project_id} - {$title}</title>
</head>

<body>
	<h1>{$title}</h1>
	
{include file="{$errorBoxFile}"}

{include file="{$noticeBoxFile}"}
	
{form ethna_action="{$action}" default=$form}
{$app_ne.hiddens}
	<table>
{$formTag}
		<tr><td colspan="2">{form_submit value="Submit"}</td></tr>
	</table>
{/form}

	<a href="?action_{$listAction}=true">Back to list</a>
</body>

</html>