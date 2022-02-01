<?php

namespace Drupal\mannird9\Form;

use Drupal\Core\Database\Driver\mysql\Connection;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class SMSForm extends FormBase {

  protected $database;
  protected $session;

  public function __construct(Connection $database, SessionInterface $session) {
    $this->database = $database;
    $this->session = $session;
  }

  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('database'),
      $container->get('session')
    );
  }

  public function getFormId() {
    return 'sms_form';
  }


  public function buildForm(array $form, FormStateInterface $form_state) {

    $query = "SELECT phone, email, pass, `name` FROM _agents LIMIT 2";
    $result = $this->database->query($query)->fetchAll();
    foreach($result as $agent) {
      $message = "KAZAURE IGR PLATFORM: - Hi, $agent->name , Your Username is $agent->email and Password is $agent->pass";
      $status = sendsms($agent->phone, $message);
      $this->messenger()->addMessage($message);
      $this->messenger()->addMessage($status);
    }
    // print('<pre>' . print_r($result, TRUE) . '</pre>'); exit();

    $form['phone'] = [
      '#type' => 'tel',
      '#title' => $this->t('Phone number'),
      '#maxlength' => 11,
    ];

    $form['message'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Message'),
    ];

    $form['actions'] = [
      '#type' => 'actions',
    ];

    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => ($id) ? $this->t('Update') : $this->t('Send'),
    ];

    return $form;
    }

  public function submitForm(array &$form, FormStateInterface $form_state) {
    $phone = $form_state->getValue('phone');
    $phone = '234' . substr($phone, 1);

    sendsms($phone, $form_state->getValue('message'));


    $this->messenger()->addMessage("Phone: $phone, Message: $message, Response: $response");

  }
}
