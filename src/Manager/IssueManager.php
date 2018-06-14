<?php

namespace App\Manager;

use App\Entity\Issue;
use App\Repository\IssueRepository;

class IssueManager
{
    /**
     * @var IssueRepository
     */
    private $repository;

    public function __construct(IssueRepository $repository)
    {
        $this->repository = $repository;
    }

    public function save(Issue $issue): void
    {
        $this->repository->save($issue);
    }
}
