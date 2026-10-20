
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('knowledge_sources', function (Blueprint $table) {
            $table->id();

            // Informasi dasar sumber
            $table->string('title');
            $table->string('type', 20); // file atau text
            $table->text('description')->nullable();

            // Isi informasi teks
            $table->longText('content')->nullable();

            // Metadata file yang diunggah
            $table->string('file_path')->nullable();
            $table->string('original_filename')->nullable();
            $table->string('mime_type')->nullable();
            $table->unsignedBigInteger('file_size')->nullable();

            // Status pemrosesan untuk AI Agent
            $table->string('status', 20)->default('pending');
            $table->text('processing_error')->nullable();
            $table->timestamp('processed_at')->nullable();

            // Pengguna yang menambahkan sumber
            $table->foreignId('created_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamps();

            $table->index(['type', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('knowledge_sources');
    }
};
