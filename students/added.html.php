<?php include_once '../includes/functions.inc.php'; ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <link rel="stylesheet" type="text/css" href="../includes/style.css">
    <meta charset="utf-8">
    <title>Student Added</title>
  </head>
  <body>
    <h1>Student Added</h1>
    <p> Student Added with ID: <?php htmlout($_POST['id']);?>, email: <?php htmlout($_POST['email']);?>, 
    Name: <?php htmlout($_POST['name']);?> , Cycle: <?php htmlout($_POST['cycle_id']);?> </p>
    
    <p>In this Cycle there are <?php htmlout($lessons_sent);?> lessons sent.
    <form action="." method="post">
    <div>
      <input type="hidden" name="id" value="<?php echo $_POST['id']; ?>">
      <input type="hidden" name="name" value="<?php echo $_POST['name']; ?>">
      <input type="hidden" name="email" value="<?php echo $_POST['email']; ?>">
      <input type="hidden" name="num_of_lessons" value="<?php echo $lessons_sent; ?>">
      <input type="hidden" name="action" value="sendpastlessons">
      <input type="submit" name="Send Now" value="Send Now">
    </div>
    </form>
    <p><a href=".">Return to students</a></p>
    <p><a href="..">Return to home</a></p>
  </body>
</html>