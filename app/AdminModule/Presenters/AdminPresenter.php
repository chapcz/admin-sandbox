<?php

namespace Chap\AdminModule\Presenters;

use Chap\AdminLTE\AdminControl;
use Chap\AdminLTE\IAdminControlFactory;
use Chap\AdminLTE\Notifications\MessagePanel;
use Chap\AdminLTE\Notifications\NotificationPanel;
use Chap\AdminLTE\Notifications\TaskPanel;
use Chap\AdminModule\Controls\Forms\UserForm\IUserFormFactory;
use Chap\AdminModule\Controls\Forms\UserForm\UserForm;
use Chap\AdminModule\Controls\Grids\UserGridControl\IUserGridFactory;
use Chap\AdminModule\Controls\Grids\UserGridControl\UserGrid;
use Chap\Presenters\BasePresenter;
use Nette\Application\UI\Form;

class AdminPresenter extends BasePresenter
{
    /**
     * @var IAdminControlFactory
     */
    private $adminControlFactory;

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



    public function handleRandom()
    {
        $this->template->random = rand(0, 10000);
        $this->redrawControl('random');

    }

    protected function createComponentGrid2(IUserGridFactory $factory): UserGrid
    {
        return $factory->create();
    }

    protected function createComponentForm(IUserFormFactory $factory): UserForm
    {
        return $factory->create();
    }

    public function actionTest()
    {

    }
}
