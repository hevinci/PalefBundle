<?php

namespace HeVinci\PalefBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="hevinci_exercise")
 */
class Exercise
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(length=1024)
     */
    private $description;

    /**
     * @ORM\ManyToMany(
     *     targetEntity="HeVinci\PalefBundle\Entity\Task",
     *     inversedBy="exercises"
     * )
     * @ORM\JoinTable(name="hevinci_task_exercise")
     */
    private $tasks;

    /**
     * @ORM\OneToMany(
     *     targetEntity="HeVinci\PalefBundle\Entity\Answer",
     *     mappedBy="exercise"
     * )
     */
    private $answers;

    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function getTasks()
    {
        return $this->tasks;
    }
}