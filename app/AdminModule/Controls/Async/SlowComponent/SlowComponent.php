<?php declare(strict_types=1);

namespace Chap\AdminModule\Controls\Async\SlowComponent;

use Nette\Application\UI\Control;
use Nette\Bridges\ApplicationLatte\Template;

class SlowComponent extends Control
{
    public function __construct()
    {
        sleep(5);
    }

    public function render(): void
    {
        /** @var Template $template */
        $template = $this->getTemplate();
        $template->render(__DIR__ . DIRECTORY_SEPARATOR . 'template.latte');
    }
}
