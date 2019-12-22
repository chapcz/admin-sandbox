<?php

namespace Chap\AdminModule\Presenters;

use Chap\Presenters\BasePresenter;

class HomepagePresenter extends BasePresenter
{
    /**
     * @param $id
     * @secured
     */
    public function handleSecured($id)
    {
         $this->redirect('this', $id);
    }


}