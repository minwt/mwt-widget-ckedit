<?php
/*
 Plugin Name: MWT-CKEditor for Widget
 Plugin URI: https://www.minwt.com
 Version: 1.0
 Author: minwt zhou
 Description: CKEditor Widget編輯器
 */
class mwt_CKEditor_Widget extends WP_Widget {
    function __construct() {
      parent::__construct(
        'mwt_CKEditor',
        __('CKEditor編輯器'),
        array(
            'description' => __('CKEditor編輯器')
        ),
        array(
            'width' => 600
        )
      );
    }

    public function widget($args, $instance) {
        extract($args);
        $title = apply_filters('widget_title', $instance['title']);
        $HTMLckeditor = $instance['HTMLckeditor'];
        echo $before_widget;
        echo $HTMLckeditor;
        echo $after_widget;
    }//widget

    public function form($instance) {
      $title = esc_attr($instance['title']);
      $HTMLckeditor = esc_attr($instance['HTMLckeditor']);
      ?>
      <p>
        <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('標題'); ?></label><br>
        <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>"
                 name="<?php echo $this->get_field_name('title'); ?>" type="text"
                 value="<?php echo esc_attr($title); ?>"/>
      </p>
      
      <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('輸入框'); ?></label><br>
      <textarea rows="4" cols="50" id="html_<?php echo $this->get_field_id('HTMLckeditor'); ?>" name="<?php echo $this->get_field_name('HTMLckeditor'); ?>" onClick="changeMode(this.id);" style="width:100%;"><?php echo esc_attr($HTMLckeditor); ?></textarea>

    <a href="#" id="save_<?php echo $this->get_field_id('HTMLckeditor'); ?>" onClick="save(this.id)" class="button button-primary right">儲存</a>
    
    <style type="text/css">
      .alignright>input[id *=widget-mwt_ckeditor-]{display: none;}
      .cke_combo_text{width:40px !important;}
    </style>

    <script src="<?php echo plugins_url();?>/mwt-widget_ckedit/ckeditor/ckeditor.js"></script>
    <script>
    jQuery(document).ready(function ($) {

    });
    function save(id){
       if(jQuery("#"+id.replace('save','html')).is(":hidden") == true){
        var soruceCode = CKEDITOR.instances[id.replace('save','html')].getData();
        jQuery('#'+id.replace('save','html')).val(soruceCode);
        jQuery('#'+id.replace('save_','').replace('HTMLckeditor','savewidget')).click();
       }else{
        jQuery('#'+id.replace('save_','').replace('HTMLckeditor','savewidget')).click();
        }

        return false;
    }
    function changeMode(id) {
      CKEDITOR.replace(id, {});
    }
    </script>

    <?php
    }//form

    public function update($new_instance, $old_instance) {
      $instance = $old_instance;
      $instance['title'] = strip_tags($new_instance['title']);
      $instance['HTMLckeditor'] = (!empty($new_instance['HTMLckeditor'])) ? ($new_instance['HTMLckeditor']) : '';
      
      return $instance;
    }//update
}

add_action('widgets_init', create_function('', 'return register_widget("mwt_CKEditor_Widget");'));
?>