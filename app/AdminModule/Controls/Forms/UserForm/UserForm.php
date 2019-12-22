<?php declare(strict_types=1);

namespace Chap\AdminModule\Controls\Forms\UserForm;

use Chap\Base\FormControl;
use Chap\Models\Entities\User;
use Nette\Application\UI\Form;

class UserForm extends FormControl
{
    private $id;



    public function init(Form $form): void
    {
        $form->addGroup();
        $form->addText('name', 'Login name')
            ->setRequired('Fill login name')->controlPrototype->addAttributes(['maxlength' => 45]);
        $pass = $form->addPassword('password1', 'Password');
        $pass2 = $form->addPassword('password2', 'Password 2');
        $pass2->addConditionOn($pass, Form::FILLED)
            ->setRequired()
            ->addRule(Form::EQUAL, 'Passwords must be same', $pass);
        $pass->addConditionOn($pass2, Form::FILLED)
            ->setRequired()
            ->addRule(Form::EQUAL, 'Passwords must be same', $pass2);

        if (!$this->id) {
            $pass->setRequired('Fill password');
            $pass2->setRequired('Fill password');
        }
        $form->addText('realName', 'Full name', null, 45)->setRequired('Fill full name');
        $form->addText('webName', 'Web name', null, 45)->setRequired('Fill web name');

        $form->addSelect('role', 'Role', User::$ALL_ROLES);

        $form->addCheckbox('active', 'Active');
        $form->addGroup('Contact info');

        $form->addText('email', 'Email', null, 150);
        $form->addText('street', 'Street', null, 100);
        $form->addText('postcode', 'Postcode', null, 10);
        $form->addText('city', 'City', null, 60);
        $form->addText('phone', 'Phone', null, 20);

        $bd = $form->addText('birthdayx', 'Birthday');
        $bd->controlPrototype->addAttributes(['class' => 'datepicker form-control dateinputstart']);

        $form->addGroup('Company');
        $form->addSubmit('send', 'Save')->setOption('btn-class', 'btn-success btn');
        $form->onValidate[] = [$this, 'validate'];


    }

    /**
     * @param Form $form
     */
    public function validate(Form $form): void
    {
        if ($form->hasErrors()) {
            $this->presenter->flashMessage('Form has some errors!!', 'danger');
        }
    }

    /**
     * @param EntityForm $form
     * @param            $values
     * @throws \Exception
     */
    public function success(Form $form, $values): void
    {

    }

}