<?php

namespace App\Presenters;

use App\Model\NewsManager;
use App\Model\UserManager;
use Tracy\Debugger;
use Nette\Application\UI\Form;
use Nette\Application\ForbiddenRequestException;
use Nette\Application\BadRequestException;

class NewsPresenter extends BasePresenter {

    private $newsManager, $userManager;
   
    function __construct(NewsManager $newsManager, UserManager $userManager) {
        $this->newsManager = $newsManager;
        $this->userManager = $userManager;
    }

    protected function startup() {
        parent::startup();
/*        if (!$this->getUser()->isAllowed()) {
            throw new ForbiddenRequestException();
        }*/
    }
        
    public function actionDelete($id) {
        if (!$this->getUser()->isLoggedIn()) $this->redirect('Sign:in');
        $this->newsManager->delete($id);
        $this->redirect("list");
    }

    public function handleDeleteComment($news_id, $comment_id)
    {
        $this->newsManager->deleteComment($comment_id);
        $this->flashMessage("Komentář byl úspěšně smazán");        
        $this->redirect('this',$news_id);
    }
    
    public function handleAuthor($id)
    {
        $this->template->author = $this->newsManager->getById($id)->ref('users', 'user_id');
        //Debugger::dump($this->template->author);
        if ($this->isAjax()) {
            $this->redrawControl('show_author');
        }
    }
    
    public function handleCommentaries($id)
    {
        $this->template->commentaries = $this->newsManager->getById($id)->related('comments.news_id');
        //Debugger::dump($this->template->author);
        if ($this->isAjax()) {
            $this->redrawControl('show_commentary');
        }
    }
    
    public function handleVote() {
        $httpRequest = $this->getPresenter()->getHttpRequest();
        if($this->isAjax()){   
            $this->newsManager->updateStars($httpRequest->getPost('id'),$httpRequest->getPost('data'));
        }
    }
    
       
    public function renderView($id) {
        if (!$this->template->data = $this->newsManager->getById($id)) throw new BadRequestException();
        $this->template->author = $this->template->data->ref('users', 'user_id');
    }

    public function renderCategory($category) {
        $this->template->category = $category;
        $this->template->data = $this->newsManager->getByCategory($category);
        $this->template->years = $this->newsManager->getCategoryByYear($category);
        if (!isset($this->template->author))
            $this->template->author = null;
        if (!isset($this->template->commentaries))
            $this->template->commentaries = null;
        //Debugger::dump($this->template->years);
        //Debugger::log($this->template->latest);
    }

    public function renderCommentaries() {
        if (!$this->getUser()->isLoggedIn()) $this->redirect('Sign:in');
        $user_id = $this->getUser()->getId();
        $this->template->data = $this->newsManager->getCommentaries($user_id);
    }
    
    public function renderList() {
        if (!$this->getUser()->isAllowed('News','list')) {
            throw new ForbiddenRequestException();
        }
        $this->template->data = $this->newsManager->getAll();
    }

    public function renderInsert() {
        if (!$this->getUser()->isAllowed('News','insert')) {
            throw new ForbiddenRequestException();
        }
        $data = array();
        $this['newsForm']->setDefaults($data);                
    }

    public function renderUpdate($id) {
        Debugger::barDump($this->getUser()->getRoles());
        if (!$data = $this->newsManager->getById($id)) throw new BadRequestException();        
        if ($data->user_id != $this->getUser()->getId() && !in_array('administrator',$this->getUser()->getRoles()))
            throw new ForbiddenRequestException();
        $this['newsForm']->setDefaults($data);                
    }
    
    /**
     * Vytváří a vrací komponentu formuláře pro přidání knihy.
     * @return Form komponenta formuláře pro přidání knihy
     */
    public function createComponentNewsForm() {                
        $form = new Form;

        $form->addText("title", "Titulek zprávy")
                ->setAttribute("size", 50)
                ->addRule(Form::MAX_LENGTH, "%label musí mít nejvýše %d znaků", 100)
                ->setRequired();

        $form->addTextArea("content", "Obsah zprávy")
                ->setAttribute("cols", 100)
                ->setAttribute("rows", 10)
                ->setAttribute('class', 'mceEditor')
                ->setRequired(FALSE);

        $form->addSelect("category", "Rubrika", array(
                    'politika' => 'politika',
                    'zábava' => 'zábava',
                    'sport' => 'sport'))
                ->setRequired(TRUE)
                ->setPrompt("Vyberte rubriku");
        
        if (in_array('administrator',$this->getUser()->getRoles())) {
            $authors = $this->userManager->getAuthors();
            $form->addSelect("user_id", "Autor", $authors)
                 ->setDefaultValue($this->getUser()->getId());   
        }
        
        $form->addSubmit('submit', 'Odeslat')
             ->setAttribute("class", "btn btn-success");

        $form->onSuccess[] = array($this, 'newsFormSucceeded');

        $this->renderForm($form);

        return $form;
    }
    
    public function newsFormSucceeded(Form $form, $values) {
        $id = $this->getParameter("id");
        $values['user_id'] = empty($values['user_id']) ? $this->getUser()->getId() : $values['user_id'];
        if ($id) {
            $this->newsManager->update($id, $values);
            $this->flashMessage("Záznam byl úspěšně upraven");            
        } else {            
            $this->newsManager->insert($values);
            $this->flashMessage("Záznam byl úspěšně vložen");                        
        }
        $this->redirect("list");
    }

    /**
     * Vytváří a vrací komponentu formuláře pro přidání knihy.
     * @return Form komponenta formuláře pro přidání knihy
     */
    public function createComponentCommentForm() {
        $form = new Form;

        $form->addTextArea("content")
                ->setAttribute("cols", 80)
                ->setAttribute("rows", 10)
                ->setRequired("Vložte, prosím, text komentáře.");

        $form->addSubmit('submit', 'Vložit nový komentář')
             ->setAttribute("class", "btn btn-success");

        $form->onSuccess[] = array($this, 'commentFormSucceeded');

        return $form;
    }
    
    public function commentFormSucceeded(Form $form, $values) {
        $values['news_id'] = $this->getParameter("id");
        $values['user_id'] = $this->getUser()->getId();
        $this->newsManager->addComment($values);
        $this->flashMessage("Komentář byl úspěšně vložen");
        $this->redirect('this');
    }
    
}
