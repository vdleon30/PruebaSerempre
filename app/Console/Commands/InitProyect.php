<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class InitProyect extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:initProyect';

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
        $this->info('¡Bienvenido!');
        $this->info('¡Procederemos a la configuración de la base de datos...!');
        $number = 0;
        while (intval($number) == 0) {
            $number = $this->ask('¿Cuantos Registros de Usuarios y Clientes desea generar?');
            if ($number == 0) {
                $this->error('¡Indroduzca un numero válido!');
            }
        }
        $bar = $this->output->createProgressBar($number*2+50);
        $this->info("¡Procederemos a realizar los {$number} registros! Por favor sea paciente");

        $bar->start();
        \Artisan::call("migrate:refresh --seed");
        \Artisan::call('vendor:publish --provider="Intervention\Image\ImageServiceProviderLaravelRecent"');
        $bar->advance(30);
        for ($i=1; $i < 20; $i++) { 
            \App\Models\City::factory(1)->create();
            $bar->advance();
        }
        for ($i=1; $i < $number; $i++) { 
            \App\Models\User::factory(1)->create();
            $bar->advance();
        }
        for ($i=1; $i < $number; $i++) { 
            \App\Models\Client::factory(1)->create();
            $bar->advance();
        }
        $bar->finish();
        $this->newLine();
        $this->info('¡Muchas Gracias por su paciencia!');
        $this->newLine();
        $this->info('¡Ya puede ingresar al sistema con las siguentes credenciales mail:user@user.com pass:test1234!');
        $this->newLine();
        $this->info('Usuario Administrador - mail:admin@admin.com pass:admin1234');
        $this->info('Usuario Normal - mail:user@user.com pass:test1234');

    }
}
