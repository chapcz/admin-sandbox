<?php declare(strict_types=1);

namespace Chap\AdminModule\Controls\Forms\UserForm;

use Chap\Models\Entities\User;
use Doctrine\ORM\EntityManagerInterface;
use Kdyby\Translation\ITranslator;
use Nepada\FormRenderer\Bootstrap3Renderer;
use Nette\Application\AbortException;
use Nette\Application\LinkGenerator;
use Nette\Application\UI\Control;
use Nette\Application\UI\Form;
use Nette\Application\UI\ITemplateFactory;
use Nette\Forms\IFormRenderer;
use Nettrine\Hydrator\IHydrator;

class UserForm extends Control
{
    private $id;

    /**  @var LinkGenerator */
    public $links;

    /** @var ITranslator */
    public $translator;

    /** @var IFormRenderer */
    public $formRenderer;

    /** @var IHydrator */
    public $hydrator;

    /** @var EntityManagerInterface */
    public $entityManager;

    private $idEdit;

    /** @var callable[]&(callable(Form, User): void)[] */
    public $onUserSave = [];


    /**
     * @param int|null               $id
     * @param LinkGenerator          $lg
     * @param ITranslator            $it
     * @param ITemplateFactory       $templateFactory
     * @param IHydrator              $hydration
     * @param EntityManagerInterface $em
     */
    public function __construct(?int $id, LinkGenerator $lg, ITranslator $it, ITemplateFactory $templateFactory, IHydrator $hydration, EntityManagerInterface $em)
    {
        $this->links = $lg;
        $this->idEdit = $id;
        $this->translator = $it;
        $this->formRenderer = new Bootstrap3Renderer($templateFactory);
        $this->entityManager = $em;
        $this->hydrator = $hydration;
    }

    public function createComponentForm(): Form
    {
        $form = new Form();
        $form->addHidden('id');
        $form->setRenderer($this->formRenderer);
        $form->onSuccess[] = [$this, 'success'];
        $form->setTranslator($this->translator);
        $form->addText('name', 'Login name')
            ->setRequired('Fill login name')
            ->controlPrototype->addAttributes(['maxlength' => 45]);
        $form->addText('realName', 'Full name', null, 45)
            ->setRequired('Fill full name');
        $form->addText('email', 'Email', null, 45)
            ->setRequired('Fill email');
        $form->addSelect('role', 'Role', User::$ALL_ROLES);
        $form->addSubmit('send', 'Save')
            ->setOption('btn-class', 'btn-success btn');
        if ($this->idEdit) {
            $user = $this->entityManager->getRepository(User::class)->find($this->idEdit);
            $form->setDefaults($this->hydrator->toArray($user));
        }

        return $form;
    }

    /**
     * @param Form $form
     * @param      $values
     * @throws AbortException
     */
    public function success(Form $form, $values): void
    {
        $entity = $this->idEdit ?
            $this->hydrator->toFields($this->entityManager->getRepository(User::class)->find($this->idEdit), $values) :
            $this->hydrator->toFields(User::class, $values);
        $this->entityManager->persist($entity);
        $this->entityManager->flush();
        $this->onUserSave($this, $entity);
    }

    public function render(): void
    {
        $this->getTemplate()
            ->setFile(__DIR__ . DIRECTORY_SEPARATOR . 'template.latte')
            ->render();
    }

}