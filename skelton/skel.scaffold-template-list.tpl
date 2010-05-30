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
	
	<a href="?action_{$createAction}=true">Create {model_name model='{$modelName}'}</a>
	
	<table>
		<tr>
{$headerTag}
			<th>&nbsp;</th>
		</tr>
{foreach from=$app.{$modelName}List item=item}
		<tr>
{$mainTag}
			<td>
				<a href="?action_{$readAction}=true&{$modelPK}={$item.{$modelPK}}">Show</a>
				<a href="?action_{$updateAction}=true&{$modelPK}={$item.{$modelPK}}">Edit</a>
				<a href="?action_{$deleteAction}=true&{$modelPK}={$item.{$modelPK}}">Destroy</a>
			</td>
		</tr>
{/foreach}
	</table>
	
</body>

</html>