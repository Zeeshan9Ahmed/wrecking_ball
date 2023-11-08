<?php

use App\Models\Exercise;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateExercisesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exercises', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            
            $table->integer('view_count')->default(0);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
            
        });

        DB::table('exercises')->insert([
            [
                'name' => "Locomotive Forward"
            ],
            [
                'name' => "Locomotive Reverse"
            ],[
                'name' => "Behind the Head"
            ],[
                'name' => "Buff Forward"
            ],[
                'name' => "Buff Reverse"
            ],[
                'name' => "Behind the Back"
            ],[
                'name' => "Wheel Forward"
            ],[
                'name' => "Wheel Reverse"
            ],[
                'name' => "Reverse Grip Forward"
            ],
            [
                'name' => "Lat Pump"
            ],[
                'name' => "Around the world"
            ],
            
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('exercises');
    }
}
