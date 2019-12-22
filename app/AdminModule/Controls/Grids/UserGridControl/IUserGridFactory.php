<?php declare(strict_types=1);

namespace Chap\AdminModule\Controls\Grids\UserGridControl;

interface IUserGridFactory
{
    /**
     * @return UserGrid
     */
    public function create(): UserGrid;
}
