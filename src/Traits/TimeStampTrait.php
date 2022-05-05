<?php

namespace App\Traits;
use Doctrine\ORM\Mapping as ORM;
trait TimeStampTrait
{
    #[ORM\Column(type: 'datetime', nullable: true)]
    private $UpdatedAt;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $createdAt;


    public function getCreatedAt(): ?\DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTime $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }
    public function getUpdatedAt(): ?\DateTime
    {
        return $this->UpdatedAt;
    }

    public function setUpdatedAt(?\DateTime $UpdatedAt): self
    {
        $this->UpdatedAt = $UpdatedAt;

        return $this;
    }




}