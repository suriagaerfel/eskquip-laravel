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
            Schema::create('developer_tools', function (Blueprint $table) {
            $table->increments('developer_toolId'); // INTEGER PRIMARY KEY AUTO_INCREMENT

            $table->longText('developer_toolTitle');
            $table->string('developer_toolCategory', 64);
            $table->longText('developer_toolTags');
            $table->longText('developer_toolDescription');
            $table->longText('developer_toolImage');
            $table->string('developer_toolDeveloper', 64);

            $table->timestamp('developer_toolCreatedDate')->useCurrent(); // DEFAULT CURRENT_TIMESTAMP
            $table->dateTime('developer_toolPubDate');
            $table->timestamp('developer_toolUpdateDate')
                ->useCurrent()
                ->useCurrentOnUpdate(); // DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP

            $table->integer('developer_toolContentVersion')->default(1);
            $table->string('developer_toolStatus', 64)->default('Draft');
            $table->string('developer_toolAccessType', 100)->default('Free Access');
            $table->integer('developer_toolAmount')->default(0);
            $table->longText('developer_toolSharedWith');
            $table->longText('developer_toolSlug');
            $table->longText('developer_toolContent');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('developer_tools');
    }
};
