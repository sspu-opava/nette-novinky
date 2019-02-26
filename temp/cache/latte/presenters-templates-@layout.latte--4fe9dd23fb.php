<?php
// source: C:\xampp\htdocs\novinky\app\presenters/templates/@layout.latte

use Latte\Runtime as LR;

class Template4fe9dd23fb extends Latte\Runtime\Template
{
	public $blocks = [
		'head' => 'blockHead',
		'scripts' => 'blockScripts',
	];

	public $blockTypes = [
		'head' => 'html',
		'scripts' => 'html',
	];


	function main()
	{
		extract($this->params);
?>
<!DOCTYPE html>
<html>
<head>
<?php
		if ($this->getParentName()) return get_defined_vars();
		$this->renderBlock('head', get_defined_vars());
?>
</head>

<body>
    <!-- Navigation -->
    <nav class="navbar navbar-fixed-top" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("Homepage:default")) ?>">
                    <img src="<?php echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 43 */ ?>/images/logo.png" alt="Logo">
                </a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li class="dropdown">
                      <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Rubriky <span class="caret"></span></a>
                      <ul class="dropdown-menu">
                        <li><a href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("News:category", ['politika'])) ?>">Politika</a></li>
                        <li><a href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("News:category", ['sport'])) ?>">Sport</a></li>
                        <li><a href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("News:category", ['zabava'])) ?>">Zábava</a></li>
                      </ul>
                    </li>                    
                </ul>
                <ul class="nav navbar-nav navbar-right">
<?php
		if (in_array('administrator',$user->getRoles())) {
?>
                    <li class="dropdown">
                      <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Administrace <span class="caret"></span></a>
                      <ul class="dropdown-menu">
                        <li><a href="<?php echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 63 */ ?>/clanky">Články</a></li>
                        <li><a href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("User:list")) ?>">Účty</a></li>
                        <li><a href="#">Komentáře</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="#">Konfigurace aplikace</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="#">Záloha</a></li>
                      </ul>
                    </li>
<?php
		}
		if ($user->isLoggedIn()) {
?>
                    <li class="dropdown">
                      <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php
			echo LR\Filters::escapeHtmlText($user->getIdentity()->username) /* line 75 */ ?> <span class="caret"></span></a>
                      <ul class="dropdown-menu">
<?php
			if ($user->isAllowed('News')) {
				?>                        <li><a href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("News:list")) ?>">Moje články</a></li>
<?php
			}
			if ($user->isAllowed('News','commentaries')) {
				?>                        <li><a href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("News:commentaries")) ?>">Moje komentáře</a></li>
<?php
			}
?>
                        <li role="separator" class="divider"></li>
                        <li><a href="#">Změna profilu</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("Sign:out")) ?>">Odhlášení</a></li>
                      </ul>
                    </li>
<?php
		}
		else {
?>
                    <li>
                        <a href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("Sign:in")) ?>">Přihlášení</a>
                    </li>
                    <li>
                        <a href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("Sign:up")) ?>">Registrace</a>
                    </li>
<?php
		}
?>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>
    <div class="container">            
<?php
		$iterations = 0;
		foreach ($flashes as $flash) {
			?>        <div<?php if ($_tmp = array_filter(['flash', $flash->type])) echo ' class="', LR\Filters::escapeHtmlAttr(implode(" ", array_unique($_tmp))), '"' ?>><?php
			echo LR\Filters::escapeHtmlText($flash->message) /* line 104 */ ?></div>
<?php
			$iterations++;
		}
?>
    </div>
<?php
		$this->renderBlock('content', $this->params, 'html');
?>
    
<?php
		$this->renderBlock('scripts', get_defined_vars());
?>
</body>
</html>
<?php
		return get_defined_vars();
	}


	function prepare()
	{
		extract($this->params);
		if (isset($this->params['flash'])) trigger_error('Variable $flash overwritten in foreach on line 104');
		Nette\Bridges\ApplicationLatte\UIRuntime::initialize($this, $this->parentName, $this->blocks);
		
	}


	function blockHead($_args)
	{
		extract($_args);
?>
    <meta charset="utf-8">
    <title>Novinky | <?php
		if (isset($this->blockQueue["title"])) {
			$this->renderBlock('title', $this->params, function ($s, $type) {
				$_fi = new LR\FilterInfo($type);
				return LR\Filters::convertTo($_fi, 'html', $this->filters->filterContent('striphtml', $_fi, $s));
			});
		}
?></title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Zpravodajský server v Nette Framework">
    <meta name="author" content="Marek Lučný">
    <!-- Bootstrap Core CSS -->
    <link href="<?php echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 16 */ ?>/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="<?php echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 18 */ ?>/css/small-business.css" rel="stylesheet">
    <link href="<?php echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 19 */ ?>/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">    
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <link rel="stylesheet" href="<?php echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 26 */ ?>/css/style.css">
<?php
	}


	function blockScripts($_args)
	{
		extract($_args);
?>
        <!-- jQuery -->
        <script src="<?php echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 110 */ ?>/js/jquery.js"></script>
        <!-- Bootstrap Core JavaScript -->
        <script src="<?php echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 112 */ ?>/js/bootstrap.min.js"></script>
        <script>
            $.fn.bootstrapBtn = $.fn.button.noConflict();
        </script>
	<!--<script src="https://nette.github.io/resources/js/netteForms.min.js"></script> -->
        <script src="<?php echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 117 */ ?>/js/jquery-ui.min.js"></script>
        <script src="<?php echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 118 */ ?>/js/nette.ajax.js"></script>        
	<script src="<?php echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 119 */ ?>/js/main.js"></script>
<?php
	}

}
