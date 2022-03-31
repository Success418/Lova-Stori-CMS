<?php foreach($menu_items as $key => $menu_item): ?>
  <?php if(key_exists('subcategories', $menu_item)): ?>
  <a class="item" href="<?= $menu_item['slug'] ?>">
    <span><?= $menu_item['name'] ?></span>
  </a>
  <?php foreach($menu_item['subcategories'] as $child_category): ?>
  <a class="item" href="<?= $child_category['slug'] ?>">
    <span><?= $child_category['name'] ?></span>
  </a>
  <?php endforeach ?>
  
  <?php else: ?>
  <a class="item" href="<?= $menu_item['slug'] ?>">
    <span><?= $menu_item['name'] ?></span>
  </a>
  <?php endif ?>
<?php endforeach?>