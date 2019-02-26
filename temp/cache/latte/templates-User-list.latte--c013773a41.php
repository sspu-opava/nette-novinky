<?php
// source: C:\xampp\htdocs\novinky\app\presenters/templates/User/list.latte

use Latte\Runtime as LR;

class Templatec013773a41 extends Latte\Runtime\Template
{
	public $blocks = [
		'add_head' => 'blockAdd_head',
		'content' => 'blockContent',
		'add_scripts' => 'blockAdd_scripts',
	];

	public $blockTypes = [
		'add_head' => 'html',
		'content' => 'html',
		'add_scripts' => 'html',
	];


	function main()
	{
		extract($this->params);
		if ($this->getParentName()) return get_defined_vars();
		$this->renderBlock('add_head', get_defined_vars());
		$this->renderBlock('content', get_defined_vars());
		$this->renderBlock('add_scripts', get_defined_vars());
		return get_defined_vars();
	}


	function prepare()
	{
		extract($this->params);
		if (isset($this->params['row'])) trigger_error('Variable $row overwritten in foreach on line 23');
		Nette\Bridges\ApplicationLatte\UIRuntime::initialize($this, $this->parentName, $this->blocks);
		
	}


	function blockAdd_head($_args)
	{
?><link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/colreorder/1.3.2/css/colReorder.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.2.2/css/buttons.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css">
<?php
	}


	function blockContent($_args)
	{
		extract($_args);
?>
<div class="container">
    <h1>Seznam uživatelů</h1>
    <!-- Heading Row -->
    <div class="row">            
        <div class="col-xs-12">
            <table class="table table-striped table-responsive" id="list">
                <thead>
                    <tr>
                        <th>Uživatelské jméno</th>
                        <th>Uživatel</th>
                        <th>Role</th>
                        <th>Akce</th>
                    </tr>    
                </thead>    
                <tbody>
<?php
		$iterations = 0;
		foreach ($data as $row) {
?>
                        <tr>
                            <td><?php echo LR\Filters::escapeHtmlText($row->username) /* line 25 */ ?></td>
                            <td><?php echo LR\Filters::escapeHtmlText($row->name) /* line 26 */ ?></td>
                            <td><?php echo LR\Filters::escapeHtmlText($row->role) /* line 27 */ ?></td>
                            <td><a class="btn btn-primary" href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("User:update", [$row->id])) ?>">Upravit</a>
                                <a class="btn btn-danger" href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("News:view", [$row->id])) ?>">Smazat</a></td>
                        </tr>    
<?php
			$iterations++;
		}
?>
                </tbody>    
            </table>  
            <p><a class="btn btn-success" href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("User:create")) ?>">Nový</a></td></p>  
        </div>
    </div>                  
</div>
<?php
	}


	function blockAdd_scripts($_args)
	{
		extract($_args);
?>
<script type="text/javascript" language="javascript" src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/colreorder/1.3.2/js/dataTables.colReorder.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.print.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 48 */ ?>/js/jszip.js"></script>
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
