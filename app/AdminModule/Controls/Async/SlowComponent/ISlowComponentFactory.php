<?php declare(strict_types=1);

namespace Chap\AdminModule\Controls\Async\SlowComponent;

interface ISlowComponentFactory {
    /**
     * @return SlowComponent
     */
    public function create(): SlowComponent;
}
