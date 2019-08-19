<?php

namespace App\Command;

use Maknz\Slack\Message;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Yaml\Yaml;
use AdamBrett\ShellWrapper\Command as ExecCommand;
use AdamBrett\ShellWrapper\Command\Param;
use AdamBrett\ShellWrapper\Runners\Exec;
use Dotenv\Dotenv;
use Maknz\Slack\Client;

class RunAuditsCommand extends Command
{
    const DRUTINY_EXEC = "./bin/drutiny";

    protected static $defaultName = 'app:run';

    protected function configure()
    {
        $this->setDescription('This will run the audit for all sites defined in the lagoonprojects.yml file');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $dotenv = Dotenv::create(__DIR__ . "/../../");
        $dotenv->load();


        //TODO: read in all the site aliases again.
        $siteAliases = Yaml::parseFile("./lagoonprojects.yml");
        //TODO: run through 'em running the drutiny stuff.
        foreach ($siteAliases as $siteName => $siteDetails) {
            $shell = new Exec();
            $command = new \AdamBrett\ShellWrapper\Command(self::DRUTINY_EXEC);
            $command->addParam(new Param('policy:audit'));
            $command->addFlag(new ExecCommand\Flag('fmarkdown'));
            $command->addFlag(new ExecCommand\Flag('ostdout'));
            $command->addParam(new Param('Drupal-8:CssAggregation'));
            $command->addParam(new Param(sprintf("@%s", $siteName)));

            $output = $shell->run($command);
            var_dump($output);

            if(!empty($output)) {
                $client = new Client(getenv('SLACK_WEBHOOK'));
                $client->send($output);
            }

        }

    }

}