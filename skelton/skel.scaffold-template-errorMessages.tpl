{if count($errors)}
	<h3 class="formError">入力値にエラーがあります、入力された値をご確認ください。</h3>
	<ul class="formError">
  {foreach from=$errors item=error}
		<li>{$error}</li>
  {/foreach}
	</ul>
{/if}