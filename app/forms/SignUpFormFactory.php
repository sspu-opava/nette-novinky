<?php

namespace App\Forms;

use Nette;
use Nette\Application\UI\Form;
use App\Model;


class SignUpFormFactory
{
	use Nette\SmartObject;

	const PASSWORD_MIN_LENGTH = 7;

	/** @var FormFactory */
	private $factory;

	/** @var Model\UserManager */
	private $userManager;


	public function __construct(FormFactory $factory, Model\UserManager $userManager)
	{
		$this->factory = $factory;
		$this->userManager = $userManager;
	}


	/**
	 * @return Form
	 */
	public function create(callable $onSuccess)
	{
		$form = $this->factory->create();
		$form->addText('username', 'Zadejte uživatelské jméno:')
			->setRequired('Vložte, prosím, uživatelské jméno.');

		$form->addEmail('email', 'Zadejte e-mail:')
			->setRequired('Zadejte, prosím, váš e-mail.');

		$form->addPassword('password', 'Zadejte heslo:')
			->setOption('description', sprintf('minimálně %d znaků', self::PASSWORD_MIN_LENGTH))
			->setRequired('Vytvořte, prosím, heslo.')
			->addRule($form::MIN_LENGTH, NULL, self::PASSWORD_MIN_LENGTH);

		$form->addSubmit('send', 'Zaregistrovat se');

		$form->onSuccess[] = function (Form $form, $values) use ($onSuccess) {
			try {
				$this->userManager->add($values->username, $values->email, $values->password);
			} catch (Model\DuplicateNameException $e) {
				$form['username']->addError('Uživatelské jméno je už používáno.');
				return;
			}
			$onSuccess();
		};

		return $form;
	}

}
