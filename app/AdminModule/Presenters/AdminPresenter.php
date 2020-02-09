<?php

namespace Chap\AdminModule\Presenters;

use Chap\AdminLTE\Components\ActionButtons\Button;
use Chap\AdminLTE\Components\ActionButtons\DropLink;
use Chap\AdminLTE\Components\LazyScreen\LazyScreen;
use Chap\AdminModule\Controls\Async\SlowComponent\SlowComponent;
use Chap\AdminModule\Controls\Forms\UserForm\UserForm;
use Chap\AdminModule\Controls\Grids\UserGridControl\IUserGridFactory;
use Chap\AdminModule\Controls\Grids\UserGridControl\UserGrid;

/**
 * Class AdminPresenter
 * @secured
 */
class AdminPresenter extends AbstractAdminPresenter
{

    /**
     * @throws \Exception
     */
    public function handleRandom(): void
    {
        $this->template->random = random_int(0, 10000);
        $this->redrawControl('random');

    }

    /**
     * @param IUserGridFactory $factory
     * @return UserGrid
     */
    protected function createComponentGrid2(IUserGridFactory $factory): UserGrid
    {
        return $factory->create();
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

    /**
     * @throws \Nette\Application\UI\InvalidLinkException
     */
    public function renderButtons(): void
    {
        $this['admin']->addActionButton(Button::builder()->typeWarning()
            ->link($this->link('this#test'))->faIcon('eye')->build());
        $this['admin']->addActionButton(Button::builder()->typeInfo()
            ->link($this->link('this#test2'))->faIcon('cog')->build());
        $this['admin']->addDropdownLink(new DropLink('', 'link'));
    }

    public function actionEdit(?int $id): void
    {
        $this->id = $id;
    }

    /**
     * @secured
     * @throws \Nette\Application\AbortException
     */
    public function handleSecured(): void
    {
        $this->redirect('this');
    }
}
