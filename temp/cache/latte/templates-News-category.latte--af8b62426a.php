<?php
// source: D:\studenti\it3\novinky\app\presenters/templates/News/category.latte

use Latte\Runtime as LR;

class Templateaf8b62426a extends Latte\Runtime\Template
{
	public $blocks = [
		'content' => 'blockContent',
		'_show_author' => 'blockShow_author',
		'_show_commentary' => 'blockShow_commentary',
	];

	public $blockTypes = [
		'content' => 'html',
		'_show_author' => 'html',
		'_show_commentary' => 'html',
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
		if (isset($this->params['comment'])) trigger_error('Variable $comment overwritten in foreach on line 14');
		if (isset($this->params['article'])) trigger_error('Variable $article overwritten in foreach on line 9, 25');
		if (isset($this->params['commentary'])) trigger_error('Variable $commentary overwritten in foreach on line 46');
		Nette\Bridges\ApplicationLatte\UIRuntime::initialize($this, $this->parentName, $this->blocks);
		
	}


	function blockContent($_args)
	{
		extract($_args);
?>
    <!-- Page Content -->
    <div class="container">
        <!-- Heading Row -->
        <h1><?php echo LR\Filters::escapeHtmlText(call_user_func($this->filters->upper, $category)) /* line 6 */ ?></h1>
        <div class="row">   
            <main class="col-md-8">
<?php
		$iterations = 0;
		foreach ($data as $article) {
?>
                <article>
                    <h2><a href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("News:view", [$article->id])) ?>"><?php
			echo LR\Filters::escapeHtmlText($article->title) /* line 11 */ ?></a></h2>
                    <p><?php echo call_user_func($this->filters->truncate, $article->content, 200) /* line 12 */ ?></p>
<?php
			$comments = 0;
			$iterations = 0;
			foreach ($article->related('comments.news_id') as $comment) {
				$comments += 1;
				$iterations++;
			}
			?>                    <p><small>Publikováno: <b><?php echo LR\Filters::escapeHtmlText(call_user_func($this->filters->date, $article->created_at, 'd.m.Y')) /* line 17 */ ?></b>, Autor: <a id="dialog-author-init" href="<?php
			echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("author!", [$article->id])) ?>"><?php
			echo LR\Filters::escapeHtmlText($article->ref('users','user_id')->name) /* line 17 */ ?></a>, 
                            Počet komentářů: <a href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("commentaries!", [$article->id])) ?>"><?php
			echo LR\Filters::escapeHtmlText($comments) /* line 18 */ ?></a></small></p>
                </article>
<?php
			$iterations++;
		}
?>
            </main>
            <aside class="col-md-">
                <h2>Přehled článků</h2>
<?php
		$activeYear = 0;
		$iterations = 0;
		foreach ($years as $article) {
			if ($activeYear != $article->year) {
				$activeYear = $article->year;
				?>                        <h3><?php echo LR\Filters::escapeHtmlText($article->year) /* line 28 */ ?></h3>    
<?php
			}
?>
                    <article>
                        <h4><a href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("News:view", [$article->id])) ?>"><?php
			echo LR\Filters::escapeHtmlText($article->title) /* line 31 */ ?></a></h4>
                    </article>
<?php
			$iterations++;
		}
?>
            </aside>
        </div>
<div id="<?php echo htmlSpecialChars($this->global->snippetDriver->getHtmlId('show_author')) ?>"><?php $this->renderBlock('_show_author', $this->params) ?></div>
<div id="<?php echo htmlSpecialChars($this->global->snippetDriver->getHtmlId('show_commentary')) ?>"><?php
		$this->renderBlock('_show_commentary', $this->params) ?></div>    </div>        
<?php
	}


	function blockShow_author($_args)
	{
		extract($_args);
		$this->global->snippetDriver->enter("show_author", "static");
		if ($author) {
?>
                <div id="dialog-author" title="Autor článku">
                    <div><?php echo LR\Filters::escapeHtmlText($author->name) /* line 39 */ ?></div>
                </div>    
<?php
		}
		$this->global->snippetDriver->leave();
		
	}


	function blockShow_commentary($_args)
	{
		extract($_args);
		$this->global->snippetDriver->enter("show_commentary", "static");
		if ($commentaries) {
			$iterations = 0;
			foreach ($commentaries as $commentary) {
?>
                    <div>
                        <p><small><?php echo LR\Filters::escapeHtmlText(call_user_func($this->filters->date, $commentary->created_at, 'd.m.Y')) /* line 48 */ ?></small></p>
                        <p><?php echo LR\Filters::escapeHtmlText($commentary->content) /* line 49 */ ?></p>
                    </div>                
<?php
				$iterations++;
			}
		}
		$this->global->snippetDriver->leave();
		
	}

}
