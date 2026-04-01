<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('appointments', function (Blueprint $table) {
        $table->id();
        $table->string('client'); // cliente
        $table->string('service'); // serviço
        $table->date('date'); // data
        $table->time('time'); // horário
        $table->text('observation')->nullable(); // observação (pode ser vazia)
        
        // Status com valores fixos e padrão 'pendente'
        $table->enum('status', ['pendente', 'concluído', 'cancelado'])->default('pendente'); 
        
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
