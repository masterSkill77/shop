<?php

namespace App\Console\Commands;

use App\Models\Role;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;

class InitApp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'init:app';

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
        Artisan::call('key:generate');
        Artisan::call('migrate');
        Artisan::call('db:seed');
        $this->info('App initialized');
        Role::create([
            'role_name' => 'ADMIN'
        ]);
        Role::create([
            'role_name' => 'MODERATOR'
        ]);
        User::create([
            'email' => 'admin@gmail.com',
            'name' => 'admin',
            'password' => Hash::make('admin'),
            'role_id' => 1
        ]);
        User::create([
            'email' => 'moderator@gmail.com',
            'name' => 'moderator',
            'password' => Hash::make('moderator'),
            'role_id' => 2
        ]);
        $this->info("Account created, there are credentials : \nAdmin Email : admin@gmail.com\nAdmin password : admin\nModerator Email : moderator@gmail.com\nModerator password : moderator");
        return 0;
    }
}
