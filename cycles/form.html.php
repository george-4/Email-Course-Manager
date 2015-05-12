<?php include_once '../includes/functions.inc.php'; ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <script src="//code.jquery.com/jquery-1.10.2.js"></script>
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <link rel="stylesheet" type="text/css" href="../includes/style.css">
    
    <script>
    $(function() {
      $( "#startdate" ).datepicker({dateFormat: 'yy-mm-dd'});
    });
    </script>
    <meta charset="utf-8">
    <title><?php htmlout($pageTitle); ?></title>
  </head>
  <body>
    <h1><?php htmlout($pageTitle); ?></h1>
    <form action="?<?php htmlout($action); ?>" method="post">
      <div>
        <label for="startdate">Start Date: <input type="text" name="startdate"
            id="startdate" value="<?php htmlout($startdate); ?>"></label>
      </div>
      <div>
        <label for="id">ID: <input <?php if ($action == 'editform') echo 'readonly'; ?> type="text" name="id"
            id="id" value="<?php htmlout($id); ?>"></label>
      </div>
      <div>
        <label for="id">Lessons already sent: <input type="text" name="lessons_sent"
            id="lessons_sent" value="<?php htmlout($lessons_sent); ?>"></label>
      </div>
      <div>
        <input type="submit" value="<?php htmlout($button); ?>">
      </div>
    </form>
  </body>
</html>
