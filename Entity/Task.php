<?php

namespace HeVinci\PalefBundle\Entity;

class Task
{
    public $description;
    public $process;
    public $complexity;
    public $knowledge;

    public function __toString()
    {
        return '                '
        . $this->description . PHP_EOL
        . '                  ('
        . $this->process . ', '
        . $this->complexity . ', '
        . $this->knowledge . ')' . PHP_EOL;
    }
}