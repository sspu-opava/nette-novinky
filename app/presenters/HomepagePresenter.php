<?php

namespace App\Presenters;

use App\Model\NewsManager;
use Nette\Application\UI\Form;
use Nette\Mail\Message;
use Nette\Mail\SmtpMailer;

class HomepagePresenter extends BasePresenter {

    private $newsManager;
    
    function __construct(NewsManager $newsManager) {
        $this->newsManager = $newsManager;
    }
    
    public function renderDefault() {        
        $this->template->latest = $this->newsManager->getLatest(1,0);
        $this->template->news = $this->newsManager->getLatest(3,1);
        $this->template->user = $this->getUser();
        //Debugger::dump($this->template->latest);
        //Debugger::log($this->template->latest);
    }

    /**
     * Contact form
     */
    protected function createComponentContactForm()
    {
        $form = new Form;
        $form->addText('name', 'Jméno:')
            ->addRule(Form::FILLED, 'Zadejte jméno');
        $form->addText('email', 'Email:')
            ->addRule(Form::FILLED, 'Zadejte email')
            ->addRule(Form::EMAIL, 'Email nemá správný formát');
        $form->addTextarea('message', 'Zpráva:')
            ->addRule(Form::FILLED, 'Zadejte zprávu');
        $form->addSubmit('send', 'Odeslat');

        $form->onSuccess[] = [$this, 'processContactForm'];
        $this->renderForm($form);
        return $form;
    }


    /**
     * Process contact form, send message
     * @param Form
     */
    public function processContactForm(Form $form)
    {
        $values = $form->getValues(TRUE);

        $message = new Message;
        $mailer = new SmtpMailer([
             'host' => 'localhost',
             'username' => 'newuser@localhost',
             'password' => '',
             //'secure' => 'ssl',
        ]);
        $message->addTo('news@localhost.org')
            ->setFrom($values['email'])
            ->setSubject('Zpráva z kontaktního formuláře')
            ->setBody($values['message']);
        $mailer->send($message);

        $this->flashMessage('Zpráva byla odeslána');
        $this->redirect('this');
    }    
}
