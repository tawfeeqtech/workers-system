<?php

namespace App\Console\Commands;


class CreateServiceClass extends FileFactoryCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:service {classname}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'this command for create service class pattern';

    function setStubName(): string
    {
        return "service";
    }

    function setFilePath(): string{
        return "APP\\Services\\";
    }

    function setSuffix(): string{
        return "Service";
    }

}
