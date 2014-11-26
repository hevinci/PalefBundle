<?php

namespace HeVinci\PalefBundle\Command;

use HeVinci\PalefBundle\SpreadsheetParser;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ImportCommand extends Command
{
    protected function configure()
    {
        $this->setName('hevinci:import')
            ->setDescription('Import a competency framework from a spreadsheet');
        $this->setDefinition(
            array(
                new InputArgument('spreadsheet', InputArgument::REQUIRED, 'The spreadsheet path'),
                new InputArgument('output', InputArgument::REQUIRED, 'The output file path')
            )
        );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $parser = new SpreadsheetParser();
        $competencies = $parser->parse($input->getArgument('spreadsheet'));
        $output = array_reduce($competencies, function ($a, $b) {
           return $a . $b;
        });
        file_put_contents($input->getArgument('output'), $output);
    }
}