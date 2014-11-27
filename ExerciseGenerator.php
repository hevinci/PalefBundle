<?php

namespace HeVinci\PalefBundle;

use Doctrine\ORM\EntityManagerInterface;
use HeVinci\PalefBundle\Entity\Exercise;
use JMS\DiExtraBundle\Annotation as DI;

/**
 * @DI\Service("hevinci.exercise_generator")
 */
class ExerciseGenerator
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

    public function generate()
    {
        $tasks = $this->em
            ->getRepository('HeVinci\PalefBundle\Entity\Task')
            ->findAll();

        foreach ($tasks as $task) {
            for ($i = 1; $i < 11; ++$i) {
                $exercise = new Exercise();
                $exercise->setDescription('Exercise n°' . $i);
                $this->em->persist($exercise);
                $task->addExercise($exercise);

                if ((bool) rand(0, 1)) {
                    for ($j = 0, $max = rand(1, 3); $j < $max; ++$j) {
                        $tasks[rand(0, count($tasks) - 1)]->addExercise($exercise);
                    }
                }
            }
        }

        $this->em->flush();
    }
}