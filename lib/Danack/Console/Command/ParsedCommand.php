<?php


namespace Danack\Console\Command;

use Danack\Console\Input\InputInterface;
use Danack\Console\Output\OutputInterface;


class ParsedCommand {

    /**
     * @var callable
     */
    private $callable;
    /**
     * @var array
     */
    private $params;

    /**
     * @var InputInterface
     */
    private $input;

    /**
     * @var OutputInterface
     */
    private $output;

    function __construct(callable $callable = null, array $params = null, InputInterface $input, OutputInterface $output) {
        $this->callable = $callable;
        $this->input = $input;
        $this->output = $output;
        $this->params = $params;
    }

    /**
     * @return callable
     */
    public function getCallable() {
        return $this->callable;
    }
    
    /**
     * @return InputInterface
     */
    public function getInput() {
        return $this->input;
    }

    /**
     * @return OutputInterface
     */
    public function getOutput() {
        return $this->output;
    }

    /**
     * @return array
     */
    public function getParams() {
        return $this->params;
    }
}

 