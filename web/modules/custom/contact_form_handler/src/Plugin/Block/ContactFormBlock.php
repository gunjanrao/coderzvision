<?php

namespace Drupal\contact_form_handler\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a 'Contact Form Block' block.
 *
 * @Block(
 *   id = "contact_form_block",
 *   admin_label = @Translation("Contact Form Block"),
 *   category = @Translation("Custom")
 * )
 */
class ContactFormBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $form = \Drupal::formBuilder()->getForm('Drupal\contact_form_handler\Form\ContactForm');
    return $form;
  }
}
