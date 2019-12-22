<?php

namespace Chap\AdminModule\Presenters;

use Chap\Presenters\BasePresenter;

class ExamplePresenter extends BasePresenter
{
    /**
     * @param $id
     * @secured
     * @throws \Nette\Application\AbortException
     */
    public function handleSecured($id)
    {
         $this->redirect('this', $id);
    }


    public function actionEdit($id)
    {


    }
}