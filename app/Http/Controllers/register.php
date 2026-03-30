<?php 

use App\Models\Registration;

$new_registration = new Registration();
$new_registration->registrantFirstName = 'Erfel';
$new_registration->registrantMiddleName = 'Contiga';
$new_registration->registrantLastName = 'Suriaga';
$new_registration->save();



?>