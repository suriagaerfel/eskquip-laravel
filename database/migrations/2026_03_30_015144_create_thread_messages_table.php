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
        Schema::create('thread_messages', function (Blueprint $table) {
            $table->bigIncrements('thread_messageId');  // int(20) NOT NULL AUTO_INCREMENT PRIMARY KEY
            
            $table->string('thread_messageThreadCode', 100);  // varchar(100) NOT NULL (unique thread identifier)
            $table->unsignedInteger('thread_messageRegistrantId');  // int(11) NOT NULL (sender/recipient ID)
            $table->longText('thread_messageContent');  // longtext NOT NULL (message body)
            $table->timestamp('thread_messageTimestamp')->useCurrent();  // timestamp NOT NULL DEFAULT current_timestamp()
            
            // Message status tracking
            $table->string('thread_messageStatus', 64)->default('Unread');  // varchar(64) NOT NULL DEFAULT 'Unread'
            $table->string('thread_messageStatusSender', 64)->default('Read');  // varchar(64) NOT NULL DEFAULT 'Read'
            $table->string('thread_messageStatusRecipient', 64)->default('Unread');  // varchar(64) NOT NULL DEFAULT 'Unread'
            
            $table->timestamps();  // Laravel standard created_at/updated_at
            
            // Performance indexes
            $table->index('thread_messageThreadCode');
            $table->index(['thread_messageRegistrantId', 'thread_messageTimestamp']);
            $table->index('thread_messageStatus');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('thread_messages');
    }
};
