<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */

	public function up() {
		#Create Users Table
		Schema::create('users', function($table) {

			#Auto-increment the ID
			$table->increments('id');

			#General table data
			$table->string('email')->unique();
			$table->string('password');

			#created_at, updated_at columns
			$table->timestamps();
		});

		#Create Tasks Table
		Schema::create('tasks', function($table) {

			#Auto-increment the ID
			$table->increments('id');

			#General table data
			$table->varchar('task');
			$table->dateTime('duedate');
			$table->boolean('complete');
			$table->integer('user_id')->unsigned();

			#created_at, updated_at columns
			$table->timestamps();

			# Define foreign keys
			$table->foreign('user_id')
				->references('id')
				->on('users');
		});

	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */

	public function down() {
		Schema::table('tasks', function($table) {
			$table->dropForeign('tasks_user_id_foreign'); # table_fields_foreign
		});
		Schema::drop('users');
		Schema::drop('tasks');
	}

}

?>
