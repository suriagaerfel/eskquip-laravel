
<?php require_once app_path('Includes/variables/url.php'); ?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

</head>




<body>
    <nav>
      <x-nav-links>
        <a href="<?php echo $publicFolder; ?>">Home</a>
        <a href="<?php echo $publicFolder.'/articles'; ?>">Articles</a>
        <a href="<?php echo $publicFolder.'/teacher-files'; ?>">Teacher Files</a>
        <a href="<?php echo $publicFolder.'/researches'; ?>">Researches</a>
        <a href="<?php echo $publicFolder.'/tools'; ?>">Tools</a>

    </x-nav-links>
    </nav>

    {{$slot}}
 
</body>
</html>

