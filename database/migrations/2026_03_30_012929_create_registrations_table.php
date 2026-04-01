<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegistrationsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('registrations', function (Blueprint $table) {
            $table->increments('registrantId'); // INTEGER PRIMARY KEY AUTOINCREMENT in SQLite[web:13][web:16]
            $table->string('registrantCode', 64);
            $table->string('registrantFirstName', 256);
            $table->string('registrantMiddleName', 256);
            $table->string('registrantLastName', 256);
            $table->string('registrantAccountName', 100);
            $table->longText('registrantDescription');
            $table->string('registrantAccountType', 64);
            $table->integer('registrantProfilePictureStatus')->default(1);
            $table->string('registrantProfilePictureLink', 100);
            $table->string('registrantCoverPhotoLink', 100);
            $table->date('registrantBirthdate');
            $table->string('registrantGender', 64);
            $table->string('registrantCivilStatus', 64);
            $table->string('registrantAddressStreet', 100);
            $table->string('registrantAddressBarangay', 100);
            $table->string('registrantAddressCity', 100);
            $table->string('registrantAddressProvince', 100);
            $table->string('registrantAddressRegion', 100);
            $table->string('registrantAddressCountry', 100);
            $table->string('registrantAddressZipCode', 64);
            $table->string('registrantEducationalAttainment', 64);
            $table->string('registrantSchool', 100);
            $table->string('registrantOccupation', 100);
            $table->string('registrantEmailAddress', 64);
            $table->string('registrantMobileNumber', 64);
            $table->string('registrantUsername', 100);
            $table->longText('registrantPassword');
            $table->string('registrantConfirmationCode', 64);
            $table->string('registrantBasicAccount', 64);
            $table->string('registrantTeacherAccount', 64);
            $table->string('registrantWriterAccount', 64);
            $table->string('registrantEditorAccount', 64);
            $table->string('registrantWebsiteManagerAccount', 64);
            $table->string('registrantDeveloperAccount', 64);
            $table->string('registrantResearchesAccount', 64);
            $table->string('registrantVerificationStatus', 64)->default('Unverified');
            $table->string('registrantStatus', 64)->default('Good');
            $table->dateTime('registrantCreatedAt');
            $table->string('resetTokenHash', 64);
            $table->dateTime('resetTokenHashExpiration');
            $table->string('registrantPaymentChannel', 64);
            $table->string('registrantBankAccountName', 150);
            $table->string('registrantBankAccountNumber', 64);
            $table->string('registrantReviewSchedules', 150);
            $table->longText('registrantConnectedUsers');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registrations');
    }
};
