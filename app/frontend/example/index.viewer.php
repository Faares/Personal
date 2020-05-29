<?php $v->import('header') ?>
      <nav class="links">
        <?php foreach($v->links as $k => $elm):?>
          <a class="button" href="<?php echo $elm->url ?>" title="<?php echo $elm->title?>"<?php if(!empty($elm->attrs)):
              foreach ($elm->attrs as $attr_name => $attr_value):
                echo $attr_name.'="'.$attr_value.'"';
              endforeach;
            endif;
        ?>>
            <?php echo $elm->title ?></a>
        <?php endforeach; ?>
      </nav>

<?php $v->import('footer') ?>
