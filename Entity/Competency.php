<?php

namespace HeVinci\PalefBundle\Entity;

class Competency
{
    public $description;
    public $level;
    public $subCompetencies = [];
    public $tasks = [];

    public function __toString()
    {
        $output = $this->description . PHP_EOL;
        $offset = '';

        for ($i = 0; $i < $this->level; ++$i) {
            $offset .= '    ';
        }

        foreach ($this->subCompetencies as $competency) {
            $output .= $offset . (string) $competency;
        }

        foreach ($this->tasks as $task) {
            $output .= (string) $task;
        }

        return $output;
    }
}