

  <?php require app_path('Includes/processing/registrant-records.php'); ?>
    <?php require app_path('Includes/sections/header.php'); ?>


<div class=" page workspace-page">
    <?php if ($pageName != 'Workspace - Website Manager') {
      require app_path('Includes/sections/workspace-sidebar.php');
       require app_path('Includes/sections/actual-workspace.php');
   
     }?>

    
     <?php if ($pageName == 'Workspace - Website Manager') {
           require app_path('Includes/sections/summary.php');
     }?>
</div>



<?php require app_path('Includes/sections/footer.php');?>

</body>
</html>

