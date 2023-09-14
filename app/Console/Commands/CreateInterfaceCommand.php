<?php

namespace App\Console\Commands;


class CreateInterfaceCommand extends FileFactoryCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:interface {classname}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'this command for create interface class pattern';

    function setStubName(): string
    {
        return "interface";
    }

    function setFilePath(): string{
        return "APP\\Interface\\";
    }

    function setSuffix(): string{
        return "Interface";
    }

}
