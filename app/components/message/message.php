<?php
  $errors = $_SESSION['errors'] ?? null;
  $success = $_SESSION['success'] ?? null;
?>

<div class="message">
  <?php if ($errors): ?>
    <div class="message__text message__text--errors"><?=$errors?></div>
  <?php endif; ?>
  <?php if ($success): ?>
    <p class="message__text message__text--success"><?=$success?></p>
  <?php endif; ?>
</div>