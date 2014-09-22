Dispatching Commands
====================

You can use whichever library or code you like to dispatch the callables returned by the ParsedCommand object.

However I strongly recommend using `Auryn <https://github.com/rdlowrey/auryn>`_ - it's one of the only libraries to do Dependency Injection correctly, and is easier to use than the other DI libraries out there. 

Dispatching callables with Auryn is trivial:

.. code-block:: php

    <?php

    $provider = new Auryn\Provider();
    
    // Pass in the callable, and the parameters
    $provider->execute(
        $parsedCommand->getCallable(),
        formatKeyNames($parsedCommand->getParams())
    );

    // Auryn needs scalars prefixed with a colon to separate them 
    // from class aliases
    function formatKeyNames($params) {
        $newParams = [];
        foreach ($params as $key => $value) {
            $newParams[':'.$key] = $value;
        }

        return $newParams;
    }

