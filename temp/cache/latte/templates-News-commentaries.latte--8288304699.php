<?php
// source: C:\xampp\htdocs\novinky\app\presenters/templates/News/commentaries.latte

use Latte\Runtime as LR;

class Template8288304699 extends Latte\Runtime\Template
{
	public $blocks = [
		'content' => 'blockContent',
		'head' => 'blockHead',
		'scripts' => 'blockScripts',
	];

	public $blockTypes = [
		'content' => 'html',
		'head' => 'html',
		'scripts' => 'html',
	];


	function main()
	{
		extract($this->params);
		if ($this->getParentName()) return get_defined_vars();
		$this->renderBlock('content', get_defined_vars());
?>

<?php
		$this->renderBlock('head', get_defined_vars());
?>

<?php
		$this->renderBlock('scripts', get_defined_vars());
		return get_defined_vars();
	}


	function prepare()
	{
		extract($this->params);
		if (isset($this->params['comment'])) trigger_error('Variable $comment overwritten in foreach on line 9');
		Nette\Bridges\ApplicationLatte\UIRuntime::initialize($this, $this->parentName, $this->blocks);
		
	}


	function blockContent($_args)
	{
		extract($_args);
?>
<div class="container">
    <h2>Moje komentáře</h2>
    <!-- Heading Row -->
    <div class="row">            
        <div class="col-xs-12">
<?php
		$iterations = 0;
		foreach ($data as $comment) {
?>
                <blockquote>
                    <h4><a href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("News:view", [$comment->news_id])) ?>"><?php
			echo LR\Filters::escapeHtmlText($comment->ref('news','news_id')->title) /* line 11 */ ?></a>, 
                        <i class="text-muted"><?php echo LR\Filters::escapeHtmlText(call_user_func($this->filters->date, $comment->created_at, '%d. %m. %Y, %H:%m')) /* line 12 */ ?></i> <span class="caret"></span></h4>
                    <p><?php echo LR\Filters::escapeHtmlText($comment->content) /* line 13 */ ?></p>
                </blockquote>    
<?php
			$iterations++;
		}
?>
        </div>
    </div>    
</div>
<?php
	}


	function blockHead($_args)
	{
		extract($_args);
		$this->renderBlockParent('head', get_defined_vars());
?>
    <style>
        blockquote p {
            display: none;
        }
    </style>    
<?php
	}


	function blockScripts($_args)
	{
		extract($_args);
		$this->renderBlockParent('scripts', get_defined_vars());
?>
    <script>
        $(function() {
            $("span.caret").on("click",function(){
                $(this).parent().next('p').toggle(500);
            });
        })
    </script>    
<?php
	}

}
