<?php
// source: C:\xampp\htdocs\novinky\app\presenters/templates/Error/404.latte

use Latte\Runtime as LR;

class Template6f384a11c1 extends Latte\Runtime\Template
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

<p>Stránka, kterou požadujete, nebyla nalezena. Možná byla zadána nesprávná adresa, 
   nebo zadaná stránka už neexistuje. Použijte, prosím, vyhledávač k nalezení informací,
   které hledáte.</p>

<p><small>Chyba 404</small></p>
</div><?php
	}


	function blockTitle($_args)
	{
		extract($_args);
?><h1>Stránka nebyla nalezena</h1>
<?php
	}

}
