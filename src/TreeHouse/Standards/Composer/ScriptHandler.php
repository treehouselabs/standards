<?php

namespace TreeHouse\Standards\Composer;

use Composer\Script\Event;

class ScriptHandler
{
    public static function installPreCommitHook(Event $event)
    {
        $io = $event->getIO();
        $gitHook = file_get_contents(__DIR__.'/../../../../.git/hooks/pre-commit');
        $docHook = file_get_contents(__DIR__.'/../../../../docs/hooks/pre-commit');

        $result = true;
        if ($gitHook !== $docHook) {
            $io->write('<error>You, motherfucker, please, set up your hooks!</error>');
            $result = false;
        }

        return $result;
    }
}
