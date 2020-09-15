<?php

namespace Uxx\Demo\Console;

use Illuminate\Console\Command;

class InstallCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'uxx:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install the uxx package';

    /**
     * Install directory.
     *
     * @var string
     */
    protected $directory = '';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->initDatabase();

        $this->initDirectory();
    }

    /**
     * Create tables and seed it.
     *
     * @return void
     */
    public function initDatabase()
    {
        $this->call('migrate');
        //
        // $userModel = config('uxx.database.users_model');
        // // if ($userModel::count() == 0) {//数据库是否有数据
        // //     $this->call('db:seed', ['--class' => \Uxx\Demo\Seeds\DemoSeeder::class]);
        // // }
    }

    /**
     * Initialize the admAin directory.
     *
     * @return void
     */
    protected function initDirectory()
    {
        $this->directory = config('uxx.directory');

        if (is_dir($this->directory)) {
            $this->line("<error>{$this->directory} directory already exists !</error> ");

            return;
        }
        $this->makeDir('/');
        $this->line('<info>uxx directory was created:</info> '.str_replace(base_path(), '', $this->directory));
      info($this->directory);
        $this->createBootstrapFile();
       
    }

     

    /**
     * Create routes file.
     *
     * @return void
     */
    protected function createBootstrapFile()
    {
        $file = $this->directory.'/bootstrap.php';
        $contents = $this->getStub('bootstrap');
        $this->laravel['files']->put($file, $contents);
        $this->line('<info>Bootstrap file was created:</info> '.str_replace(base_path(), '', $file));
    }
    /**
     * Get stub contents.
     *
     * @param $name
     *
     * @return string
     */
    protected function getStub($name)
    {
        return $this->laravel['files']->get(__DIR__."/stubs/$name.stub");
    }

    /**
     * Make new directory.
     *
     * @param string $path
     */
    protected function makeDir($path = '')
    {
        $this->laravel['files']->makeDirectory("{$this->directory}/$path", 0755, true, true);
    }
}
