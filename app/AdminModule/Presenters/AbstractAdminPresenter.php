<?php

namespace Chap\AdminModule\Presenters;

use Chap\AdminLTE\AdminControl;
use Chap\AdminLTE\Components\InfoBox\InfoBoard;
use Chap\AdminLTE\Components\InfoBox\InfoBox;
use Chap\AdminLTE\Components\LazyScreen\LazyScreen;
use Chap\AdminLTE\IAdminControlFactory;
use Chap\AdminLTE\Notifications\BasePanel;
use Chap\AdminLTE\Notifications\LinkPanel;
use Chap\AdminLTE\Notifications\MessagePanel;
use Chap\AdminLTE\Notifications\NotificationPanel;
use Chap\AdminLTE\Notifications\TaskPanel;
use Chap\AdminModule\Controls\Async\SlowComponent\ISlowComponentFactory;
use Chap\AdminModule\Controls\Forms\UserForm\IUserFormFactory;
use Chap\AdminModule\Controls\Forms\UserForm\UserForm;
use Kdyby\Autowired\AutowireComponentFactories;
use Kdyby\Autowired\AutowireProperties;
use Nette\Application\UI\Form;

/**
 * Class AdminPresenter
 * @secured
 */
class AbstractAdminPresenter extends SecuredPresenter
{
    use AutowireProperties;
    use AutowireComponentFactories;

    /**
     * @var IAdminControlFactory
     */
    private $adminControlFactory;

  //  /** @var IUserGridFactory @inject */
  //  public $userGridFactory;

    /** @var IUserFormFactory @inject */
    public $userFormFactory;

    /** @var ISlowComponentFactory @inject */
    public $slowComponentFactory;

    /** @var integer */
    protected $id;

    public function __construct(IAdminControlFactory $adminControlFactory)
    {
        parent::__construct();
        $this->adminControlFactory = $adminControlFactory;
    }

    protected function startup()
    {
        parent::startup();
        if ($this->getParameter('no_layout',false)){
            $this->setLayout(false);
        }
    }

    /**
     * @return AdminControl
     * @throws \Nette\Application\UI\InvalidLinkException
     */
    protected function createComponentAdmin(): AdminControl
    {
        $admin = $this->adminControlFactory
            ->create()
            ->addPanel($this->getExampleNotificationsPanel())
            ->addPanel($this->getExampleTasksPanel())
            ->addPanel($this->getMessagesPanel2())
            ->addPanel($this->getMessagesPanel());

        $admin->onSearch[] = function (Form $form) {
            $this->redirect('search', ['word' => $form->getValues()['q']]);
        };

        return $admin;
    }

    /**
     * @return InfoBoard
     * @throws \Exception
     */
    protected function createComponentDashBoard(): InfoBoard
    {
        return (new InfoBoard())
            ->setColSpan(6)
            ->addBox((new InfoBox())
                ->setColor('red')
                ->setLink('#')
                ->setIcon('pencil')
                ->setNumber(1222)
                ->setProgress(90)
                ->setText('Pencil text')
            )
            ->addBox((new InfoBox())
                ->setColor('green')
                ->setIcon('globe')
                ->setText('Globe text')
                ->setNumber((float) random_int(0, 9999))
            );
    }

    private function getExampleNotificationsPanel() :NotificationPanel
    {
        return (new NotificationPanel(null))
            ->setLinkAll('#')
            ->setCounter(50)
            ->setHeaderTitle('%d Notifications')
            ->addNotification('#', 'Something')
            ->addNotification('#', 'Something')
            ->addNotification('#', 'Something')
            ;
    }

    /**
     * @return MessagePanel
     * @throws \Nette\Application\UI\InvalidLinkException
     */
    private function getMessagesPanel() :MessagePanel
    {
        return (new MessagePanel())
            ->setLinkAll('#')
            ->setCounter(2)
            ->setHeaderTitle('%d messages')
            ->addMessage($this->link('alert!', 'Link from MessagePanel: Hallo '), 'Hallo', 'world !', '/images/message.png', '2 hours ago')
            ->addMessage($this->link('alert!', 'Link from MessagePanel: This '), 'This', 'is message', '/images/message.png', '3 hours ago');
    }

    /**
     * @return BasePanel
     * @throws \Nette\Application\UI\InvalidLinkException
     */
    private function getMessagesPanel2() :BasePanel
    {
        return (new LinkPanel())
            ->setLinkAll($this->link('alert!', 'Link from LinkPanel'))
            ->setIcon('envelope')
            ->setCounter(200);
    }

    private function getExampleTasksPanel() :TaskPanel
    {
        $panel = (new TaskPanel())
            ->setLinkAll('#')
            ->setCounter(0)
            ->setHeaderTitle(null);

        for ($i = 1; $i <= 10; $i++ ) {
            $link = $this->link('alert!', 'Link from TaskPanel ' . $i);
            $panel->addTask($link, 'My task ' . $i, $i*10);
        }

        return $panel;
    }

    /**
     * @param $text
     */
    public function handleAlert($text): void
    {
        $this->flashMessage($text);
    }

    /**
     * @param $word
     */
    public function actionSearch(string $word): void
    {
        $this->flashMessage('Looking for: ' . $word, 'danger');
        $this->flashMessage('Looking for: ' . $word);
    }

    /**
     * @throws \Exception
     */
    public function handleRandom(): void
    {
        $this->template->random = random_int(0, 10000);
        $this->redrawControl('random');

    }



    /**
     * @return LazyScreen
     */
    protected function createComponentSlowScreen(): LazyScreen
    {
        return new LazyScreen(function () {
            return $this->slowComponentFactory->create();
        });
    }

    /**
     * @return UserForm
     */
    protected function createComponentForm(): UserForm
    {
        $userForm = $this->userFormFactory->create($this->id);
        $userForm->onUserSave[] = function ($form, $user) {
            $this->flashMessage("User '$user->name' saved");
            $this->redirect('default');
        };

        return $userForm;
    }


}
