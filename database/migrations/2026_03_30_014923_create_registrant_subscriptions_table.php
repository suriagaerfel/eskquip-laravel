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
        Schema::create('registrant_subscriptions', function (Blueprint $table) {
            $table->id('registrant_subscriptionId');  // int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY
            
            $table->unsignedInteger('registrant_subscriptionUserId');  // int(11) NOT NULL
            $table->longText('registrant_subscriptionRegistrantAccountName');  // longtext NOT NULL
            $table->string('registrant_subscriptionType', 64);  // varchar(64) NOT NULL
            $table->string('registrant_subscriptionDuration', 2)->default('1');  // varchar(2) NOT NULL DEFAULT '1'
            $table->unsignedInteger('registrant_subscriptionTotal');  // int(11) NOT NULL
            $table->string('registrant_subscriptionPaymentOption', 64);  // varchar(64) NOT NULL
            $table->string('registrant_subscriptionSenderName', 250);  // varchar(250) NOT NULL
            $table->string('registrant_subscriptionSenderAccountNumber', 64);  // varchar(64) NOT NULL
            $table->string('registrant_subscriptionRefNumber', 64);  // varchar(64) NOT NULL
            $table->string('registrant_subscriptionProofOfPayment', 100);  // varchar(100) NOT NULL
            $table->dateTime('registrant_subscriptionTimestamp')->useCurrent();  // datetime NOT NULL DEFAULT current_timestamp()
            $table->string('registrant_subscriptionStatus', 64)->default('Pending');  // varchar(64) NOT NULL DEFAULT 'Pending'
            $table->dateTime('registrant_subscriptionDate')->nullable();  // datetime DEFAULT NULL
            $table->dateTime('registrant_subscriptionExpiry')->nullable();  // datetime DEFAULT NULL
            
            $table->timestamps();  // Laravel standard created_at/updated_at
            
            $table->index(['registrant_subscriptionUserId', 'registrant_subscriptionStatus']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registrant_subscriptions');
    }
};
