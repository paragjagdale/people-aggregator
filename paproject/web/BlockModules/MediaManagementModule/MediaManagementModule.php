<?php
/** !
* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
* [filename] is a part of PeopleAggregator.
* [description including history]
* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
* @author [creator, or "Original Author"]
* @license http://bit.ly/aVWqRV PayAsYouGo License
* @copyright Copyright (c) 2010 Broadband Mechanics
* @package PeopleAggregator
*/
?>
<?php

require_once "web/includes/classes/Pagination.php";

class MediaManagementModule extends Module {

  public $module_type = 'user|group|network';
  public $module_placement = 'middle';

  public $Paging,$PagingArray;
  public $page_links, $page_prev, $page_next, $page_count;
  public $outer_template = 'outer_public_media_management_module.tpl';
  public $type_image;
  
  function __construct() {
    parent::__construct();
    $this->title = __("Manage Post");
    $this->html_block_id = "MediaManagementModule";
  }
   function render() {
    $this->links = NULL;
    $Pagination = new Pagination;
    switch ($this->type) {
     
      case IMAGE:
        $this->links = Content::load_content_id_array ($this->uid, IMAGE);
        $this->type_image = PA::$theme_url."/images/type-image.gif";
      break;
     
     case AUDIO:
        $this->links = Content::load_content_id_array ($this->uid, AUDIO);
        $this->type_image = PA::$theme_url."/images/type-audio.gif";
      break;
      
      case VIDEO:
        $this->links = Content::load_content_id_array ($this->uid, VIDEO);
        $this->type_image = PA::$theme_url."/images/type-video.gif";
      break;

      default:
      case BLOGPOST:
        $this->links = Content::load_content_id_array ($this->uid, BLOGPOST);
        $this->type_image = PA::$theme_url."/images/type-blog.gif";
      break;
    } 

    $this->inner_HTML = $this->generate_inner_html ();
    
    $content = parent::render();
    return $content;
  }

  function generate_inner_html () {
    $links = $this->links;
    switch ( $this->mode ) {
     default:
        $tmp_file = PA::$blockmodule_path . "/MediaManagementModule/center_inner_public.tpl";
    }
    $info = new Template($tmp_file);
    $info->set_object('uid', $this->uid);
    $info->set_object('links', $links);
    $info->set_object('type_image', $this->type_image);
    $info->set('page_links', $this->page_links);
    $info->set('PagingArray', $this->PagingArray);
    $inner_html = $info->fetch();

    return $inner_html;
  }

}
?>
