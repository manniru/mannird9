<?php

namespace Drupal\mannird9\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

class Form1Form extends FormBase {

  public function buildForm(array $form, FormStateInterface $form_state) {

    $form['name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Name'),
      '#required' => TRUE,
    ];

    $form['gender'] = [
      '#type' => 'select',
      '#title' => $this
        ->t('Select gender'),
      '#options' => ['Male' => 'Male', 'Female' => 'Female']
    ];


    $form['copy'] = array(
      '#type' => 'checkbox',
      '#title' => $this
        ->t('Send me a copy'),
    );

    $form['high_school']['tests_taken'] = array(
      '#type' => 'checkboxes',
      '#options' => array('SAT' => $this->t('SAT'), 'ACT' => $this->t('ACT')),
      '#title' => $this->t('What standardized tests did you take?'),
    );

    $form['expiration'] = [
      '#type' => 'date',
      '#title' => $this
        ->t('Content expiration'),
      '#default_value' => '2020-02-05',
    ];

    $form['expiration'] = [
      '#type' => 'datetime',
      '#title' => $this
        ->t('Content expiration'),
      '#default_value' => '2020-02-05',
    ];


    // Group submit handlers in an actions element with a key of "actions" so
    // that it gets styled correctly, and so that other modules may add actions
    // to the form. This is not required, but is convention.
    $form['actions'] = [
      '#type' => 'actions',
    ];

    // Add a submit button that handles the submission of the form.
    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Submit'),
    ];


    $form['actions']['preview'] = array(
      '#type' => 'button',
      '#value' => $this
        ->t('Preview'),
    );

    return $form;
  }

  public function getFormId() {
    return 'form1_form';
  }

  public function validateForm(array &$form, FormStateInterface $form_state) {
    $title = $form_state->getValue('title');
    if (strlen($title) < 5) {
      // Set an error for the form element with a key of "title".
      //$form_state->setErrorByName('title', $this->t('The title must be at least 5 characters long.'));
    }
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {

    $title = $form_state->getValue('title');
    $this->messenger()->addMessage($this->t('You specified a title of %title.', ['%title' => $title]));
  }

}
