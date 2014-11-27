<?php

namespace HeVinci\PalefBundle\Controller;

use Doctrine\ORM\EntityManagerInterface;
use JMS\DiExtraBundle\Annotation as DI;
use Sensio\Bundle\FrameworkExtraBundle\Configuration as EXT;

class BaseController
{
    private $em;

    /**
     * @DI\InjectParams({
     *     "em" = @DI\Inject("doctrine.orm.entity_manager")
     * })
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @EXT\Route("/framework")
     * @EXT\Template()
     */
    public function frameworkAction()
    {
        $competencyRepo = $this->em->getRepository('HeVinci\PalefBundle\Entity\Competency');
        $taskRepo = $this->em->getRepository('HeVinci\PalefBundle\Entity\Task');

        // pre-load the complete framework
        $competencyRepo->findAll();
        $taskRepo->findAll();

        return ['roots' => $competencyRepo->getRootNodes()];
    }
} 