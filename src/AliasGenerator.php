<?php

namespace App;

use Amazee\LaragoonSupport\SiteAliases;
use Symfony\Component\Yaml;

class AliasGenerator
{

    public static function loadProjectsFromConfig(
      $configFile = "./lagoonprojects.yml"
    ) {
        if (empty($configFile) || !file_exists($configFile)) {
            throw new \Exception("Issue with config file: " . $configFile);
        }

        return Yaml\Yaml::parseFile($configFile);
    }

    public static function getSiteAliases()
    {

        $return = [];

        $projects = self::loadProjectsFromConfig();

        foreach ($projects as $name => $details) {
            $sa = new SiteAliases($name);
            $aliases = $sa->getAliases(); //This'll load up the aliases for the
            //project we're currently looking at
            foreach ($aliases as $aliasName => $alias) {
                if ($aliasName == $details['branch']) {
                    $return[$name] = $alias;
                }
            }
        }

        return $return;
    }
}