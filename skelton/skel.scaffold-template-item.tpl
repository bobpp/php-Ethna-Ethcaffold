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
	
	<a href="?action_{$updateAction}=true&{$modelPK}={$app.{$modelName}.{$modelPK}}">Edit</a> | <a href="?action_{$deleteAction}=true&{$modelPK}={$app.{$modelName}.{$modelPK}}">Destroy</a> | <a href="?action_{$listAction}=true">Back</a>
	
</body>

</html>
