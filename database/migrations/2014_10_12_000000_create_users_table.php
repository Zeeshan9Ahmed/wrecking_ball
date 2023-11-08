<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();

            $table->integer('otp')->nullable();
            $table->string('fullname')->nullable();
            $table->string('email')->unique();
            $table->string('password')->nullable();
            $table->longText('address')->nullable();
            $table->string('profile_image')->nullable();
            $table->integer("account_verified")->default(0);
            $table->timestamp('email_verified_at')->nullable();
            
            $table->string('device_type')->nullable();
            $table->string('device_token')->nullable();
            $table->string('is_social')->default(0);
            $table->string('user_social_token')->nullable();
            $table->string('user_social_type')->nullable();
            
            $table->string('is_profile_complete')->default('0');
            $table->string('api_token')->nullable();

            $table->rememberToken();
            $table->timestamps();

        });

        User::create([
            'full_name' => "ADMIN",
            'email' => 'demouser@getnada.com',
            'password' => bcrypt('Abcd@1234')
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
