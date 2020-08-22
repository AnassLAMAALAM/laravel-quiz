<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        
        DB::table('choices')->delete();
        DB::table('questions')->delete();
        DB::table('quizzes')->delete();
        DB::table('users')->delete();
        DB::table('modules')->delete();
        DB::table('user_quiz')->delete();

        factory(App\User::class, rand(1,5))->create()->each(function($user) {
            $user->modules()->saveMany(factory(App\Module::class, rand(1,5))->make())
              ->each(function ($module) {
                $module->quizzes()->saveMany(factory(App\Quiz::class, rand(1,5))->make())
                ->each(function($quiz){ 
                $quiz->questions()->saveMany(factory(App\Question::class, 5)->make())
                    ->each(function($question){ 
                        $question->choices()->saveMany(factory(App\Choice::class, rand(1,5))->make());
                });
             });
              });
        });  


        $users = DB::table('users')->get();
        $quizzes = DB::table('quizzes')->get();

        for ($i=0; $i <rand(0,10) ; $i++) { 
            $user_id = $users->random(1)[0]->id;
            $quiz_id = $quizzes->random(1)[0]->id;
            DB::table('user_quiz')->insert([
                'user_id' => $user_id,
                'quiz_id' => $quiz_id,
                'score' => rand(0,100),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }


        // factory(App\Module::class, 5)->create();
        // factory(App\Quiz::class, 5)->create();
                
        
    }
}
