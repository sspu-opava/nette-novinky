<?php
// source: D:\studenti\it3\novinky\app\presenters/templates/Homepage/default.latte

use Latte\Runtime as LR;

class Templatef29cabfce0 extends Latte\Runtime\Template
{
	public $blocks = [
		'title' => 'blockTitle',
		'content' => 'blockContent',
	];

	public $blockTypes = [
		'title' => 'html',
		'content' => 'html',
	];


	function main()
	{
		extract($this->params);
		if ($this->getParentName()) return get_defined_vars();
		$this->renderBlock('title', get_defined_vars());
		$this->renderBlock('content', get_defined_vars());
		return get_defined_vars();
	}


	function prepare()
	{
		extract($this->params);
		if (isset($this->params['item'])) trigger_error('Variable $item overwritten in foreach on line 15, 25');
		Nette\Bridges\ApplicationLatte\UIRuntime::initialize($this, $this->parentName, $this->blocks);
		
	}


	function blockTitle($_args)
	{
?>Úvodní stránka
<?php
	}


	function blockContent($_args)
	{
		extract($_args);
?>
    <!-- Page Content -->
    <div class="container">
        <!-- Heading Row -->
        <div class="row">
            <div class="col-md-8">
                <img class="img-responsive img-rounded" src="<?php echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 11 */ ?>/images/news.jpg" alt="News">
            </div>
            <!-- /.col-md-8 -->
            <div class="col-md-4">
<?php
		$iterations = 0;
		foreach ($latest as $item) {
			?>                <h1><?php echo LR\Filters::escapeHtmlText(call_user_func($this->filters->upper, $item->title)) /* line 16 */ ?></h1>
                <a class="btn btn-primary btn-lg" href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("News:view", [$item->id])) ?>">Podrobnosti zde</a>
<?php
			$iterations++;
		}
?>
            </div>
            <!-- /.col-md-4 -->
        </div>
        <!-- /.row -->
        <!-- Content Row -->
        <div class="row" id="uvodnik">
<?php
		$iterations = 0;
		foreach ($news as $item) {
?>
            <div class="col-md-4">
                <h2><?php echo LR\Filters::escapeHtmlText($item->category) /* line 27 */ ?></h2>
                <figure><img src="<?php echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 28 */ ?>/images/<?php
			echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($item->category)) /* line 28 */ ?>.jpg" class="img img-responsive img-rounded" alt="<?php
			echo LR\Filters::escapeHtmlAttr($item->category) /* line 28 */ ?>"></figure>                    
                <h3><a href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("News:view", [$item->id])) ?>"><?php
			echo LR\Filters::escapeHtmlText($item->title) /* line 29 */ ?></a></h3>
                <p class="small"><i class="fa fa-calendar-o" aria-hidden="true"></i>
 <a href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("News:category", [$item->category])) ?>"><?php
			echo LR\Filters::escapeHtmlText($item->category) /* line 31 */ ?></a> | <?php echo LR\Filters::escapeHtmlText(call_user_func($this->filters->date, $item->created_at, 'd.m.Y')) /* line 31 */ ?></p>
                <p><?php echo call_user_func($this->filters->truncate, $item->content, 200) /* line 32 */ ?></p>
                <a class="btn btn-default" href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("News:view", [$item->id])) ?>">Čti dále</a>
            </div>
<?php
			$iterations++;
		}
?>
        </div>
        <div class="row">
            <div class="col-sm-8">
                <h3 class="text-center bg-primary">Kontaktní formulář</h3>
<?php
		$form = $_form = $this->global->formsStack[] = $this->global->uiControl["contactForm"];
		?>            <form class="form-horizontal" role="form"<?php
		echo Nette\Bridges\FormsLatte\Runtime::renderFormBegin(end($this->global->formsStack), array (
		'class' => NULL,
		'role' => NULL,
		), FALSE) ?>>
                <div class="form-group">
                    <label class="col-sm-4 control-label"<?php
		$_input = end($this->global->formsStack)["name"];
		echo $_input->getLabelPart()->addAttributes(array (
		'class' => NULL,
		))->attributes() ?>>Jméno</label>
                    <div class="col-sm-8">
                        <input class="form-control"<?php
		$_input = end($this->global->formsStack)["name"];
		echo $_input->getControlPart()->addAttributes(array (
		'class' => NULL,
		))->attributes() ?>>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label"<?php
		$_input = end($this->global->formsStack)["email"];
		echo $_input->getLabelPart()->addAttributes(array (
		'class' => NULL,
		))->attributes() ?>>E-mail</label>
                    <div class="col-sm-8">
                        <input class="form-control"<?php
		$_input = end($this->global->formsStack)["email"];
		echo $_input->getControlPart()->addAttributes(array (
		'class' => NULL,
		))->attributes() ?>>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label"<?php
		$_input = end($this->global->formsStack)["message"];
		echo $_input->getLabelPart()->addAttributes(array (
		'class' => NULL,
		))->attributes() ?>>Zpráva</label>
                    <div class="col-sm-8">
                        <textarea class="form-control" rows=5<?php
		$_input = end($this->global->formsStack)["message"];
		echo $_input->getControlPart()->addAttributes(array (
		'class' => NULL,
		'rows' => NULL,
		))->attributes() ?>><?php echo $_input->getControl()->getHtml() ?></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-8 col-sm-offset-4">
                        <input class="btn btn-primary"<?php
		$_input = end($this->global->formsStack)["send"];
		echo $_input->getControlPart()->addAttributes(array (
		'class' => NULL,
		))->attributes() ?>>
                    </div>
                </div>                
<?php
		echo Nette\Bridges\FormsLatte\Runtime::renderFormEnd(array_pop($this->global->formsStack), FALSE);
?>            </form>
            </div>
        </div>
        <!-- /.row -->

        <!-- Footer -->
        <footer>
            <div class="row">
                <div class="col-lg-12">
                    <p>Copyright &copy; SŠPU Opava 2017</p>
                </div>
            </div>
        </footer>
    </div>
<?php
	}

}
