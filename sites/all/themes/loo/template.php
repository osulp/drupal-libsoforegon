<?php
/**
 * Implements hook_html_head_alter().
 * This will overwrite the default meta character type tag with HTML5 version.
 */
function loo_html_head_alter(&$head_elements) {
  $head_elements['system_meta_content_type']['#attributes'] = array(
    'charset' => 'utf-8'
  );
}

/**
 * HTML preprocessing
 */
function loo_preprocess_html(&$vars) {
  // Add body classes for custom design options
  $colors = theme_get_setting('color_scheme', 'loo');
  $classes = explode(" ", $colors);
  if (!theme_get_setting('backgroundimg', 'loo')){
    $vars['classes_array'][] = 'nobkimg';
  }
  for($i=0; $i<count($classes); $i++){
    $vars['classes_array'][] = $classes[$i];
  }
}

/**
 * Insert themed breadcrumb page navigation at top of the node content.
 */
function loo_breadcrumb($variables) {
  $breadcrumb = $variables['breadcrumb'];
  if (!empty($breadcrumb)) {
    // Use CSS to hide titile .element-invisible.
    $output = '<h2 class="element-invisible">' . t('You are here') . '</h2>';
    // comment below line to hide current page to breadcrumb
	$breadcrumb[] = drupal_get_title();
    $output .= '<nav class="breadcrumb">' . implode(' » ', $breadcrumb) . '</nav>';
    return $output;
  }
}

/**
 * Override or insert variables into the page template.
 */
function loo_preprocess_page(&$vars) {
  if (isset($vars['main_menu'])) {
    $vars['main_menu'] = theme('links__system_main_menu', array(
      'links' => $vars['main_menu'],
      'attributes' => array(
        'class' => array('links', 'main-menu', 'clearfix'),
      ),
      'heading' => array(
        'text' => t('Main menu'),
        'level' => 'h2',
        'class' => array('element-invisible'),
      )
    ));
  }
  else {
    $vars['main_menu'] = FALSE;
  }
  if (isset($vars['secondary_menu'])) {
    $vars['secondary_menu'] = theme('links__system_secondary_menu', array(
      'links' => $vars['secondary_menu'],
      'attributes' => array(
        'class' => array('links', 'secondary-menu', 'clearfix'),
      ),
      'heading' => array(
        'text' => t('Secondary menu'),
        'level' => 'h2',
        'class' => array('element-invisible'),
      )
    ));
  }
  else {
    $vars['secondary_menu'] = FALSE;
  }
}

/**
 * Duplicate of theme_menu_local_tasks() but adds clearfix to tabs.
 */
function loo_menu_local_tasks(&$variables) {
  $output = '';

  if (!empty($variables['primary'])) {
    $variables['primary']['#prefix'] = '<h2 class="element-invisible">' . t('Primary tabs') . '</h2>';
    $variables['primary']['#prefix'] .= '<ul class="tabs primary clearfix">';
    $variables['primary']['#suffix'] = '</ul>';
    $output .= drupal_render($variables['primary']);
  }
  if (!empty($variables['secondary'])) {
    $variables['secondary']['#prefix'] = '<h2 class="element-invisible">' . t('Secondary tabs') . '</h2>';
    $variables['secondary']['#prefix'] .= '<ul class="tabs secondary clearfix">';
    $variables['secondary']['#suffix'] = '</ul>';
    $output .= drupal_render($variables['secondary']);
  }
  return $output;
}

/**
 * Override or insert variables into the node template.
 */
function loo_preprocess_node(&$variables) {
  $node = $variables['node'];
  if ($variables['view_mode'] == 'full' && node_is_page($variables['node'])) {
    $variables['classes_array'][] = 'node-full';
  }
}

/**
 * Add css for color style.
 */
if (theme_get_setting('color_scheme', 'loo') == 'dark') {
  drupal_add_css(drupal_get_path('theme', 'loo') . '/css/color-schemes.css');
}

/**
 * Add css for background image.
 */
if (!theme_get_setting('backgroundimg', 'loo')) {
  drupal_add_css(drupal_get_path('theme', 'loo') . '/css/background.css');
}

/**
 * Add javascript files for front-page jquery slideshow.
 */
if (drupal_is_front_page()) {
  if (theme_get_setting('slideshow_display', 'loo')){
    drupal_add_js(drupal_get_path('theme', 'loo') . '/js/slides.min.jquery.js');
    drupal_add_js(drupal_get_path('theme', 'loo') . '/js/slider.js');
  }
}
