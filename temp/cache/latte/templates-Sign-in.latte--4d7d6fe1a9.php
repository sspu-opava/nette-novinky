<?php
// source: C:\xampp\htdocs\novinky\app\presenters/templates/Sign/in.latte

use Latte\Runtime as LR;

class Template4d7d6fe1a9 extends Latte\Runtime\Template
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


<?php
		$this->createTemplate('../components/bootstrap-form.latte', $this->params, "import")->render();
		$this->renderBlock('bootstrap-form', ['signInForm'] + $this->params, 'html');
?>


<p><a href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("up")) ?>">Nemáte ještě svůj účet? Zaregistrujte se.</a></p>
</div>
<?php
	}


	function blockTitle($_args)
	{
		extract($_args);
?><h1>Přihlášení</h1>
<?php
	}

}
