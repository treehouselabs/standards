<?php

namespace TreeHouse\Standards\Composer;

use Composer\Script\Event;
use Webmozart\PathUtil\Path;

class ScriptHandler
{
    /**
     * @param Event $event
     */
    public static function installPreCommitHook(Event $event)
    {
        $config = $event->getComposer()->getConfig();
        $vendor = $config->get('vendor-dir');

        $hook    = __DIR__ . '/../../../../hooks/pre-commit';
        $gitHook = $vendor . '/../.git/hooks/pre-commit';

        if (file_exists($gitHook) || !is_dir(dirname($gitHook))) {
            return;
        }

        $event->getIO()->write('Installing git pre-commit hook');

        $baseDir = Path::getLongestCommonBasePath([
            $config->get('bin-dir'),
            __DIR__,
        ]);

        $relativeBinDir = sprintf('$PWD/%s', Path::makeRelative($config->get('bin-dir'), $baseDir));
        $contents       = str_replace('%bin_dir%', $relativeBinDir, file_get_contents($hook));

        // write the file
        if (false === file_put_contents($gitHook, $contents)) {
            throw new \RuntimeException(sprintf('Could not write git pre-commit hook to %s', $gitHook));
        }

        // fix permissions
        if (false === chmod($gitHook, 0755)) {
            throw new \RuntimeException('Could not change permissions for git pre-commit hook to 0755');
        }
    }
}
