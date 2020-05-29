<?php $v->import('header') ?>
<div class="works-box">
  <h2 style="margin-bottom:-6px">Works</h2>
  <div style="border:1px solid #FFF;width:max-content;padding:0px 20px 19.405px 20px;margin:0px auto;">
  <?php foreach($v->works as $key => $v1):?>
      <h5><?=$key?></h5>

      <nav class="links" style="margin-top:0px;">
        <?php foreach($v1 as $key =>$val): ?>
        <a target="_blank" class="button" href="<?php echo $val['url'] ?>" title="<?php echo $val['name'].' - '.$val['des']?>"><?php echo $val['name'] ?></a>
        <?php endforeach ?>
      </nav>

  <?php endforeach;?>
  </div>
  <a style="margin-top:20px;" class="button" href="<?=SITE_URL?>" title="Home">Back to Home.</a>
</div>
<?php $v->import('footer') ?>
