<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Console\Command;

use Symfony\Component\Console\Helper\DescriptorHelper;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * HelpCommand displays the help for a given command.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class HelpCommand extends AbstractCommand
{
    private $command;
    /**
     * @var InputInterface
     */
    private $input;
    /**
     * @var OutputInterface
     */
    private $output;

    function getCallable() {
        $callable = function () {
            if ($this->input->getOption('xml')) {
                $this->input->setOption('format', 'xml');
            }
            $helper = new DescriptorHelper();
            $helper->describe($this->output, $this->command, array(
                'format' => $this->input->getOption('format'),
                'raw'    => $this->input->getOption('raw'),
            ));

            $this->command = null;//Dafuq is this shit?
        };
        
        return $callable;
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

        if (null === $this->command) {
            $this->command = $this->getApplication()->find($input->getArgument('command_name'));
        }

        $this->input = $input;
        $this->output = $output;
        
        return [];
    }


    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->ignoreValidationErrors();

        $this
            ->setName('help')
            ->setDefinition(array(
                new InputArgument('command_name', InputArgument::OPTIONAL, 'The command name', 'help'),
                new InputOption('xml', null, InputOption::VALUE_NONE, 'To output help as XML'),
                new InputOption('format', null, InputOption::VALUE_REQUIRED, 'To output help in other formats', 'txt'),
                new InputOption('raw', null, InputOption::VALUE_NONE, 'To output raw command help'),
            ))
            ->setDescription('Displays help for a command')
            ->setHelp(<<<EOF
The <info>%command.name%</info> command displays help for a given command:

  <info>php %command.full_name% list</info>

You can also output the help in other formats by using the <comment>--format</comment> option:

  <info>php %command.full_name% --format=xml list</info>

To display the list of available commands, please use the <info>list</info> command.
EOF
            )
        ;
    }

    /**
     * Sets the command - really, setCommand sets the command.....Why does it set the command?
     *
     * @param AbstractCommand $command The command to set
     */
    public function setCommand(AbstractCommand $command)
    {
        $this->command = $command;
    }

//    /**
//     * {@inheritdoc}
//     */
//    protected function execute(InputInterface $input, OutputInterface $output)
//    {
//        if (null === $this->command) {
//            $this->command = $this->getApplication()->find($input->getArgument('command_name'));
//        }
//
//        if ($input->getOption('xml')) {
//            $input->setOption('format', 'xml');
//        }
//
//        $helper = new DescriptorHelper();
//        $helper->describe($output, $this->command, array(
//            'format' => $input->getOption('format'),
//            'raw'    => $input->getOption('raw'),
//        ));
//
//        $this->command = null;
//    }
}
