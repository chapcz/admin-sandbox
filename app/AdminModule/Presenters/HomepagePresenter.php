<?php

namespace Chap\AdminModule\Presenters;

use Nette\Application\UI\Presenter;
use Nextras\Application\UI\SecuredLinksPresenterTrait;

class HomepagePresenter extends AbstractAdminPresenter
{
    /**
     * @param $id
     * @secured
     * @throws \Nette\Application\AbortException
     */
    public function handleSecured($id): void
    {
         $this->redirect('this', $id);
    }
}