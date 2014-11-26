<?php

namespace HeVinci\PalefBundle;

use HeVinci\PalefBundle\Entity\Competency;
use HeVinci\PalefBundle\Entity\Task;

class SpreadsheetParser
{
    // column indexes
    private $ignoredColumns = [1, 3, 5]; // "Source" columns
    private $competencyColumn = 0; // "root" competency
    private $abilityColumn = 2;
    private $strategyColumn = 4;
    private $processColumn = 6;
    private $complexityColumn = 7;
    private $taskColumns = [
        8 => 'declarative',
        9 => 'conceptual',
        10 => 'procedural',
        11 => 'metacognitive'
    ];

    public function parse($file)
    {
        if (!file_exists($file)) {
            throw new \Exception("File {$file} does not exist");
        }

        $doc = new \DOMDocument();
        $doc->loadXML(file_get_contents($file));
        $xpath = new \DOMXpath($doc);
        $sheets = $xpath->query('//table:table');
        $competencies = [];

        foreach ($sheets as $sheet) {
            $currentCompetency = null;
            $currentAbility = null;
            $currentStrategy = null;
            $currentProcess = null;
            $currentComplexity = null;
            $rowIndex = -1;

            foreach ($sheet->childNodes as $item) {
                if (!$item instanceof \DOMElement) {
                    continue;
                }

                if ($item->nodeName === 'table:table-row') {
                    $rowIndex++;

                    if ($rowIndex < 3) {
                        // ignore header rows
                        continue;
                    }

                    $columnIndex = -1;

                    foreach ($item->childNodes as $subItem) {
                        if (!$subItem instanceof \DOMElement) {
                            continue;
                        }

                        if ($subItem->nodeName === 'table:table-cell'
                            || $subItem->nodeName === 'table:covered-table-cell') {
                            $columnIndex++;

                            if (in_array($columnIndex, $this->ignoredColumns)) {
                                // ignore "Source" columns
                                continue;
                            }

                            if ($subItem->hasAttribute('table:number-columns-repeated')) {
                                $repeat = $subItem->getAttribute('table:number-columns-repeated');

                                if ($repeat > 1) {
                                    $columnIndex += $repeat - 1;
                                }
                            }

                            $cellContent = trim($subItem->textContent);

                            if ($cellContent) {
                                if ($columnIndex === $this->competencyColumn) {
                                    $currentCompetency = $this->buildCompetency($cellContent);
                                    $competencies[] = $currentCompetency;
                                    continue;
                                }

                                if ($columnIndex === $this->abilityColumn) {
                                    $currentAbility = $this->buildCompetency($cellContent);
                                    $currentAbility->setParent($currentCompetency);
                                }

                                if ($columnIndex === $this->strategyColumn) {
                                    $currentStrategy = $this->buildCompetency($cellContent);
                                    $currentStrategy->setParent($currentAbility);
                                }

                                if ($columnIndex === $this->processColumn) {
                                    $currentProcess = $cellContent;
                                }

                                if ($columnIndex === $this->complexityColumn) {
                                    $currentComplexity = $cellContent;
                                }

                                if (in_array($columnIndex, array_keys($this->taskColumns))) {
                                    if (!$currentStrategy) {
                                        $currentStrategy = $this->buildCompetency('(no description)', 3);
                                        $currentStrategy->setParent($currentAbility);
                                    }

                                    $task = new Task();
                                    $task->setDescription($cellContent);
                                    $task->setProcess($currentProcess);
                                    $task->setComplexity($currentComplexity);
                                    $task->setKnowledgeType($this->taskColumns[$columnIndex]);
                                    $currentStrategy->addTask($task);
                                }
                            }
                        }
                    }
                }
            }
        }

        return $competencies;
    }

    private function buildCompetency($description)
    {
        $competency = new Competency();
        $competency->setDescription($description);

        return $competency;
    }
} 