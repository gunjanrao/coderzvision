<?php

namespace Drupal\contact_form_handler\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

class ContactForm extends FormBase {

  public function getFormId() {
    return 'contact_form';
  }

  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Your full name'),
      '#required' => TRUE,
    ];

    $form['phone'] = [
      '#type' => 'tel',
      '#title' => $this->t('Phone number'),
      '#required' => TRUE,
      '#pattern' => '\d{10}',
      '#description' => $this->t('Please enter a valid 10-digit phone number.'),
    ];

    $form['email'] = [
      '#type' => 'email',
      '#title' => $this->t('Enter email address'),
      '#required' => TRUE,
    ];

    $form['address'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Address location'),
      '#required' => TRUE,
    ];

    $form['time'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Select time'),
      '#required' => TRUE,
    ];

    $form['date'] = [
      '#type' => 'date',
      '#title' => $this->t('Date'),
      '#required' => TRUE,
    ];

    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Send Request'),
    ];

    return $form;
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {
    $name = $form_state->getValue('name');
    $email = $form_state->getValue('email');
    $phone = $form_state->getValue('phone');
    $address = $form_state->getValue('address');
    $time = $form_state->getValue('time');
    $date = $form_state->getValue('date');

    $connection = \Drupal::database();
    $connection->insert('contact_form_submissions')
      ->fields([
        'name' => $name,
        'email' => $email,
        'phone' => $phone,
        'address' => $address,
        'time' => $time,
        'date' => $date,
        'created' => \Drupal::time()->getRequestTime(),
      ])
      ->execute();

    $this->messenger()->addMessage($this->t('Thank you for contacting us! Your request has been submitted.'));
  }

  public function validateForm(array &$form, FormStateInterface $form_state) {
    $name = $form_state->getValue('name');
    if (empty($name)) {
      $form_state->setErrorByName('name', $this->t('Name is required.'));
    }

    $phone = $form_state->getValue('phone');
    if (!preg_match('/^\d{10}$/', $phone)) {
      $form_state->setErrorByName('phone', $this->t('Please enter a valid 10-digit phone number.'));
    }

    $email = $form_state->getValue('email');
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $form_state->setErrorByName('email', $this->t('Please enter a valid email address.'));
    }

    $address = $form_state->getValue('address');
    if (empty($address)) {
      $form_state->setErrorByName('address', $this->t('Address location is required.'));
    }

    $time = $form_state->getValue('time');
    if (empty($time)) {
      $form_state->setErrorByName('time', $this->t('Select time is required.'));
    }

    $date = $form_state->getValue('date');
    if (empty($date)) {
      $form_state->setErrorByName('date', $this->t('Date is required.'));
    }
  }
}
