<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Foo1Command extends Command
{
    public $input;
    public $output;

    function parseInput(InputInterface $input, OutputInterface $output) {
        return [];
    }

    function getCallable() {
        return null;
    }

    protected function configure()
    {
        $this
            ->setName('foo:bar1')
            ->setDescription('The foo:bar1 command')
            ->setAliases(array('afoobar1'))
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->input = $input;
        $this->output = $output;
    }
}
