<?php


namespace Symfony\Component\Console\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;



class ParsedCommand {

    /**
     * @var \Exception
     */
    private $error;

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

    function __construct(callable $callable, array $params, InputInterface $input, OutputInterface $output, \Exception $error = null) {
        $this->callable = $callable;
        $this->error = $error;
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
     * @return \Exception
     */
    public function getError() {
        return $this->error;
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

 