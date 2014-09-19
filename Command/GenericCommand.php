<?php


namespace Symfony\Component\Console\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GenericCommand extends Command {

    private $callable;

    function __construct($callable, $name = null) {
        parent::__construct($name);
        $this->callable = $callable;
    }

    function getCallable() {
        return $this->callable; 
    }

    /**
     * Return an array of parameters that should be passed to the callable.
     * They should have the correct name indexes, the order does not matter
     * as Auryn will inject them correctly.
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return array
     */
    function parseInput(InputInterface $input, OutputInterface $output) {
        return [];
    }
}

 