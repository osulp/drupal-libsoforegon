<?php

/**
 * @file
 * Default simple view template to all the fields as a row.
 *
 * - $view: The view in use.
 * - $fields: an array of $field objects. Each one contains:
 *   - $field->content: The output of the field.
 *   - $field->raw: The raw data for the field, if it exists. This is NOT output safe.
 *   - $field->class: The safe class id to use.
 *   - $field->handler: The Views field handler object controlling this field. Do not use
 *     var_export to dump this object, as it can't handle the recursion.
 *   - $field->inline: Whether or not the field should be inline.
 *   - $field->inline_html: either div or span based on the above flag.
 *   - $field->wrapper_prefix: A complete wrapper containing the inline_html to use.
 *   - $field->wrapper_suffix: The closing tag for the wrapper.
 *   - $field->separator: an optional separator that may appear before a field.
 *   - $field->label: The wrap label text to use.
 *   - $field->label_html: The full HTML of the label to use including
 *     configured element type.
 * - $row: The raw result object from the query, with all data it fetched.
 *
 * @ingroup views_templates
 */

$map_address = $fields['address1']->content;
if (!empty($fields['address2'])) {
  $map_address .= $fields['address2']->content;
}
$map_address .= $fields['city']->content . ', ' . $fields['state']->content . ', '
  . $fields['zip']->content;
$map_address = str_replace(' ', '+', $map_address);

?>
<h4><?php print $fields['library_name']->content; ?></h4>
<?php if(!empty($fields['branch_name'])) { ?>
<strong><?php print $fields['branch_name']->content; ?></strong>
<?php } ?>
<p>
  <?php print $fields['address1']->content; ?><br>
  <?php if (!empty($fields['address2'])) { ?>
  <?php print $fields['address2']->content; ?><br>
  <?php } ?>
  <?php print $fields['city']->content . ', ' . $fields['state']->content . ', '
    . $fields['zip']->content; ?> &nbsp;&nbsp;<a
    href="https://www.google.com/maps/search/<?php print $map_address; ?>"
    target="_blank">Map It</a><br>
  <?php if (!empty($fields['phone'])) { ?>
    <?php print $fields['phone']->content; ?><br>
  <?php } ?>
  <?php if (!empty($fields['website'])) { ?>
    <a href="<?php print $fields['website']->content; ?>" target="_blank"><?php print $fields['website']->content; ?></a><br>
  <?php } ?>
  <?php if (!empty($fields['email'])) { ?>
    <a href="mailto:<?php print $fields['email']->content; ?>"><?php print $fields['email']->content; ?></a><br>
  <?php } ?>
</p>
<br />