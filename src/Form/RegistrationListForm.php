<?php

namespace Drupal\mannird9\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Link;
use Drupal\Core\Url;
class RegistrationListForm extends FormBase {

  public function buildForm(array $form, FormStateInterface $form_state) {

    $header = [
      'id' => $this->t('S/N'),
      'name' => $this->t('Name'),
      'phone' => $this->t('Phone'),
      'gender' => $this->t('Gender'),
      'age' => $this->t('Age'),
      'view' => $this->t('View'),
      'pdf' => $this->t('PDF'),
      'edit' => $this->t('Edit'),
    ];

    $query = \Drupal::database()->select('_registrations', 'tb');
    $query->fields('tb');

    // if (isset($_SESSION['search_word']) && $_SESSION['search_by'] != '-Search By-') {
    //   $query->condition($_SESSION['search_by'], '%'.$_SESSION['search_word'].'%', 'LIKE');
    // }

    $query = $query->extend('Drupal\Core\Database\Query\PagerSelectExtender')->limit(10);
    $query->orderBy('id', 'DESC');
    $results = $query->execute();

    $rows = [];
    foreach ($results as $row) {

      $view_link = Link::fromTextAndUrl('View', new Url('mannird9.registration_view', ['id' => $row->id], ['attributes' => ['class' => ['btn btn-block btn-success btn-sm']]]));
      $pdf_link = Link::fromTextAndUrl('PDF', new Url('mannird9.registration_pdf', ['id' => $row->id], ['attributes' => ['class' => ['btn btn-block btn-success btn-sm']]]));
      $edit_link = Link::fromTextAndUrl('Edit', new Url('mannird9.registration_edit', ['id' => $row->id], ['attributes' => ['class' => ['btn btn-block btn-primary btn-sm']]]));

      $rows[] = [
        'id' => $row->id,
        'name' => $row->name,
        'phone' => $row->phone,
        'gender' => $row->gender,
        'age' => $row->age,
        'view' => $view_link,
        'pdf' => $pdf_link,
        'edit' => $edit_link,

      ];
    }

    $form['table'] = [
      '#type' => 'table',
      '#header' => $header,
      '#rows' => $rows,
      '#empty' => t('No records found'),
      '#attributes'=> ['class' => ['table table-sm table-bordered'], 'style' =>[ "font-size:14px;"]],
    ];
    $form['pager'] = ['#type' => 'pager'];

    return $form;
  }

  public function getFormId() {
    return 'registration_list_form';
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
