<?php

namespace Chap\AdminModule\Presenters;


use Nette\Application\UI\Presenter;
use Nextras\Application\UI\SecuredLinksPresenterTrait;

abstract class SecuredPresenter extends Presenter
{
    use SecuredLinksPresenterTrait;
}
