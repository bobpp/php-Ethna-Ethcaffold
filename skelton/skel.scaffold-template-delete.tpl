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
	
	<table>
{$itemTag}
	</table>

{form}
{$app_ne.hiddens}
	<input type="submit" name="action_{$deleteDoAction}" value="Delete" />
{/form}
	
	<a href="?action_{$readAction}=true&{$modelPK}={$app.{$modelName}.{$modelPK}}">Show</a> | <a href="?action_{$listAction}=true">Back to list</a>
</body>

</html>