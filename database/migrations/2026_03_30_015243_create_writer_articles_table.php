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
        Schema::create('writer_articles', function (Blueprint $table) {
            $table->id('writer_articleId');  // int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY
            
            $table->longText('writer_articleTitle');        // longtext NOT NULL
            $table->longText('writer_articleDescription');  // longtext NOT NULL
            $table->longText('writer_articleSlug');         // longtext NOT NULL
            $table->string('writer_articleImage', 150);     // varchar(150) NOT NULL
            $table->string('writer_articleCategory', 64);   // varchar(64) NOT NULL
            $table->string('writer_articleAccessType', 100); // varchar(100) NOT NULL
            $table->longText('writer_articleSharedWith');   // longtext NOT NULL (comma-separated IDs)
            $table->longText('writer_articleTags');         // longtext NOT NULL
            $table->unsignedInteger('writer_articleWriter'); // int(11) NOT NULL (writer ID)
            $table->string('writer_articleWriterName', 256); // varchar(256) NOT NULL
            $table->text('writer_articleEditors');          // text NOT NULL (editor IDs)
            $table->dateTime('writer_articleWriteDate')->useCurrent();  // datetime NOT NULL DEFAULT current_timestamp()
            $table->dateTime('writer_articleUpdateDate')->useCurrentOnUpdate();  // datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
            $table->dateTime('writer_articlePubDate');     // datetime NOT NULL
            $table->longText('writer_articleContent');      // longtext NOT NULL
            $table->unsignedInteger('writer_articleContentVersion')->default(1);  // int(11) NOT NULL DEFAULT 1
            $table->string('writer_articleStatus', 64)->default('Draft');  // varchar(64) NOT NULL DEFAULT 'Draft'
            $table->longText('writer_articleComments');     // longtext NOT NULL
            
            $table->timestamps();  // Laravel standard created_at/updated_at
            
            $table->index(['writer_articleWriter', 'writer_articleStatus']);
            $table->index('writer_articlePubDate');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('writer_articles');
    }
};
