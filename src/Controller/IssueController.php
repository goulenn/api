<?php

namespace App\Controller;

use App\Entity\Issue;
use App\Manager\IssueManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

class IssueController extends ApiController
{
    /**
     * @Route("/issue", methods={"POST"})
     *
     * @ParamConverter(
     *     name="issue",
     *     class="App\Entity\Issue",
     *     converter="rollandrock_entity_converter"
     * )
     */
    public function post(Issue $issue)
    {
        $issue->setIssuer($this->getUser());
        $this->get(IssueManager::class)->save($issue);

        return $this->handleResponse($issue, Response::HTTP_CREATED);
    }
}
