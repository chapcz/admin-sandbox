<?php declare(strict_types=1);

namespace Chap\Base;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMInvalidArgumentException;
use Nette\Application\AbortException;
use Nette\Application\UI\Control;
use Nette\Localization\ITranslator;
use Nette\Security\User;
use Ublaboo\DataGrid\DataGrid;

abstract class GridControl extends Control
{

    /** @var ITranslator */
    protected $translator;

    /** @var EntityManager */
    protected $em;

    /** @var User */
    protected $user;

    protected $templateName = 'grid.latte';

    /**
     * @param ITranslator            $translator
     * @param EntityManagerInterface $entityManager
     * @param User                   $user
     */
    public function __construct(ITranslator $translator, EntityManagerInterface $entityManager, User $user)
    {
        $this->translator = $translator;
        $this->em = $entityManager;
        $this->user = $user;
    }

    protected function createGrid(): DataGrid
    {
        $dataGrid = new DataGrid();
        $dataGrid->setTranslator($this->translator);

        return $dataGrid;
    }

    /**
     * @return DataGrid
     * @throws OptimisticLockException
     * @throws ORMInvalidArgumentException
     * @throws AbortException
     */
    abstract public function createComponentGrid(): DataGrid;

    /**
     * @throws \ReflectionException
     */
    public function render(): void
    {
        $reflection = new \ReflectionClass($this);
        $this->getTemplate()->setFile(\dirname($reflection->getFileName()) . DIRECTORY_SEPARATOR . $this->templateName)->render();
    }
}