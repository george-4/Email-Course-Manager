<?php include_once '../includes/functions.inc.php'; ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <link rel="stylesheet" type="text/css" href="../includes/style.css">
    <meta charset="utf-8">
    <title>Manage Cycles</title>
  </head>
  <body>
    <h1>Manage Cycles</h1>
    <p><a href="?add">Add new cycle</a></p>
    <?php if ($cycles): ?>
    <table>
      <tr><td>ID</td><td>Starting Date</td><td>Lessons Sent</td></tr>

      <?php foreach ($cycles as $cycle): ?>
        <tr>
          <form action="" method="post">
            <td><?php htmlout($cycle['id']); ?></td>
            <td><?php htmlout($cycle['startdate']); ?></td>
            <td><?php htmlout($cycle['lessons_sent']); ?></td>
            <td><input type="submit" name="action" value="Edit"></td>
            <td><input type="submit" name="action" value="Delete"></td>
            <input type="hidden" name="id" value="<?php echo $cycle['id']; ?>">
          </form>
        </tr>
      <?php endforeach; ?>
    </table>
    
    <?php else: ?>
      <p> No Cycles created yet. </p>
    <?php endif; ?>
    <p><a href="..">Return to home</a></p>
  </body>
</html>
