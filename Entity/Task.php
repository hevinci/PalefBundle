<?php

namespace HeVinci\PalefBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="hevinci_task")
 */
class Task
{
    static private $processes = [
        1 => 'A',
        2 => 'B',
        3 => 'C'
    ];

    static private $complexityLevels = [
        1 => 1,
        2 => 2
    ];

    static private $knowledgeTypes = [
        1 => 'declarative',
        2 => 'conceptual',
        3 => 'procedural',
        4 => 'metacognitive'
    ];

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
     * @ORM\Column(length=128)
     */
    private $process = 'declarative';

    /**
     * @ORM\Column(type="integer")
     */
    private $complexity = 1;

    /**
     * @ORM\Column(length=128)
     */
    private $knowledge = 'A';

    /**
     * @ORM\Column(type="integer")
     */
    private $weight = 1;

    /**
     * @return integer
     */
    public function getComplexity()
    {
        return $this->complexity;
    }

    /**
     * @param integer $complexity
     */
    public function setComplexity($complexity)
    {
        // TMP (current spreadsheet quirk)
        if ($complexity === '/') {
            $complexity = 1;
        }

        if (!in_array($complexity, self::$complexityLevels)) {
            throw new \InvalidArgumentException("Unknown level '{$complexity}'");
        }

        $this->complexity = $complexity;
        $this->computeWeight();
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
     * @return string
     */
    public function getKnowledgeType()
    {
        return $this->knowledge;
    }

    /**
     * @param string $type
     */
    public function setKnowledgeType($type)
    {
        if (!in_array($type, self::$knowledgeTypes)) {
            throw new \InvalidArgumentException("Unknown type '{$type}'");
        }

        $this->knowledge = $type;
        $this->computeWeight();
    }

    /**
     * @return string
     */
    public function getProcess()
    {
        return $this->process;
    }

    /**
     * @param string $process
     */
    public function setProcess($process)
    {
        // TMP (current spreadsheet quirk)
        if ($process === 'Comp2' || $process === 'Comp 2') {
            $process = 'A';
        }

        if (!in_array($process, self::$processes)) {
            throw new \InvalidArgumentException("Unknown process '{$process}'");
        }

        $this->process = $process;
        $this->computeWeight();
    }

    /**
     * @return integer
     */
    public function getWeight()
    {
        return $this->weight;
    }

    private function computeWeight()
    {
        $x = array_search($this->process, self::$processes);
        $y = array_search($this->complexity, self::$complexityLevels);
        $z = array_search($this->knowledge, self::$knowledgeTypes);
        $yMax = count(self::$complexityLevels);
        $zMax = count(self::$knowledgeTypes);
        $this->weight = ($x * $yMax - $yMax + $y) * $zMax - $zMax + $z;
    }

    public function __toString()
    {
        return '            '
        . $this->description . PHP_EOL
        . '              ('
        . $this->process . ', '
        . $this->complexity . ', '
        . $this->knowledge . ', '
        . $this->weight . ')' . PHP_EOL;
    }
}