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

    // %20
    $message = $form_state->getValue('message');
    // $message = urlencode($message);
    $message = str_replace(' ', '%20', $message);

    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => 'http://www.smslive247.com/http/index.aspx?cmd=sendquickmsg&owneremail=sms@brilliant.ng&subacct=123&subacctpwd=123&message='.$message.'&sender=IGR&sendto='.$phone.'&msgtype=0%0A',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'GET',
    ));

    $response = curl_exec($curl);

    curl_close($curl);


    $this->messenger()->addMessage("Phone: $phone, Message: $message, Response: $response");

  }
}
