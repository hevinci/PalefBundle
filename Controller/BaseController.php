<?php

namespace HeVinci\PalefBundle\Controller;

use Claroline\CoreBundle\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use HeVinci\PalefBundle\Entity\Answer;
use HeVinci\PalefBundle\Entity\Exercise;
use JMS\DiExtraBundle\Annotation as DI;
use JMS\SecurityExtraBundle\Annotation as SEC;
use Sensio\Bundle\FrameworkExtraBundle\Configuration as EXT;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @SEC\PreAuthorize("hasRole('ROLE_USER')")
 */
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

    /**
     * @EXT\Route("/exercise/{id}")
     * @EXT\Method("GET")
     * @EXT\ParamConverter(
     *     "user",
     *     class="HeVinciPalefBundle:Exercise",
     *     options={"id" = "id", "strictId" = true}
     * )
     * @EXT\Template()
     *
     * @param Exercise $exercise
     * @return Exercise
     */
    public function exerciseAction(Exercise $exercise)
    {
        return ['exercise' => $exercise];
    }

    /**
     * @EXT\Route("/exercise/{id}", name="hevinci_submit_exercise")
     * @EXT\Method("POST")
     * @EXT\ParamConverter(
     *     "user",
     *     class="HeVinciPalefBundle:Exercise",
     *     options={"id" = "id", "strictId" = true}
     * )
     * @EXT\ParamConverter("user", options={"authenticatedUser" = true})
     *
     * @param Request $request
     * @param Exercise $exercise
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function submitExerciseAction(Request $request, Exercise $exercise, User $user)
    {
        $answer = $request->request->get('answer');
        $userAnswer = new Answer();
        $userAnswer->setExercise($exercise);
        $userAnswer->setUser($user);
        $userAnswer->setIsCorrect($answer === '0' ? false : true);

        $this->em->persist($userAnswer);
        $this->em->flush();

        return new Response('Submitted with answer ' . $answer);
    }
} 