
Disclaimer
==========

This is not the Symfony console - it is a forking refactor to:

* To split the 'routing' and dispatching of commands.
* Remove the events, because they don't belong in what should be a reasonable, simple piece of code.
* Stop the console application catching and dumping exceptions when it has no idea how to handle them.

Basically although most of the Symfony/console library does a great job, the fact that you have to let it run the application is stupid. The console library should stick to console stuff, you should then be able to run the application yourself.

The example below shows how to create commands with a callable, have the console application 'route' the input, and then run the callable with [Auryn](https://github.com/rdlowrey/Auryn).

```

$console = new Application();
$console->add(new AboutCommand());

//Create a command that will call the function 'uploadFile'
$uploadCommand = new GenericCommand('uploadFile', 'upload');
$uploadCommand->addArgument('name', InputArgument::REQUIRED, 'The name of the thing to foo');
$console->add($uploadCommand);


$helloWorldCallable = function ($name) {
    echo "Hello world, and particularly $name".PHP_EOL;
};

//Create a command that will call the closure
$callableCommand = new GenericCommand($helloWorldCallable, 'greet');
$callableCommand->addArgument('name', InputArgument::REQUIRED, 'The name of the person to say hello to.');
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



function uploadFile($filename) {
    echo "Need to upload the file $filename".PHP_EOL;
}


function lowrey($params) {
    $newParams = [];
    foreach ($params as $key => $value) {
        $newParams[':'.$key] = $value;
    }
    return $newParams;
}


```

If the example above was in the file example.php running the command `php example.php greet Danack` would output:

> Hello world, and particularly Danack

\o/



Console Component
=================

Console eases the creation of beautiful and testable command line interfaces.

The Application object manages the CLI application:

    use Symfony\Component\Console\Application;

    $console = new Application();
    $console->run();

The ``run()`` method parses the arguments and options passed on the command
line and executes the right command.

Registering a new command can easily be done via the ``register()`` method,
which returns a ``Command`` instance:

    use Symfony\Component\Console\Input\InputInterface;
    use Symfony\Component\Console\Input\InputArgument;
    use Symfony\Component\Console\Input\InputOption;
    use Symfony\Component\Console\Output\OutputInterface;

    $console
        ->register('ls')
        ->setDefinition(array(
            new InputArgument('dir', InputArgument::REQUIRED, 'Directory name'),
        ))
        ->setDescription('Displays the files in the given directory')
        ->setCode(function (InputInterface $input, OutputInterface $output) {
            $dir = $input->getArgument('dir');

            $output->writeln(sprintf('Dir listing for <info>%s</info>', $dir));
        })
    ;

You can also register new commands via classes.

The component provides a lot of features like output coloring, input and
output abstractions (so that you can easily unit-test your commands),
validation, automatic help messages, ...

Tests
-----

You can run the unit tests with the following command:

    $ cd path/to/Symfony/Component/Console/
    $ composer.phar install
    $ phpunit

Third Party
-----------

`Resources/bin/hiddeninput.exe` is a third party binary provided within this
component. Find sources and license at https://github.com/Seldaek/hidden-input.

Resources
---------

[The Console Component](http://symfony.com/doc/current/components/console.html)

[How to create a Console Command](http://symfony.com/doc/current/cookbook/console/console_command.html)
