<?php if ($this->currencies): ?>

<select tabindex="4" id="js-currency-select">
  <option value="<?=$this->currency['code']?>" class="label"><?=$this->currency['code']?></option>
  <?php foreach ($this->currencies as $code => $item): ?>
    <?php if ($code != $this->currency['code']): ?>
      <option value="<?=$code?>">
        <?=$code?>
      </option>
    <?php endif; ?>
  <?php endforeach; ?>
</select>

<?php endif; ?>