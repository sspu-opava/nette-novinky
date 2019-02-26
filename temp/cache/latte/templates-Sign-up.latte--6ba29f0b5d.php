<?php
// source: C:\xampp\htdocs\novinky\app\presenters/templates/Sign/up.latte

use Latte\Runtime as LR;

class Template6ba29f0b5d extends Latte\Runtime\Template
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
		$this->renderBlock('bootstrap-form', ['signUpForm'] + $this->params, 'html');
?>

<p><a href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("in")) ?>">Máte už svůj účet? Přihlaste se.</a></p>
</div><?php
	}


	function blockTitle($_args)
	{
		extract($_args);
?><h1>Registrace</h1>
<?php
	}

}
