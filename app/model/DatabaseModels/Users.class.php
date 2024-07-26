<?php

use Adianti\Database\TRecord;

class Users extends TRecord
{
    const TABLENAME = 'users';
    const PRIMARYKEY = 'id';
    const IDPOLICY = 'serial';

    public function __construct($id = null) {
        parent::__construct($id);

        parent::addAttribute('nome');
        parent::addAttribute('sobrenome');
        parent::addAttribute('email');
        parent::addAttribute('senha');
    }
}