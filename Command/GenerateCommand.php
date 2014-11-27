<?php

namespace HeVinci\PalefBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GenerateCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('hevinci:generate')
            ->setDescription('Creates fake exercises linked to tasks');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $generator = $this->getContainer()->get('hevinci.exercise_generator');
        $generator->generate();
    }
}