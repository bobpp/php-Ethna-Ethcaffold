{if count($errors)}
	<h3 class="formError">�����ͤ˥��顼������ޤ������Ϥ��줿�ͤ򤴳�ǧ����������</h3>
	<ul class="formError">
  {foreach from=$errors item=error}
		<li>{$error}</li>
  {/foreach}
	</ul>
{/if}