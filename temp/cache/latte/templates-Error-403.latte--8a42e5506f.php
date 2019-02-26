<?php
// source: C:\xampp\htdocs\novinky\app\presenters/templates/Error/403.latte

use Latte\Runtime as LR;

class Template8a42e5506f extends Latte\Runtime\Template
{
	public $blocks = [
		'content' => 'blockContent',
		'title' => 'blockTitle',
	];

	public $blockTypes = [
		'content' => 'html',
		'title' => 'html',
	];


	function main()
	{
		extract($this->params);
		if ($this->getParentName()) return get_defined_vars();
		$this->renderBlock('content', get_defined_vars());
		return get_defined_vars();
	}


	function prepare()
	{
		extract($this->params);
		Nette\Bridges\ApplicationLatte\UIRuntime::initialize($this, $this->parentName, $this->blocks);
		
	}


	function blockContent($_args)
	{
		extract($_args);
?>
<div class="container">
<?php
		$this->renderBlock('title', get_defined_vars());
?>
<p>Nemáte dostatečná oprávnění k prohlížení stránky.<br>Kontaktujte, prosím, správce webu,
   pokud jste přesvědčeni, že byste měli mít povolen přístup na tuto stránku.</p>
<p><small>Chyba 403</small></p>
</div><?php
	}


	function blockTitle($_args)
	{
		extract($_args);
?><h1>Přístup na tuto stránku byl zakázán</h1>
<?php
	}

}
