<?php
  error_reporting(E_ALL);
   
  require_once(PA::$blockmodule_path.'/EditProfileModule/DynamicProfile.php');
  $dynProf = new DynamicProfile($user_info);

  function isActiveNav($section, $type) {
    echo ($section == $type) ? ' class="active"' : NULL;
  }


?>

<? if ($type == 'basic') { ?>
    <div id="basic-info">
      <?php require "basic_info.tpl" ?>
    </div>
<? } ?>
<? if ($type == 'general') { ?>
    <div id="general-info">
      <?php echo $dynProf->render_section("general"); ?>
    </div>
<? } ?>
<? if ($type == 'personal') { ?>
    <div id="personal-info">
      <?php echo $dynProf->render_section("personal"); ?>
    </div>
<? } ?>
<? if ($type == 'professional') { ?>
    <div id="professional-info">
      <?php echo $dynProf->render_section("professional"); ?>
    </div>
<? } ?>
<? if ($type == 'blogs_rss') {
    $dynProf->blogrss_setting_status = $blogsetting_status; ?>
    <div id="blogs_rss-info">
      <?php echo $dynProf->render_section("blogs_rss"); ?>
    </div>
<? } ?>
<? if ($type == 'notifications') { ?>
    <div id="notifications-info">
      <?php echo $dynProf->render_section("notifications"); ?>
    </div>
<? } ?>
<? if ($type == 'export') { ?>
    <div id="export-info">
      <?php  require "export.tpl" ?>
    </div>
<? } ?>

<? if ($type == 'delete_account') { ?>
    <div id="delete_account-info">
      <?php  require "delete_account.tpl" ?>
    </div>
<? } ?>
