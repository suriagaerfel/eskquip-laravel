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
       Schema::create('school_researches', function (Blueprint $table) {
            $table->id('school_researchId');  // int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY
            
            $table->longText('school_researchTitle');  // longtext NOT NULL
            $table->longText('school_researchSlug');   // longtext NOT NULL
            $table->string('school_researchCategory', 64);  // varchar(64) NOT NULL
            $table->longText('school_researchTags');   // longtext NOT NULL
            $table->string('school_researchAccessType', 100)->nullable();  // varchar(100) DEFAULT NULL
            $table->longText('school_researchSharedWith');  // longtext NOT NULL
            $table->longText('school_researchAbstract');    // longtext NOT NULL
            $table->string('school_researchImage', 100);    // varchar(100) NOT NULL
            $table->string('school_researchFormat', 64);    // varchar(64) NOT NULL
            $table->unsignedInteger('school_researchSchool');  // int(11) NOT NULL
            $table->string('school_researchProponents', 64);   // varchar(64) NOT NULL
            $table->dateTime('school_researchUploadDate');     // datetime NOT NULL
            $table->date('school_researchDate');               // date NOT NULL
            $table->dateTime('school_researchLiveDate');       // datetime NOT NULL
            $table->dateTime('school_researchUpdateDate')->useCurrentOnUpdate();  // datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
            $table->string('school_researchStatus', 64)->default('Draft');  // varchar(64) NOT NULL DEFAULT 'Draft'
            $table->longText('school_researchContent');        // longtext NOT NULL
            $table->unsignedInteger('school_researchContentVersion')->default(1);  // int(11) NOT NULL DEFAULT 1
            
            $table->timestamps();  // Laravel standard created_at/updated_at
            
            $table->index(['school_researchSchool', 'school_researchStatus', 'school_researchLiveDate']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('school_researches');
    }
};
