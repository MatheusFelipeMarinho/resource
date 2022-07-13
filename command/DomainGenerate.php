<?php

namespace Modules\Resource\Command;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class DomainGenerate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:domain';

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

        $domain = $this->ask('Informe o dominio');

        mkdir(app_path($root . "/" . lcfirst($domain)));
        mkdir(app_path($root . "/" . lcfirst($domain) . "/entities"));
        mkdir(app_path($root . "/" . lcfirst($domain) . "/repositories"));
        mkdir(app_path($root . "/" . lcfirst($domain) . "/services"));
        mkdir(app_path($root . "/" . lcfirst($domain) . "/valueObjects"));

        $this->entity($domain, $root);
        $this->repository($domain, $root);
        $this->service($domain, $root);

        $this->runInfraStructure($domain);

    }

    private function entity($domain, $root)
    {
        $class = ucfirst($domain . "Entity");

        $model = ucfirst($domain);

        $text = "<?php

        namespace App\\$root\\$domain\Entities;

        use App\Models\\$model;

        class $class extends $model
        {

        }";

        $entity = app_path($root . "/" . $domain . "/Entities" . "/" . ucfirst($domain) . "Entity.php");

        //Variável $fp armazena a conexão com o arquivo e o tipo de ação.
        $fp = fopen($entity, "a+");

        //Escreve no arquivo aberto.
        fwrite($fp, $text);

        //Fecha o arquivo.
        fclose($fp);
    }

    private function repository($domain, $root)
    {
        $var = '$' . $domain . "Repository";

        $model = '$model';

        $this->model = '$this->model';

        $class = ucfirst($domain . "Repository");

        $entity = ucfirst($domain) . "Entity";

        $text = "<?php

        namespace App\\$root\\$domain\Repositories;

        use App\\$root\\$domain\Entity\\$entity;
        use App\\$root\Abstracts\AbstractRepository;

        class $class extends AbstractRepository
        {
           /**
            * @var $entity
            */
            protected $model;

            /**
             * CompanyRepository constructor.
             * @param $entity $model
             */
            public function __construct($entity $var)
            {
                $this->model = $var;
            }
        }";

        $repo = app_path($root . "/" . $domain . "/Repositories" . "/" . ucfirst($domain) . "Repository.php");

        //Variável $fp armazena a conexão com o arquivo e o tipo de ação.
        $fp = fopen($repo, "a+");

        //Escreve no arquivo aberto.
        fwrite($fp, $text);

        //Fecha o arquivo.
        fclose($fp);
    }

    private function service($domain, $root)
    {
        $var = '$' . $domain . "Service";

        $this->repository = '$this->repository';

        $class = ucfirst($domain . "Service");

        $repository = ucfirst($domain) . "Repository";

        $text = "<?php

        namespace App\\$root\\$domain\Repositories;

        use App\\$root\\$domain\Repositories\\$repository;
        use App\\$root\Abstracts\AbstractService;

        class $class extends AbstractService
        {
            /**
             * @var $repository
             */
            protected $repository;

            public function __construct($repository $var)
            {
                $this->repository = $var;
            }
        }";

        $service = app_path($root . "/" . $domain . "/Services" . "/" . ucfirst($domain) . "Service.php");

        //Variável $fp armazena a conexão com o arquivo e o tipo de ação.
        $fp = fopen($service, "a+");

        //Escreve no arquivo aberto.
        fwrite($fp, $text);

        //Fecha o arquivo.
        fclose($fp);
    }

    private function runInfraStructure($domain)
    {
        Artisan::call("make:model $domain -m -f -s");
        Artisan::call("make:controller $domain");
    }
}
