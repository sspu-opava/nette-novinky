<?php
// source: C:\xampp\htdocs\novinky\app\presenters/templates/Sign/out.latte

use Latte\Runtime as LR;

class Template36336b806e extends Latte\Runtime\Template
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
		?><p><a href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("in")) ?>">Přihlásit se k jinému účtu</a></p>
</div>
<?php
	}


	function blockTitle($_args)
	{
		extract($_args);
?><h1>Byl(a) jste odhlášen(a)</h1>
<?php
	}

}
