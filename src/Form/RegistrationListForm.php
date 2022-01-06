<?php

namespace Drupal\mannird9\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

class RegistrationListForm extends FormBase {

  public function buildForm(array $form, FormStateInterface $form_state) {

    $form['table1'] = [
      '#type' => 'table',
      '#header' => [$this->t('SN'), $this->t('Name'), $this->t('Gender')],
      '#rows' => [
        ['1', '2', '3'],
        ['4', '5', '6'],
        ['7', '8', '9'],
      ],
    ];


$header = [
  'color' => $this
    ->t('Color'),
  'shape' => $this
    ->t('Shape'),
];
$options = [
  1 => [
    'color' => 'Red',
    'shape' => 'Triangle',
  ],
  2 => [
    'color' => 'Green',
    'shape' => 'Square',
  ],
  3 => [
    'color' => 'Blue',
    'shape' => 'Hexagon',
  ],
];
$form['table2'] = array(
  '#type' => 'tableselect',
  '#header' => $header,
  '#options' => $options,
  '#empty' => $this
    ->t('No shapes found'),
);


$form['contacts'] = array(
  '#type' => 'table',
  '#caption' => $this
    ->t('Sample Table'),
  '#header' => array(
    $this
      ->t('Name'),
    $this
      ->t('Phone'),
  ),
);
for ($i = 1; $i <= 4; $i++) {
  $form['contacts'][$i]['#attributes'] = array(
    'class' => array(
      'foo',
      'baz',
    ),
  );
  $form['contacts'][$i]['name'] = array(
    '#type' => 'textfield',
    '#title' => $this
      ->t('Name'),
    '#title_display' => 'invisible',
  );
  $form['contacts'][$i]['phone'] = array(
    '#type' => 'tel',
    '#title' => $this
      ->t('Phone'),
    '#title_display' => 'invisible',
  );
}
$form['contacts'][]['colspan_example'] = array(
  '#plain_text' => 'Colspan Example',
  '#wrapper_attributes' => array(
    'colspan' => 2,
    'class' => array(
      'foo',
      'bar',
    ),
  ),
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
