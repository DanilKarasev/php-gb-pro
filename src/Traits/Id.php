<?php

namespace App\Traits;

trait Id
{
    private int $id;

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }
}