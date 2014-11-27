<?php

namespace HeVinci\PalefBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="Gedmo\Tree\Entity\Repository\NestedTreeRepository")
 * @ORM\Table(name="hevinci_competency")
 * @Gedmo\Tree(type="nested")
 */
class Competency
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(
     *     targetEntity="HeVinci\PalefBundle\Entity\Competency"
     * )
     * @ORM\JoinColumn(nullable=true, onDelete="CASCADE")
     * @Gedmo\TreeParent
     */
    protected $parent;

    // not mapped (used for transfer from spreadsheet to text)
    /**
     * @ORM\OneToMany(targetEntity="HeVinci\PalefBundle\Entity\Competency", mappedBy="parent")
     * @ORM\OrderBy({"lft" = "ASC"})
     */
    private $children;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Gedmo\TreeRoot
     */
    private $root;

    /**
     * @ORM\Column(type="integer")
     * @Gedmo\TreeLeft
     */
    private $lft;

    /**
     * @ORM\Column(type="integer")
     * @Gedmo\TreeLevel
     */
    private $lvl = 1;

    /**
     * @ORM\Column(type="integer")
     * @Gedmo\TreeRight
     */
    private $rgt;

    /**
     * @ORM\Column(length=1024)
     */
    private $description;

    /**
     * @ORM\ManyToMany(
     *     targetEntity="HeVinci\PalefBundle\Entity\Task"
     * )
     * @ORM\JoinTable(name="hevinci_competency_task")
     */
    private $tasks;

    public function  __construct()
    {
        $this->tasks = new ArrayCollection();
        $this->children = new ArrayCollection();
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

    /**
     * @return mixed (Competency|null)
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @param Competency $parent
     */
    public function setParent(Competency $parent)
    {
        $this->parent = $parent;
        $this->parent->children->add($this);
        $this->lvl = $parent->getLevel() + 1;
    }

    public function getChildren()
    {
        return $this->children;
    }

    public function getLevel()
    {
        return $this->lvl;
    }

    /**
     * @return Task[]
     */
    public function getTasks()
    {
        return $this->tasks;
    }

    /**
     * @param Task $task
     */
    public function addTask(Task $task)
    {
        $this->tasks->add($task);
    }

    public function __toString()
    {
        $output = $this->description . PHP_EOL;
        $offset = '';

        for ($i = 0; $i < $this->lvl; ++$i) {
            $offset .= '    ';
        }

        foreach ($this->children as $competency) {
            $output .= $offset . (string) $competency;
        }

        foreach ($this->tasks as $task) {
            $output .= (string) $task;
        }

        return $output;
    }
}