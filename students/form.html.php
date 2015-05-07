<?php include_once '../includes/functions.inc.php'; ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <link rel="stylesheet" type="text/css" href="../includes/style.css">
    <meta charset="utf-8">
    <title><?php htmlout($pageTitle); ?></title>
  </head>
  <body>
    <h1><?php htmlout($pageTitle); ?></h1>
    <form action="?<?php htmlout($action); ?>" method="post">
      <div>
        <label for="id">ID: <input <?php if ($action == 'editform') echo 'readonly'; ?>
        type="text" name="id" id="id" value="<?php htmlout($id); ?>"></label>
      </div>
      <div>
        <label for="name">Name: <input type="text" name="name"
            id="name" value="<?php htmlout($name); ?>"></label>
      </div>
      <div>
        <label for="email">Email: <input type="text" name="email"
            id="email" value="<?php htmlout($email); ?>"></label>
      </div>
      <div>
        <label for="cycle_id">Cycle: </label>
          <select name="cycle_id" id="cycle_id">
          <?php if( !in_array($cycle_id, $active_cycles)  ) : //for disabled cycles ?>
            <option value="<?php htmlout($cycle_id); ?>" ><?php htmlout($cycle_id); ?></option>
          <?php endif; ?>
          <?php foreach ($active_cycles as $cycle): ?>
            <option value="<?php htmlout($cycle); ?>"
            <?php
                if ($cycle == $cycle_id)
                {
                  echo ' selected';
                }
                ?>>
            <?php htmlout($cycle); ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div>
        <input type="submit" value="<?php htmlout($button); ?>">
      </div>
    </form>
  </body>
</html>
