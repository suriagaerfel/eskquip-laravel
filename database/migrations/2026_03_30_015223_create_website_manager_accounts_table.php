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
       Schema::create('website_manager_accounts', function (Blueprint $table) {
            $table->id('website_manager_accountId');  // int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY
            
            $table->unsignedInteger('website_manager_accountRegistrant');  // int(11) NOT NULL (user ID)
            
            // Role flags (varchar(100), empty='' means no access)
            $table->string('website_manager_accountSuperManager', 100);  // 'Super Manager'
            $table->string('website_manager_accountSubscriptionManager', 100)->default('');  
            $table->string('website_manager_accountRegistrationManager', 100)->default('');
            $table->string('website_manager_accountPromotionManager', 100)->default('');
            $table->string('website_manager_accountMessageManager', 100)->default('');
            
            $table->timestamps();  // Laravel standard created_at/updated_at
            
            $table->index('website_manager_accountRegistrant');
            $table->unique('website_manager_accountRegistrant');  // One manager account per user
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('website_manager_accounts');
    }
};
