<?php

namespace App\Entity;

use App\Entity\Common\CreatedAt;
use App\Entity\Common\Id;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\IssueRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Issue
{
    use Id;
    use CreatedAt;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\User", cascade={})
     */
    private $issuer;

    /**
     * @var string
     *
     * @ORM\Column(type="text")
     */
    private $question;

    /**
     * @var boolean
     *
     * @ORM\Column(type="boolean")
     */
    private $resolved;

    /**
     * @var Answer[]
     *
     * @ORM\OneToMany(
     *     targetEntity="App\Entity\Answer",
     *     mappedBy="issue",
     *     cascade={"all"},
     *     orphanRemoval=true
     * )
     */
    private $answers;

    public function __construct()
    {
        $this->resolved = false;
    }

    /**
     * @return User
     */
    public function getIssuer(): User
    {
        return $this->issuer;
    }

    /**
     * @param User $issuer
     */
    public function setIssuer(User $issuer): void
    {
        $this->issuer = $issuer;
    }

    public function getQuestion(): string
    {
        return $this->question;
    }

    public function setQuestion(string $question): void
    {
        $this->question = $question;
    }

    public function isResolved(): bool
    {
        return $this->resolved;
    }

    public function setResolved(bool $resolved): void
    {
        $this->resolved = $resolved;
    }

    public function getAnswers(): array
    {
        return $this->answers;
    }

    public function setAnswers(array $answers): void
    {
        $this->answers = $answers;
    }
}
