<?php

namespace Uxx\Demo\Console;

use Illuminate\Console\Command;

class PublishCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'uxx:publish 
    {--force : Overwrite any existing files} 
    {--lang : Publish language files} 
    {--assets : Publish assets files} 
    {--config : Publish configuration files}';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "re-publish uxx's assets, configuration, language and migration files. If you want overwrite the existing files, you can add the `--force` option";

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $force = $this->option('force');
        $options = ['--provider' => 'Uxx\Demo\UxxServiceProvider'];
        if ($force == true) {
            $options['--force'] = true;
        }
        if ($this->option('lang')) {
            $options['--tag'] = 'uxx-lang';
        } elseif ($this->option('assets')) {
            $options['--tag'] = 'uxx-assets';
        } elseif ($this->option('config')) {
            $options['--tag'] = 'uxx-config';
        }

        $this->call('vendor:publish', $options);
        $this->call('view:clear');
    }
}
