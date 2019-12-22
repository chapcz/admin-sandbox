<?php
namespace Chap\AdminModule\Controls\Forms\UserForm;


interface IUserFormFactory {

    /**
     * @return UserForm
     */
    public function create();

}
