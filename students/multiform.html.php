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
        <label for="emails">Emails: (One per line)</label>
        <br />
        <textarea name="emails" rows="25" cols="100" wrap='off'></textarea>
      </div>
      <div>
        <input type="hidden" name="id" value="<?php htmlout($id); ?>">
        <input type="submit" value="<?php htmlout($button); ?>">
      </div>
    </form>
  </body>
</html>
