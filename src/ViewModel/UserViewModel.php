<?php

namespace App\ViewModel;

class UserViewModel
{
    protected $id;

    protected $fullName;

    public function setId(int $id) : self
    {
        $this->id = $id;

        return $this;
    }

    public function getId() : ?int
    {
        return $this->id;
    }

    public function setFullName(string $fullName) : self
    {
        $this->fullName = $fullName;

        return $this;
    }

    public function getFullName() : ?string
    {
        return $this->fullName;
    }
}
