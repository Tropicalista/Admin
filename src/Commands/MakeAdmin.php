<?php

namespace Tropicalista\Admin\Commands;

use Illuminate\Console\Command;
use Illuminate\Console\DetectsApplicationNamespace;

class MakeAdmin extends Command
{

    use DetectsApplicationNamespace;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:admin {--routes : Only scaffold the Admin routes}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create admin scaffolding files.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->createDirectories();

        $this->exportViews();
        
        if (! $this->option('views')) {

            $this->info('Updated Routes File.');
            file_put_contents(
               // app_path('Http/routes.php'),
               base_path('routes/web.php'),
                file_get_contents(__DIR__.'/../../../stubs/routes.stub'),
                FILE_APPEND
            );
        }
        $this->comment('Admin scaffolding generated successfully!');
    }

    /**
     * Compiles the HTTP controller stubs.
     *
     * @param $stubName
     * @return string
     */
    protected function compileControllerStub($stubName)
    {
        return str_replace(
            '{{namespace}}',
            $this->getAppNamespace(),
            file_get_contents(__DIR__.'/../../../stubs/controllers/'.$stubName.'.stub')
        );
    }
}
