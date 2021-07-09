<?php

namespace App\Console\Commands;

use App\Model\Category;
use App\Model\Tag;
use Illuminate\Console\Command;

class RefreshDatabaseCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'refresh:database';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Ini buat ngerefresh database sekalian sama seed nya';

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
        // this->call = php artisan
        $this->call('migrate:refresh');

        $categories = collect(['Framework', 'Code', 'IOT', 'Robotic']);
        $categories->each(function ($c){
            Category::create([
                'name' => $c,
                'slug' => \Str::slug($c),
            ]);
        });

        $tags = collect(['Laravel', 'CodeIgniter', 'Ruby', 'CSS', 'PHP', 'AJAX', 'Bugs', 'HELP']);
        $tags->each(function ($t){
            Tag::create([
                'name' => $t,
                'slug' => \Str::slug($t),
            ]);
        });

        $this->info('berhasil coy');
    }
}
