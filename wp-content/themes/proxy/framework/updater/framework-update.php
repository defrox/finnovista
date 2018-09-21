<?php
function stag_framework_update(){
  $source = new STAG_Framework_Updater;
  echo '<div class="wrap">
    <div id="icon-link-manager" class="icon32"></div>
    <h2>'.__('CodeStag Framework Update', 'stag').'</h2>';
  if($source->has_update()){ ?>
    <form method="post" id="stag-update">
      <h3>A new version of CodeStag Framework is available.</h3>
      <p>This updater will download and extract the latest CodeStag Framework files to your current theme's functions folder.</p>
      <p>Only the CodeStag Framework files will be updated with this functionality, so we recommend backing up your theme or modified files before updating.</p>
      <p><strong>&rarr; Current Version:</strong> <?php echo $source->get_framework_version(); ?></p>
      <p><strong>&rarr; New Version:</strong> <?php echo $source->get_remote_version(); ?></p>
      <input type="hidden" name="stag-do-update" value="update" />
      <input type="submit" value="Update CodeStag Framework" class="button" />
    </form>
    <div id="changelog-wrap">
      <?php echo $source->get_changelog(); ?>
    </div>
  <?php
  }else{
    echo '<p><strong>&rarr; You are using the latest CodeStag Framework Version:</strong> '.$source->get_framework_version().'</p>';
    echo $source->get_changelog();
  }
  echo '</div>';
}