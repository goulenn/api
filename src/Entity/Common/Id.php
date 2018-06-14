<?php

namespace App\Entity\Common;

use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;

trait Id
{
    /**
     * @var string
     *
     * @ORM\Column(type="string", length=36)
     * @ORM\Id
     */
    private $id;

    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @ORM\PrePersist
     */
    public function setId(): void
    {
        $this->id = Uuid::uuid4()->toString();
    }
}
