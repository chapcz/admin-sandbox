<?php declare(strict_types=1);

namespace Chap\AdminModule\Controls\Grids\UserGridControl;

use Chap\Base\GridControl;
use Chap\Exceptions\RecordNotFoundException;
use Chap\Models\Entities\User;
use Ublaboo\DataGrid\Column\Action\Confirmation\StringConfirmation;
use Ublaboo\DataGrid\DataGrid;

class UserGrid extends GridControl
{
    /**
     * @return DataGrid
     * @throws \Ublaboo\DataGrid\Exception\DataGridException
     */
    public function createComponentGrid(): DataGrid
    {
        $grid = $this->createGrid();
        $grid->addColumnText('name', 'Login')->setFilterText();
        $grid->addColumnText('realName', 'Name')->setFilterText();
        $grid->addColumnText('email', 'Email')->setFilterText();
        $role = $grid->addColumnText('role', 'Role');
        $role->setFilterSelect([null => ''] + User::$ALL_ROLES)->setTranslateOptions();
        $grid->addColumnDateTime('lastSeen', 'Last Seen');
        $grid->addAction('edit', 'Edit', ':Admin:Example:edit')->setIcon('edit')->setTitle('Edit')->setClass('btn btn-xs btn-danger');

        $grid->setDataSource($this->em->getRepository(User::class)->createQueryBuilder('u')->andWhere('u.deleted=false'));

         return $grid;
    }

    /**
     * @param $id
     * @throws RecordNotFoundException
     * @throws \Exception
     * @throws \Nette\Application\AbortException
     */
    public function handledelete($id)
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
