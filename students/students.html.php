<?php include_once '../includes/functions.inc.php'; ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <link rel="stylesheet" type="text/css" href="../includes/style.css">
    <meta charset="utf-8">
    <title>Manage Students</title>
  </head>
  <body>
    <h1>Manage Students</h1>
    <p><a href="?add">Add new student</a></p>
    <p><a href="?multiadd">Multi add students</a></p>
    
    <?php foreach ($cycles as $cycle): ?>
    <form action="" method="get">
        <input type="hidden" name="cycle" value="<?php htmlout($cycle['id']); ?>">
        <input type="submit" value="Cycle <?php htmlout($cycle['id']); ?>">
     </form>
    <?php endforeach; ?>


    <form action="" method="">
        <input type="submit" value="Show All">
     </form>
     
     <br>
    
    <?php if ($students): ?>
    <table>
      <tr><td>ID</td><td>Name</td><td>Email</td><td>Cycle</td><td>Date Added</td><td>Lesson Received</td></tr>

      <?php foreach ($students as $student): ?>
        <tr>
          <form action="" method="post">
            <td><?php htmlout($student['id']); ?></td>
            <td><?php htmlout($student['name']); ?></td>
            <td><?php htmlout($student['email']); ?></td>
            <td><?php htmlout($student['cycle_id']); ?></td>
            <td><?php htmlout($student['date_added']); ?></td>
            <td><?php htmlout($student['lessons_received']); ?></td>
            <td><input type="submit" name="action" value="Edit"></td>
            <td><input type="submit" name="action" value="Delete"></td>
            <input type="hidden" name="id" value="<?php echo $student['id']; ?>">
          </form>
        </tr>
      <?php endforeach; ?>
    </table>
    
    <?php else: ?>
      <p> No students found. </p>
    <?php endif; ?>
    <p><a href="..">Return to home</a></p>
  </body>
</html>
