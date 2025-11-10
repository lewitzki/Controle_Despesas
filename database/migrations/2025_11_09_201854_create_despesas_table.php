<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{
public function up(): void
{
Schema::create('despesas', function (Blueprint $table) {
$table->id();
$table->foreignId('user_id')->constrained()->onDelete('cascade');
$table->string('descricao');
$table->decimal('valor', 10, 2);
$table->string('categoria');
$table->date('data');
$table->timestamps();
});
}


public function down(): void
{
Schema::dropIfExists('despesas');
}
};    

   