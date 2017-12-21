<?php
/**
 * @file
 * The primary PHP file for this theme.
 */

// For Industry pages add the large image and TID.
// function THEME_preprocess_panels_pane(&$vars) {
//     if ($node_bundle == 'industry_landing_page') {
//       // If the Large Image is set add its full path for the wrapper class.
//       if ($node->__isset('field_large_image')
//         and $background = $node->field_large_image->value()) {
//         $vars['industry_image'] = file_create_url($background['uri']);
//       }
//     }
//   }