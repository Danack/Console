
.. _index:

Console
=======

This is not the Symfony console - it is a forking refactor to:

* To split the 'routing' and dispatching of commands.
* Remove the events, because they don't belong in what should be a reasonable, simple piece of code.
* Stop the console application catching and dumping exceptions when it has no idea how to handle them.


Basically although most of the Symfony/console library does a great job, the fact that you have to let it run the application is stupid. The console library should stick to console stuff, you should then be able to run the application yourself.


The example below shows how to create commands with a callable, have the console application 'route' the input, and then run the callable with Auryn.


.. code-block:: php

    $console = new Application();
    $console->add(new AboutCommand());
    
    //Create a command that will call the function 'uploadFile'
    $uploadCommand = new Command('uploadFile', 'upload');
    $uploadCommand->addArgument('name', InputArgument::REQUIRED, 'The name of the thing to foo');
    $console->add($uploadCommand);
    
    
    $helloWorldCallable = function ($name) {
        echo "Hello world, and particularly $name".PHP_EOL;
    };
    
    //Create a command that will call the closure
    $callableCommand = new Command($helloWorldCallable, 'greet');
    $callableCommand->addArgument('name', InputArgument::REQUIRED, 'The name of the person to say hello to.');
    $console->add($callableCommand);
    
    try {
        $parsedCommand = $console->parseCommandLine();
    }
    catch(\Exception $e) {
        $output = new BufferedOutput();
        $console->renderException($e, $output);
        echo $output->fetch();
        exit(-1);
    }
    
    $provider = new Auryn\Provider();
    $provider->execute(
        $parsedCommand->getCallable(),
        lowrey($parsedCommand->getParams())
    );
    
    
    
    function uploadFile($filename) {
        echo "Need to upload the file $filename".PHP_EOL;
    }
    
    //Auryn needs scalars prefixed with a colon
    function lowrey($params) {
        $newParams = [];
        foreach ($params as $key => $value) {
            $newParams[':'.$key] = $value;
        }
        return $newParams;
    }


If the example above was in the file example.php running the command ``php example.php greet Danack`` would output:

``Hello world, and particularly Danack``


If you want to see an example running please run the file src/example.php with some appropriate arguments e.g.:

php Tests/example.php upload backup.zip --dir=/var/log
php Tests/example.php greet Danack
php Tests/example.php greet
Will show the 'upload' and 'greet' commands being routed correctly




Contents:

.. toctree::
   :maxdepth: 2

   
   example
   migratingFromSymfonyConsole    
   
This site is built using `Sphinx <http://sphinx-doc.org/>`_ with the 
`Sphinx Bootstrap Theme <https://github.com/ryan-roemer/sphinx-bootstrap-theme/>`_      
  
      
      