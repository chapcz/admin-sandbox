<?php
namespace Chap\AdminModule\Controls\Forms\UserForm;


interface IUserFormFactory {

    /**
     * @param int|null $id
     * @return UserForm
     */
    public function create(?int $id): UserForm;

}
