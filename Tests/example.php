<?php

/* Example file for using the console library as a pure CLI routing library.
 * The input below will give the listed output.
 * 
 * Input
 * =====
 * php Tests/example.php upload backup.zip --dir=/var/log
 * 
 * Output
 * ======
 * Need to upload the file backup.zip in the directory /var/log
 * 
 * Input
 * =====
 * php Tests/example.php greet Danack
 * 
 * Output
 * ======
 * Hello world, and particularly Danack
 *
 * Input 
 * =====
 * php Tests/example.php greet
 * 
 * Output
 * ======
 * Usage:
 * greet name
 * 
 */



use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Command\GenericCommand;
use Symfony\Component\Console\Input\InputArgument;
use Auryn\Provider as Injector;
use Symfony\Component\Console\Output\BufferedOutput;


require_once __DIR__."/../vendor/autoload.php";





class AboutCommand extends Command
{
    function __construct() {
        parent::__construct('about');
        $this->configure();
    }

    function parseInput(InputInterface $input, OutputInterface $output) {
        return [];
    }
    
    function getCallable() {
        return null;
    }

    protected function configure()
    {
        $this
            ->setName('about')
            ->setDescription('Short information about danack/console')
            ->setHelp(<<<EOT
<info>This is an example 'application' of the forked version of symfony console.

It was forked because you should be able to use a console processing library to process 
command line options without having to let it manage your code for you.
</info>
EOT
             );
    }
}






function uploadFile($filename, $dir) {
    echo "Need to upload the file $filename in the directory $dir".PHP_EOL;
}


function lowrey($params) {
    $newParams = [];
    foreach ($params as $key => $value) {
        $newParams[':'.$key] = $value;
    }
    return $newParams;
}



$console = new Application();
$console->add(new AboutCommand());

$uploadCommand = new GenericCommand('uploadFile', 'upload');
$uploadCommand->addArgument('filename', InputArgument::REQUIRED, 'The name of the file to upload');
$uploadCommand->addOption('dir', null, InputArgument::OPTIONAL, 'Which directory to upload from', './');

$console->add($uploadCommand);


$helloWorldCallable = function ($name) {
    echo "Hello world, and particularly $name".PHP_EOL;
};

$callableCommand = new GenericCommand($helloWorldCallable, 'greet');
$callableCommand->addArgument('name', InputArgument::REQUIRED, 'The name of the person to say hello to.');
$callableCommand->setDescription("Says hello to the world and one named person");
$console->add($callableCommand);

try {
    $parsedCommand = $console->parseCommandLine();

    if ($error = $parsedCommand->getError()) {
        echo $error->getMessage();
        exit(-1);
    }
    
    $provider = new Auryn\Provider();
    $provider->execute(
        $parsedCommand->getCallable(),
        lowrey($parsedCommand->getParams())
    );
}
catch(\Exception $e) {
    $output = new BufferedOutput();
    $console->renderException($e, $output);
    echo $output->fetch();
}






