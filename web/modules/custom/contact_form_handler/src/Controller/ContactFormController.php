<?php
namespace Drupal\contact_form_handler\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Database\Database;
use Symfony\Component\HttpFoundation\Response;


class ContactFormController extends ControllerBase {
  public function viewSubmissions() {
    $query = \Drupal::database()->select('contact_form_submissions', 's')
      ->fields('s', ['id', 'name', 'phone', 'email', 'address', 'time', 'date'])
      ->execute();
    
    $rows = [];
    foreach ($query as $row) {
      $rows[] = [
        'data' => [
          $row->name,
          $row->phone,
          $row->email,
          $row->address,
          $row->time,
          $row->date,
        ],
      ];
    }

    // Create a table with the form submission data
    $header = [
      $this->t('Name'),
      $this->t('Phone'),
      $this->t('Email'),
      $this->t('Address'),
      $this->t('Time'),
      $this->t('Date'),
    ];

    $build = [
      '#type' => 'table',
      '#header' => $header,
      '#rows' => $rows,
    ];

    return $build;
  }
}
