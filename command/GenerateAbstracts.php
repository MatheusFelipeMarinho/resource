<?php

namespace Modules\Resource\Command;

use Illuminate\Console\Command;

class GenerateAbstracts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:abstracts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
     * @return int
     */
    public function handle()
    {
        $root = $this->ask('Informe o nome do pacote');

        $path = app_path($root . "/" . "Abstracts");

        if(!file_exists($path)){
            mkdir($path);
        }

        $this->service($root);
        $this->repository($root);
        $this->controller();
        $this->model();
        $this->baseController();
    }

    private function service($root)
    {
        $file = glob("**/**/**/AbstractService.txt");

        $text = file_get_contents($file[0]);

        $service = app_path($root . "/Abstracts/" . "AbstractService.php");

        $fp = fopen($service, "a");

        if($fp == false){
            dd('Não foi possível criar o arquivo.');
        }

        //Escreve no arquivo aberto.
        fwrite($fp, $text);

        //Fecha o arquivo.
        fclose($fp);
    }

    private function repository($root)
    {
        $file = glob("**/**/**/AbstractRepository.txt");

        $text = file_get_contents($file[0]);

        $service = app_path($root . "/Abstracts/" . "AbstractRepository.php");

        $fp = fopen($service, "a");

        if($fp == false){
            dd('Não foi possível criar o arquivo.');
        }

        //Escreve no arquivo aberto.
        fwrite($fp, $text);

        //Fecha o arquivo.
        fclose($fp);
    }

    private function controller()
    {
        $file = glob("**/**/**/AbstractController.txt");

        $text = file_get_contents($file[0]);

        $service = app_path("Http/Controllers/" . "AbstractController.php");

        $fp = fopen($service, "a");

        if($fp == false){
            dd('Não foi possível criar o arquivo.');
        }

        //Escreve no arquivo aberto.
        fwrite($fp, $text);

        //Fecha o arquivo.
        fclose($fp);
    }

    private function model()
    {
        $file = glob("**/**/**/AbstractModel.txt");

        $text = file_get_contents($file[0]);

        $service = app_path("Models/" . "AbstractModel.php");

        $fp = fopen($service, "a");

        if($fp == false){
            dd('Não foi possível criar o arquivo.');
        }

        //Escreve no arquivo aberto.
        fwrite($fp, $text);

        //Fecha o arquivo.
        fclose($fp);
    }

    private function baseController()
    {
        $file = glob("**/**/**/Controller.txt");

        $text = file_get_contents($file[0]);

        $controller = app_path("Http/Controllers/" . "Controller.php");

        unlink($controller);

        $fp = fopen($controller, "a");

        if($fp == false){
            dd('Não foi possível criar o arquivo.');
        }

        //Escreve no arquivo aberto.
        fwrite($fp, $text);

        //Fecha o arquivo.
        fclose($fp);

    }
}
