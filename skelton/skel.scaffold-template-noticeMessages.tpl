{if count($app.notices)}
	<ul class="noticeMessages">
  {foreach from=$app.notices item=notice}
		<li>{$notice}</li>
  {/foreach}
	</ul>
{/if}