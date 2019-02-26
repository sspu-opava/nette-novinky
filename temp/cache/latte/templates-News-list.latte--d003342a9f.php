<?php
// source: C:\xampp\htdocs\novinky\app\presenters/templates/News/list.latte

use Latte\Runtime as LR;

class Templated003342a9f extends Latte\Runtime\Template
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
		$this->renderBlock('head', get_defined_vars());
?>

<?php
		$this->renderBlock('scripts', get_defined_vars());
		return get_defined_vars();
	}


	function prepare()
	{
		extract($this->params);
		if (isset($this->params['row'])) trigger_error('Variable $row overwritten in foreach on line 19');
		Nette\Bridges\ApplicationLatte\UIRuntime::initialize($this, $this->parentName, $this->blocks);
		
	}


	function blockContent($_args)
	{
		extract($_args);
?>
<div class="container">
    <h1>Přehled článků</h1>
    <!-- Heading Row -->
    <div class="row">            
        <div class="col-xs-12">
            <table class="table table-striped table-responsive" id="list">
                <thead>
                    <tr>
                        <th>Titulek</th>
                        <th>Rubrika</th>
                        <th>Publikováno</th>
                        <th>Autor</th>
                        <th>Akce</th>
                    </tr>    
                </thead>    
                <tbody>
<?php
		$iterations = 0;
		foreach ($data as $row) {
			if ($user->getId() == $row->user_id || in_array('administrator',$user->getRoles())) {
?>
                        <tr>
                            <td><a href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("News:view", [$row->id])) ?>"><?php
				echo LR\Filters::escapeHtmlText($row->title) /* line 22 */ ?></a></td>
                            <td><?php echo LR\Filters::escapeHtmlText($row->category) /* line 23 */ ?></td>
                            <td><?php echo LR\Filters::escapeHtmlText(call_user_func($this->filters->date, $row->created_at, 'd.m.Y')) /* line 24 */ ?></td>
                            <td><?php echo LR\Filters::escapeHtmlText($row->ref('users','user_id')->username) /* line 25 */ ?></td>
                            <td>
                                <a class="btn btn-primary" href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("News:update", [$row->id])) ?>">Upravit</a>
                                <a class="btn btn-danger" href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("News:delete", [$row->id])) ?>">Smazat</a>
                            </td>
                        </tr>    
<?php
			}
			$iterations++;
		}
?>
                </tbody>    
            </table>  
            <p><a class="btn btn-success" href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("News:insert")) ?>">Nový</a></td></p>  
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
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/colreorder/1.3.2/css/colReorder.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.2.2/css/buttons.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css">
<?php
	}


	function blockScripts($_args)
	{
		extract($_args);
		$this->renderBlockParent('scripts', get_defined_vars());
?>
<script type="text/javascript" language="javascript" src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/colreorder/1.3.2/js/dataTables.colReorder.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.print.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 57 */ ?>/js/jszip.js"></script>
<script>
    $(document).ready(function () {
        $('#list').DataTable({
            lengthMenu: [5, 10, 50, "vše"],
            colReorder: true,
            dom: '<"row"<"col-md-6"l><"col-md-6"f>>rt<"row"<"col-md-4"i><"col-md-4"p><"col-md-4"B>>',
            buttons: [
                {
                    extend: 'copy',
                    text: 'Zkopírovat do schránky'
                },
                {
                    extend: 'pdfHtml5',
                    orientation: 'landscape',
                    pageSize: 'LEGAL'
                },
                'print', 'excel',
            ],
            language: {
                "sEmptyTable": "Tabulka neobsahuje žádná data",
                "sInfo": "Zobrazuji _START_ až _END_ z celkem _TOTAL_ záznamů",
                "sInfoEmpty": "Zobrazuji 0 až 0 z 0 záznamů",
                "sInfoFiltered": "(filtrováno z celkem _MAX_ záznamů)",
                "sInfoPostFix": "",
                "sInfoThousands": " ",
                "sLengthMenu": "Zobraz záznamů _MENU_",
                "sLoadingRecords": "Načítám...",
                "sProcessing": "Provádím...",
                "sSearch": "Hledat:",
                "sZeroRecords": "Žádné záznamy nebyly nalezeny",
                "oPaginate": {
                    "sFirst": "První",
                    "sLast": "Poslední",
                    "sNext": "Další",
                    "sPrevious": "Předchozí"
                },
                "oAria": {
                    "sSortAscending": ": aktivujte pro řazení sloupce vzestupně",
                    "sSortDescending": ": aktivujte pro řazení sloupce sestupně"
                }
            },
        });
    });
</script>

<?php
	}

}
