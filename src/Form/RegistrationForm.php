<?php

namespace Drupal\mannird9\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

class RegistrationForm extends FormBase {

  public function getFormId() {
    return 'registration_form';
  }
  public function buildForm(array $form, FormStateInterface $form_state, $id = NULL) {

    if ($id) {
      $reg = \Drupal::database()->query("select * from _registrations where id=$id")->fetchObject();

    }

    $form['name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Name'),
      '#required' => TRUE,
      '#default_value' => isset($reg->name) ? $reg->name : '',
    ];

    $form['phone'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Phone'),
      // '#required' => TRUE,
      '#default_value' => isset($reg->phone) ? $reg->phone : '',
      '#maxlength' => 11,
    ];

    $form['gender'] = [
      '#type' => 'select',
      '#title' => $this->t('Gender'),
      '#options' => ['Male' => 'Male', 'Female' => 'Female'],
      '#default_value' => isset($reg->gender) ? $reg->gender : '',

    ];

    $form['age'] = [
      '#type' => 'number',
      '#title' => $this->t('Age'),
      '#default_value' => isset($reg->age) ? $reg->age : '',

      // '#required' => TRUE,
    ];

    if ($id) {
      $form['_id'] = array(
        '#type' => 'hidden',
        '#value' => ($id) ? $id : '',
      );
    }



    // Group submit handlers in an actions element with a key of "actions" so
    // that it gets styled correctly, and so that other modules may add actions
    // to the form. This is not required, but is convention.
    $form['actions'] = [
      '#type' => 'actions',
    ];

    // Add a submit button that handles the submission of the form.
    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => ($id) ? $this->t('Update') : $this->t('Save'),
    ];

    return $form;
  }



  public function validateForm(array &$form, FormStateInterface $form_state) {
    $title = $form_state->getValue('title');
    if (strlen($title) < 5) {
      // Set an error for the form element with a key of "title".
      //$form_state->setErrorByName('title', $this->t('The title must be at least 5 characters long.'));
    }
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {

    $_id = $form_state->getValue('_id');
    $name = strtoupper($form_state->getValue('name'));
    $phone = $form_state->getValue('phone');
    $gender = $form_state->getValue('gender');
    $age =  $form_state->getValue('age');

    $fields = [
      'name' => $name,
      'phone' => $phone,
      'gender' => $gender,
      'age' => $age,
    ];

    if (isset($_id)) {
       \Drupal::database()->update('_registrations')->fields($fields)->condition('id', $_id)->execute();
       $db_id = $_id;
      $this->messenger()->addMessage("Record Updated with Database Id: $_id");

    }
    else {


      $db_id = \Drupal::database()->insert('_registrations')->fields($fields)->execute();

      $this->messenger()->addMessage("Record Added with Database Id: $db_id");
    }


    $form_state->setRedirect('mannird9.registration_view', ['id' => $db_id]);




    // print('<pre>' . print_r($fields, TRUE) . '</pre>'); exit();


  }

}
