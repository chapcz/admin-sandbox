<?php declare(strict_types=1);

namespace Chap\Presenters;

use Kdyby\Autowired\AutowireComponentFactories;
use Kdyby\Autowired\AutowireProperties;
use Nette\Application\UI\Presenter;

abstract class BasePresenter extends Presenter
{
    use AutowireProperties;
    use AutowireComponentFactories;
}
