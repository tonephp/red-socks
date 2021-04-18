<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="author" content="Your Name">
  <?=$this::getMeta(); ?>
  <link rel="icon" type="image/png" href="/favicon.png" />
  <link href="/dist/styles.css" rel="stylesheet">
</head>
<body>

  <div class="layout">
    <div class="layout__header">
      <?=$this->component('header')?>
    </div>
    <div class="layout__content">
      <?=$this->component('message')?>
      <?=$content?>
    </div>
    <div class="layout__footer">
      <?=$this->component('footer')?>
    </div>
  </div>
  
  <script>
    var serverUrl = "<?=siteUrl()?>";
  </script>
  <script src="/dist/app.js"></script>
  <?=$scripts?>
</body>
</html>
