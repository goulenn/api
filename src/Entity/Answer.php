<?php

namespace App\Entity;

use App\Entity\Common\CreatedAt;
use App\Entity\Common\Id;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class Answer
{
    use Id;
    use CreatedAt;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     */
    private $issuer;

    /**
     * @var Issue
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Issue", inversedBy="answers")
     */
    private $issue;

    /**
     * @var string
     *
     * @ORM\Column(type="text")
     */
    private $content;

    /**
     * @var boolean
     *
     * @ORM\Column(type="boolean")
     */
    private $resolving;

    public function __construct()
    {
        $this->resolving = false;
    }

    public function getIssuer(): User
    {
        return $this->issuer;
    }

    public function setIssuer(User $issuer): void
    {
        $this->issuer = $issuer;
    }

    public function getIssue(): Issue
    {
        return $this->issue;
    }

    public function setIssue(Issue $issue): void
    {
        $this->issue = $issue;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    public function isResolving(): bool
    {
        return $this->resolving;
    }

    public function setResolving(bool $resolving): void
    {
        $this->resolving = $resolving;
    }
}
