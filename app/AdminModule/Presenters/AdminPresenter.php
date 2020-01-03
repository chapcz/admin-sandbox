<?php

namespace Chap\AdminModule\Presenters;

use Chap\AdminLTE\AdminControl;
use Chap\AdminLTE\Components\InfoBox\InfoBoard;
use Chap\AdminLTE\Components\InfoBox\InfoBox;
use Chap\AdminLTE\IAdminControlFactory;
use Chap\AdminLTE\Notifications\MessagePanel;
use Chap\AdminLTE\Notifications\NotificationPanel;
use Chap\AdminLTE\Notifications\TaskPanel;
use Chap\AdminModule\Controls\Forms\UserForm\IUserFormFactory;
use Chap\AdminModule\Controls\Forms\UserForm\UserForm;
use Chap\AdminModule\Controls\Grids\UserGridControl\IUserGridFactory;
use Chap\AdminModule\Controls\Grids\UserGridControl\UserGrid;
use Nette\Application\UI\Form;
use Nette\Application\UI\Presenter;
use Nextras\Application\UI\SecuredLinksPresenterTrait;

/**
 * Class AdminPresenter
 * @secured
 */
class AdminPresenter extends SecuredPresenter
{
    /**
     * @var IAdminControlFactory
     */
    private $adminControlFactory;

    /** @var IUserGridFactory @inject */
    public $userGridFactory;

    /** @var IUserFormFactory @inject */
    public $userFormFactory;

    /** @var integer */
    private $id;

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
     * @return \Chap\AdminLTE\AdminControl
     */
    protected function createComponentAdmin(): AdminControl
    {
        $admin = $this->adminControlFactory
            ->create()
            ->addPanel($this->getExampleNotificationsPanel())
            ->addPanel($this->getExampleTasksPanel())
            ->addPanel($this->getMessagesPanel());

        $admin->onSearch[] = function (Form $form) {
            $this->redirect('search', ['word' => $form->getValues()['q']]);
        };

        return $admin;
    }

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
                ->setNumber((float) rand(0, 9999))
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
            ->addNotification('#', 'Something')
            ->addNotification('#', 'Something')
            ->addNotification('#', 'Something')
            ->addNotification('#', 'Something')
            ;
    }

    private function getMessagesPanel() :MessagePanel
    {
        return (new MessagePanel())
            ->setLinkAll('#')
            ->setCounter(2)
            ->setHeaderTitle('%d messages')
            ->addMessage('#', 'Hallo', 'world !', '/image/avatar.png', '2 hours ago')
            ->addMessage('#', 'This', 'is message', '/image/avatar.png', '3 hours ago');
    }

    private function getExampleTasksPanel() :TaskPanel
    {
        $panel = (new TaskPanel())
            ->setLinkAll('#')
            ->setCounter(0)
            ->setHeaderTitle(null);

        for ($i = 1; $i <= 10; $i++ ) {
            $panel->addTask('#', 'My task ' . $i, $i*10);
        }

        return $panel;
    }

    /**
     * @param $word
     */
    public function actionSearch(string $word): void
    {
        $this->flashMessage('Looking for: ' . $word, 'danger');
        $this->flashMessage('Looking for: ' . $word);
    }

    public function handleRandom(): void
    {
        $this->template->random = rand(0, 10000);
        $this->redrawControl('random');

    }

    protected function createComponentGrid2(): UserGrid
    {
        return $this->userGridFactory->create();
    }

    protected function createComponentForm(): UserForm
    {
        $userForm = $this->userFormFactory->create($this->id);
        $userForm->onUserSave[] = function ($form, $user) {
            $this->flashMessage("User '$user->name' saved");
            $this->redirect('default');
        };

        return $userForm;
    }

    public function actionTest(): void
    {
    }

    public function actionEdit(?int $id): void
    {
        $this->id = $id;
    }

    /**
     * @secured
     */
    public function handleSecured(): void
    {
        $this->redirect('this');
    }
}
