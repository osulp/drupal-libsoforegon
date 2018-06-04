<?php

/**
 * Settings form for the current module.
 *
 * @param array $form
 *   Form array.
 * @param array $form_state
 *   Form_state array.
 *
 * @return array
 *   Array containing the system settings form.
 */
function drd_agent_settings($form, $form_state) {
  $form['drd_agent_debug_mode'] = array(
    '#type' => 'checkbox',
    '#title' => t('Debug mode'),
    '#default_value' => variable_get('drd_agent_debug_mode', FALSE),
  );

  return system_settings_form($form);
}

/**
 * Callback that receives all relevant parameters from a monitoring DRD instance
 * base64 and json encoded in $values. This is called by a menu callback
 * or from drush.
 *
 * Security note: if called through a http request, this should only be done
 * over https as otherwise those parameters are travelling in plain text.
 *
 * @param string $values
 * @return array
 */
function drd_agent_setup($values) {
  $values = _drd_agent_setup_decode($values);
  $authorised = variable_get('drd_agent_authorised', array());

  $values['timestamp'] = REQUEST_TIME;
  $values['ip'] = ip_address();
  $authorised[$values['uuid']] = $values;

  variable_set('drd_agent_authorised', $authorised);

  return $values;
}

/**
 * Form to authorize DRD authorization by the admin.
 *
 * @param $form
 * @param $form_state
 * @return array
 */
function drd_agent_authorize($form, $form_state) {
  if (empty($_SESSION['drd_agent_authorization_values'])) {
    $form['token'] = array(
      '#type' => 'textarea',
      '#title' => t('Authentication token'),
      '#description' => t('Paste the token for this domain from the DRD dashboard, which you want to authorize.'),
      '#default_value' => '',
      '#required' => TRUE,
    );
    $submit = t('Validate');
  }
  else {
    $form['attention'] = array(
      '#markup' => t('You are about to grant admin access to the Drupal Remote Dashboard on the following domain:'),
      '#prefix' => '<div>',
      '#suffix' => '</div>',
    );
    $form['domain'] = array(
      '#markup' => _drd_agent_get_domain($_SESSION['drd_agent_authorization_values']),
      '#prefix' => '<div class="domain">',
      '#suffix' => '</div>',
    );
    $form['cancel'] = array(
      '#type' => 'submit',
      '#value' => t('Cancel'),
    );
    $submit = t('Grant admin access');
  }
  $form['submit'] = array(
    '#type' => 'submit',
    '#value' => $submit,
  );
  $form['#attributes'] = array(
    'class' => array('drd-agent-auth'),
  );
  drupal_add_css(drupal_get_path('module', 'drd_agent') . '/drd_agent.css');

  return $form;
}

/**
 * Submit handler for the DRD authorization form which will then store the
 * values and redirect back to DRD.
 *
 * @param $form
 * @param $form_state
 */
function drd_agent_authorize_submit($form, &$form_state) {
  if (empty($_SESSION['drd_agent_authorization_values'])) {
    $_SESSION['drd_agent_authorization_values'] = $form_state['values']['token'];
  }
  else {
    if ($form_state['values']['op'] == $form['submit']['#value']) {
      $values = drd_agent_setup($_SESSION['drd_agent_authorization_values']);
      $form_state['redirect'] = $values['redirect'];
    }
    unset($_SESSION['drd_agent_authorization_values']);
  }
}

/**
 * Internal callback to decode the values for DRD authorization.
 *
 * @param string $values
 * @return array
 */
function _drd_agent_setup_decode($values) {
  $values = strtr($values, array('-' => '+', '_' => '/'));
  return json_decode(base64_decode($values), TRUE);
}

/**
 * Internal callback to extract the DRD domain from the DRD authorization values.
 *
 * @param string $values
 * @return string
 */
function _drd_agent_get_domain($values) {
  $values = _drd_agent_setup_decode($values);
  return parse_url($values['redirect'], PHP_URL_HOST);
}
