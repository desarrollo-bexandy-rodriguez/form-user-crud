<?php
namespace Drupal\br_user_form_crud\Form;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Form\ConfirmFormBase;
use Drupal\Core\Url;
use Drupal\Core\Render\Element;
/**
 * Class DeleteForm.
 *
 * @package Drupal\br_user_form_crud\Form
 */
class DeleteForm extends ConfirmFormBase {
/**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'br_delete_form';
  }
  public $cid;
  public function getQuestion() { 
    return t('¿Quiere borrar este usuario %cid?', array('%cid' => $this->cid));
  }
 public function getCancelUrl() {
    return new Url('br_user_form_crud.display');
}
public function getDescription() {
    return t('¡Hágalo sólo si está seguro!');
  }
  /**
   * {@inheritdoc}
   */
  public function getConfirmText() {
    return t('¡Borrarlo!');
  }
  /**
   * {@inheritdoc}
   */
  public function getCancelText() {
    return t('Cancelar');
  }
  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state, $cid = NULL) {
     $this->id = $cid;
    return parent::buildForm($form, $form_state);
  }
  /**
    * {@inheritdoc}
    */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    parent::validateForm($form, $form_state);
  }
  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
       $query = \Drupal::database();
       $query->delete('br_user_form_crud')
                   ->condition('id',$this->id)
                  ->execute();
             drupal_set_message("eliminación satisfactoria");
            $form_state->setRedirect('br_user_form_crud.display');
  }
}