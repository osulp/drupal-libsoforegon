<?php

/**
 * Implements hook_drush_command().
 *
 * @return array
 */
function drd_agent_drush_command() {
  $items = array();

  $items['drd-agent-setup'] = array(
    'arguments' => array(
      'token' => 'Base64 and json encoded array of all variables required such that DRD can communicate with this domain in the future',
    )
  );

  return $items;
}

/**
 * Drush command to configure this domain for communcation with a DRD instance.
 *
 * @param $token
 *
 * @see drd_agent_setup()
 */
function drush_drd_agent_setup($token) {
  include_once 'drd_agent.admin.inc';
  drd_agent_setup($token);
}
