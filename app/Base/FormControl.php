<?php declare(strict_types=1);

namespace Chap\Base;

use Kdyby\Autowired\AutowireComponentFactories;
use Kdyby\Translation\ITranslator;
use Nepada\FormRenderer\Bootstrap3Renderer;
use Nette\Application\LinkGenerator;
use Nette\Application\UI\Control;
use Nette\Application\UI\Form;
use Nette\Application\UI\ITemplateFactory;

abstract class FormControl extends Control
{
    use AutowireComponentFactories;



    /**  @var LinkGenerator */
    public $links;

    /** @var ITranslator */
    public $translator;

    protected $templateName = 'template.latte';

    /**
     * @param \Doctrine\ORM\EntityManager $em
     * @param LinkGenerator $lg
     * @param ITranslator   $it
     * @return Form
     */
    public function createComponentForm(LinkGenerator $lg, ITranslator $it, ITemplateFactory $templateFactory): Form
    {
        $this->links = $lg;
        $this->translator = $it;
        $form = new Form();
        $form->setRenderer(new Bootstrap3Renderer($templateFactory));
        $form->onSuccess[] = [$this, 'success'];
        $form->setTranslator($this->translator);
        $this->init($form);

        return $form;
    }

    /**
     * @throws \ReflectionException
     */
    public function render(): void
    {
        $reflection = new \ReflectionClass($this);
        $this->getTemplate()
            ->setFile(\dirname($reflection->getFileName()) . DIRECTORY_SEPARATOR . $this->templateName)
            ->render();
    }

    abstract public function success(Form $form, $values): void;

    abstract public function init(Form $form): void;

}

 