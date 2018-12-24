<?php
namespace Drupal\br_user_form_crud\Plugin\Block;
use Drupal\Core\Block\BlockBase;
/**
 * Provides a 'BRUserFormCrudBlock' block.
 *
 * @Block(
 *  id = "br_user_form_crud_block",
 *  admin_label = @Translation("Agregar Usuarios a la BD"),
 * )
 */
class BRUserFormCrudBlock extends BlockBase {
  /**
   * {@inheritdoc}
   */
  public function build() {

    $form = \Drupal::formBuilder()->getForm('Drupal\br_user_form_crud\Form\BRUserFormCrudForm');
    return $form;
  }
}