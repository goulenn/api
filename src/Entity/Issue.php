<?php

namespace App\Entity;

use App\Entity\Common\Id;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\IssueRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Issue
{
    use Id;

    /**
     * @var string
     *
     * @ORM\Column(type="text")
     */
    private $question;

    public function getQuestion(): string
    {
        return $this->question;
    }

    public function setQuestion(string $question): void
    {
        $this->question = $question;
    }
}
