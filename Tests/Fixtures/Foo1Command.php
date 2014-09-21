<?php

use Danack\Console\Command\AbstractCommand;
use Danack\Console\Input\InputInterface;
use Danack\Console\Output\OutputInterface;

class Foo1Command extends AbstractCommand
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
