<?php

namespace App\Actions;

class Card
{
    public $id;
    public $name;
    public $userAnonimous;
    public $birthDate;

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    public function createCard()
    {
        $this->save();
    }

    public function deleteCard()
    {
        $this->delete();
    }
}
