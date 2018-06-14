<?php

namespace App\Repository;

use App\Entity\Issue;
use Doctrine\ORM\EntityRepository;

class IssueRepository extends EntityRepository
{
    public function save(Issue $issue): void
    {
        $this->getEntityManager()->persist($issue);
        $this->getEntityManager()->flush();
    }
}
