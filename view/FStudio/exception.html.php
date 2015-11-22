<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>ERROR</title>
    <link rel="stylesheet" href="<?php echo $fsConfig->getUrl() ?>css/FStudio.css">
  </head>
  <body>
    <div class="error">
      <h1><i class="fs-icon-bug"></i> ERROR!!!</h1>
      <div>
        <div>
          <p><b>Message:</b> <?php echo $exc->getMessage() ?></p>
          <p><b>File:</b> <?php echo $exc->getFile() ?></p>
          <p><b>Line:</b> <?php echo $exc->getLine() ?></p>
          <p>
            <b>Trace:</b>
          </p>
          <?php $trace = $exc->getTrace() ?>
          <?php if (extension_loaded('xdebug') === false): ?>
            <pre><?php print_r($trace) ?></pre>
          <?php else: ?>
            <?php var_dump($trace) ?>
          <?php endif ?>
        </div>
      </div>
    </div>
  </body>
</html>