<li>
  <a target="_blank" href="/category/<?=$category['title'];?>">
    <?=$tab . $category['title'];?>
  </a>
  <?php if (isset($category['childs'])) : ?>
    <ul>
      <?=$this->getMenuHtml($category['childs'], $tab . '--');?>
    </ul>
  <?php endif; ?>
</li>