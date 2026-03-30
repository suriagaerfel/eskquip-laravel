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
        Schema::create('teacher_files', function (Blueprint $table) {
            $table->id('teacher_fileId');  // int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY
            
            $table->longText('teacher_fileTitle');      // longtext NOT NULL
            $table->longText('teacher_fileSlug');       // longtext NOT NULL
            $table->string('teacher_fileCategory', 64); // varchar(64) NOT NULL
            $table->longText('teacher_fileTags');       // longtext NOT NULL
            $table->string('teacher_fileAccessType', 64)->default('Free');  // varchar(64) NOT NULL DEFAULT 'Free'
            $table->string('teacher_fileSharedWith', 300);  // varchar(300) NOT NULL (comma-separated IDs)
            $table->longText('teacher_fileDescription');    // longtext NOT NULL
            $table->unsignedInteger('teacher_fileContentVersion');  // int(11) NOT NULL
            $table->string('teacher_fileImage', 100);       // varchar(100) NOT NULL
            $table->string('teacher_fileFormat', 64);       // varchar(64) NOT NULL
            $table->string('teacher_fileTeacher', 64);      // varchar(64) NOT NULL
            $table->dateTime('teacher_fileUploadDate');     // datetime NOT NULL
            $table->dateTime('teacher_filePubDate');        // datetime NOT NULL
            $table->dateTime('teacher_fileUpdateDate')->useCurrentOnUpdate();  // datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
            $table->string('teacher_fileStatus', 64)->default('Draft');  // varchar(64) NOT NULL DEFAULT 'Draft'
            $table->string('teacher_fileForSale', 64)->default('Not for Sale');  // varchar(64) NOT NULL DEFAULT 'Not for Sale'
            $table->unsignedInteger('teacher_fileAmount', false, 7);  // int(7) NOT NULL (price)
            $table->longText('teacher_fileContent');        // longtext NOT NULL (file path)
            
            $table->timestamps();  // Laravel standard created_at/updated_at
            
            $table->index(['teacher_fileTeacher', 'teacher_fileStatus', 'teacher_filePubDate']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teacher_files');
    }
};
