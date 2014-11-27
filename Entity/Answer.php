<?php

namespace HeVinci\PalefBundle\Entity;

use Claroline\CoreBundle\Entity\User;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="hevinci_answer")
 */
class Answer
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(
     *     targetEntity="HeVinci\PalefBundle\Entity\Exercise",
     *     inversedBy="answers"
     * )
     */
    private $exercise;

    /**
     * @ORM\ManyToOne(targetEntity="Claroline\CoreBundle\Entity\User")
     */
    private $user;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isCorrect = false;

    public function setExercise(Exercise $exercise)
    {
        $this->exercise = $exercise;
    }

    public function setUser(User $user)
    {
        $this->user = $user;
    }

    public function isCorrect()
    {
        return $this->isCorrect;
    }

    public function setIsCorrect($isCorrect)
    {
        $this->isCorrect = $isCorrect;
    }
}