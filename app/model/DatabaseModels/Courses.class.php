<?php

use Adianti\Database\TRecord;

class Courses extends TRecord
{
    const TABLENAME = 'course';
    const PRIMARYKEY = 'id';
    const IDPOLICY = 'serial';

    public function __construct($id = null) {
        parent::__construct($id);

        parent::addAttribute('nome');
    }
}