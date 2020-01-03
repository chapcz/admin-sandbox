<?php declare(strict_types=1);

namespace Chap\AdminModule\Controls\Grids\UserGridControl;

use Chap\Models\Entities\User;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Nette\Application\UI\Control;
use Nette\Localization\ITranslator;
use Nette\Security\IIdentity;
use Ublaboo\DataGrid\DataGrid;

class UserGrid extends Control
{
    /** @var ITranslator */
    protected $translator;

    /** @var EntityManager */
    protected $em;

    /** @var \Nette\Security\User */
    protected $user;

    /**
     * @param ITranslator            $translator
     * @param EntityManagerInterface $entityManager
     * @param \Nette\Security\User              $user
     */
    public function __construct(ITranslator $translator, EntityManagerInterface $entityManager, \Nette\Security\User $user)
    {
        $this->translator = $translator;
        $this->em = $entityManager;
        $this->user = $user;
    }

    /**
     * @throws \ReflectionException
     */
    public function render(): void
    {
        $this->getTemplate()
            ->setFile(__DIR__ . DIRECTORY_SEPARATOR . 'grid.latte')
            ->render();
    }
    /**
     * @return DataGrid
     * @throws \Ublaboo\DataGrid\Exception\DataGridException
     */
    public function createComponentGrid(): DataGrid
    {
        $grid = new DataGrid();
        $grid->setTranslator($this->translator);
        $grid->addColumnText('name', 'Login')->setFilterText();
        $grid->addColumnText('realName', 'Name')->setFilterText();
        $grid->addColumnText('email', 'Email')->setFilterText();
        $role = $grid->addColumnText('role', 'Role');
        $role->setFilterSelect([null => ''] + User::$ALL_ROLES)->setTranslateOptions();
        $grid->addColumnDateTime('lastSeen', 'Last Seen');
        $grid->addAction('edit', 'Edit', ':Admin:Admin:edit')
            ->setIcon('edit')->setTitle('Edit')->setClass('btn btn-xs btn-danger');

        $grid->getAction('edit')->addAttributes(['modal'=> 'modal']);
        $grid->setDataSource($this->em->getRepository(User::class)->createQueryBuilder('u')->andWhere('u.deleted=false'));

         return $grid;
    }

    /**
     * @param $id
     * @throws \Exception
     * @throws \Nette\Application\AbortException
     */
    public function handleDelete($id): void
    {
        if (!$this->user->isAllowed('Users', 'delete')) {
            $this->presenter->flashMessage('Permission denied', 'danger');
            $this->redirect('this');
        }
        /** @var User $user */
        $user = $this->entityManager->getById($id);
        if ($user === null) {
            return;
        }
        $this->presenter->flashMessage($this->translator->translate('User removed') . ': ' . $user->name, 'success');
        $user->deleted = true;
        $this->redirect('this');
    }

}
