<?php
// source: C:\xampp\htdocs\novinky\app\presenters/templates/News/view.latte

use Latte\Runtime as LR;

class Template20e9d53576 extends Latte\Runtime\Template
{
	public $blocks = [
		'title' => 'blockTitle',
		'content' => 'blockContent',
		'head' => 'blockHead',
		'scripts' => 'blockScripts',
	];

	public $blockTypes = [
		'title' => 'html',
		'content' => 'html',
		'head' => 'html',
		'scripts' => 'html',
	];


	function main()
	{
		extract($this->params);
		if ($this->getParentName()) return get_defined_vars();
		$this->renderBlock('title', get_defined_vars());
?>

<?php
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
		if (isset($this->params['comment'])) trigger_error('Variable $comment overwritten in foreach on line 19');
		Nette\Bridges\ApplicationLatte\UIRuntime::initialize($this, $this->parentName, $this->blocks);
		
	}


	function blockTitle($_args)
	{
?>Článek
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
            <main class="col-md-8">
                <article>
                    <h2><?php echo LR\Filters::escapeHtmlText($data->title) /* line 13 */ ?></h2>
                    <p><?php echo $data->content /* line 14 */ ?></p>
                    <div id="stars-default"><input type="hidden" name="rating"></div>
                </article>
                <hr>
                <h3>Komentáře k článku (celkem: <?php echo LR\Filters::escapeHtmlText(count($data->related('comments.news_id'))) /* line 18 */ ?>)</h3>
<?php
		$iterations = 0;
		foreach ($data->related('comments.news_id') as $comment) {
?>
                <blockquote class="hidden">    
                    <h4><a href="mailto:<?php echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($comment->ref('users','user_id')->email)) /* line 21 */ ?>"><?php
			echo LR\Filters::escapeHtmlText($comment->ref('users','user_id')->name) /* line 21 */ ?></a>, 
                        <i class="text-muted"><?php echo LR\Filters::escapeHtmlText(call_user_func($this->filters->date, $comment->created_at, '%d. %m. %Y, %H:%m')) /* line 22 */ ?></i></h4>
                    <p><?php echo LR\Filters::escapeHtmlText($comment->content) /* line 23 */ ?></p>
<?php
			if (in_array('administrator',$user->getRoles())) {
				?>                        <p><a href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("deleteComment!", [$data->id,$comment->id])) ?>">Smazat</a></p>
<?php
			}
?>
                </blockquote>    
<?php
			$iterations++;
		}
		if (count($data->related('comments.news_id'))!=0) {
?>
            <p><a href="#" class="btn btn-default" id="all-comments">Zobrazit komentáře</a></p>
<?php
		}
		if ($user->isLoggedIn()) {
?>
                <div>                    
<?php
			/* line 34 */ $_tmp = $this->global->uiControl->getComponent("commentForm");
			if ($_tmp instanceof Nette\Application\UI\IRenderable) $_tmp->redrawControl(NULL, FALSE);
			$_tmp->render();
?>
                </div>
<?php
		}
?>
            </main>
            <aside class="col-md-4"> 
<?php
		if ($author->photo) {
			?>                <p><img src="<?php echo LR\Filters::escapeHtmlAttr(call_user_func($this->filters->datastream, $author->photo)) /* line 40 */ ?>" class="img-responsive img-circle"></p>
<?php
		}
		else {
			?>                <p><img src="<?php echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 42 */ ?>/images/person2.jpg" class="img-responsive img-circle"></p>
<?php
		}
		?>                <h3><?php echo LR\Filters::escapeHtmlText($author->name) /* line 44 */ ?></h3>
                <p><?php echo LR\Filters::escapeHtmlText($author->email) /* line 45 */ ?></p>
                <p><?php echo LR\Filters::escapeHtmlText($author->role) /* line 46 */ ?></p>
            </aside>
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
    </style>    
<?php
	}


	function blockScripts($_args)
	{
		extract($_args);
		$this->renderBlockParent('scripts', get_defined_vars());
		?>    <script src="<?php echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 60 */ ?>/js/bootstrap-star-rating.js"></script>
    <script>
        var link = <?php echo LR\Filters::escapeJs($this->global->uiControl->link("vote!")) ?>;
        var id = <?php echo LR\Filters::escapeJs($data->id) /* line 63 */ ?>;
        $(function() {            
            $("a#all-comments").on("click",function(){
                if ($(this).text()=='Zobrazit komentáře') { 
                    $(this).text('Skrýt komentáře');
                } else {    
                    $(this).text('Zobrazit komentáře');
                }
                $("blockquote").toggleClass('hidden');
            });
            
<?php
		if (in_array('administrator',$user->getRoles())) {
			?>           $("#stars-default").rating('create',{'value': <?php echo LR\Filters::escapeJs($data->stars) /* line 75 */ ?>, onClick:function(){ 
                $.nette.ajax({
                    url: link,
                    type: 'POST',
                    data: {
                        id : id,
                        data : this.attr('data-rating')
                    },
                    success: function (payload) {
                        console.log(data);
                    }
                });                                      
               }
           });
<?php
		}
		else {
			?>           $("#stars-default").rating('create',{'value': <?php echo LR\Filters::escapeJs($data->stars) /* line 90 */ ?>});
<?php
		}
?>
            //$("#stars-default").rating('create',{'coloron':'green',onClick:function(){ alert('rating is ' + this.attr('data-rating')); }});
        })
    </script>    
<?php
	}

}
