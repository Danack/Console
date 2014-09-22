Migrating from Symfony/Console
==============================

The only major work needed to migrate from Symfony/console to Danack/console is to change any command objects to return a callable instead of having an execute method.

This includes commands that just display information rather than having a 'proper' executable e.g. the ListCommand.

Then just change from:

Application::run which runs the command and returns a status code
to

Application::parseCommandLine which just parsed the command line args and returns a ParsedCommand object.