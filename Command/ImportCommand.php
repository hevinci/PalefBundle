<?php

namespace HeVinci\PalefBundle\Command;

use Doctrine\ORM\EntityManagerInterface;
use HeVinci\PalefBundle\Entity\Competency;
use HeVinci\PalefBundle\SpreadsheetParser;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ImportCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('hevinci:import')
            ->setDescription('Import a competency framework from a spreadsheet');
        $this->setDefinition(
            array(
                new InputArgument('spreadsheet', InputArgument::REQUIRED, 'The spreadsheet path'),
                new InputArgument('name', InputArgument::REQUIRED, 'The name of the competency framework')
            )
        );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $parser = new SpreadsheetParser();
        $competencies = $parser->parse($input->getArgument('spreadsheet'));
        $em = $this->getContainer()->get('doctrine.orm.entity_manager');
        $root = new Competency();
        $root->setDescription($input->getArgument('name'));

        foreach ($competencies as $competency) {
            $competency->setParent($root);
            $this->recursivePersist($competency, $em);
        }

        $em->persist($root);
        $em->flush();
    }

    private function recursivePersist(Competency $competency, EntityManagerInterface $em)
    {
        foreach ($competency->getChildren() as $child) {
            $em->persist($child);
            $this->recursivePersist($child, $em);
        }

        foreach ($competency->getTasks() as $task) {
            $em->persist($task);
        }

        $em->persist($competency);
    }
}