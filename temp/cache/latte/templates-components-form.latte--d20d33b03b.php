<?php
// source: C:\xampp\htdocs\novinky\app\presenters\templates\components\form.latte

use Latte\Runtime as LR;

class Templated20d33b03b extends Latte\Runtime\Template
{
	public $blocks = [
		'form' => 'blockForm',
	];

	public $blockTypes = [
		'form' => 'html',
	];


	function main()
	{
		extract($this->params);
		if ($this->getParentName()) return get_defined_vars();
		return get_defined_vars();
	}


	function prepare()
	{
		extract($this->params);
		if (isset($this->params['error'])) trigger_error('Variable $error overwritten in foreach on line 4');
		if (isset($this->params['input'])) trigger_error('Variable $input overwritten in foreach on line 8');
		Nette\Bridges\ApplicationLatte\UIRuntime::initialize($this, $this->parentName, $this->blocks);
		
	}


	function blockForm($_args)
	{
		extract($this->params);
		list($form) = $_args + [NULL, ];
		$form = $_form = $this->global->formsStack[] = is_object($form) ? $form : $this->global->uiControl[$form];
		?>	<form<?php
		echo Nette\Bridges\FormsLatte\Runtime::renderFormBegin(end($this->global->formsStack), array (
		), FALSE) ?>>
<?php
		if ($form->ownErrors) {
?>	<ul class=error>
<?php
			$iterations = 0;
			foreach ($form->ownErrors as $error) {
				?>		<li><?php echo LR\Filters::escapeHtmlText($error) /* line 4 */ ?></li>
<?php
				$iterations++;
			}
?>
	</ul>
<?php
		}
?>

	<table>
<?php
		$iterations = 0;
		foreach ($form->controls as $input) {
			if (!$input->getOption('rendered') && $input->getOption('type') !== 'hidden') {
				?>	<tr<?php if ($_tmp = array_filter([$input->required ? 'required' : NULL])) echo ' class="', LR\Filters::escapeHtmlAttr(implode(" ", array_unique($_tmp))), '"' ?>>

		<th><?php
				$_input = is_object($input) ? $input : end($this->global->formsStack)[$input];
				if ($_label = $_input->getLabel()) echo $_label ?></th>
		<td><?php
				$_input = is_object($input) ? $input : end($this->global->formsStack)[$input];
				echo $_input->getControl() /* line 13 */ ?> <?php
				ob_start(function () {});
				?><span class=error><?php
				ob_start();
				echo LR\Filters::escapeHtmlText($input->error) /* line 13 */;
				$this->global->ifcontent = ob_get_flush();
				?></span><?php
				if (rtrim($this->global->ifcontent) === "") ob_end_clean();
				else echo ob_get_clean();
?>
</td>
	</tr>
<?php
			}
			$iterations++;
		}
?>
	</table>
<?php
		echo Nette\Bridges\FormsLatte\Runtime::renderFormEnd(array_pop($this->global->formsStack), FALSE);
?>	</form>
<?php
	}

}
