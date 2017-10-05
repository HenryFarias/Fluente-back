<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Prettus\Repository\Generators\Stub;

class ConfigModel extends Command
{
    private $dir;
    private $dirStub;
    private $dirConfig;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'arq:generate:config:model';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Comando da arquitetura. Popula o arquivo de configuração com todas as models da aplicação';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->dir = base_path() . "\\app\\Models";
        $this->dirStub = base_path() . "\\geradores\\Stubs\\configApplication.stub";
        $this->dirConfig = base_path() . "\\config\\configApplication.php";
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $files = scandir($this->dir, 1);

        foreach ($files as $file) {
            $name = explode(".",$file);

            if (count($name) >= 3) {
                break;
            }

            if (count($name) == 2) {
                $models[] = "'" . $name[0] . "'";
            }
        }

        try {
            $stub = new Stub($this->dirStub, [
                'MODELS' => implode(",",$models),
            ]);

            $fp = fopen($this->dirConfig, 'w+');
            fwrite($fp, $stub->render());
            fclose($fp);

            $this->info("Models configuradas: " . implode(",",$models));
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
    }
}
