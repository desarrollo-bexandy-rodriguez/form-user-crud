<?php
namespace Drupal\br_user_form_crud\Form;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Database\Database;
use Symfony\Component\HttpFoundation\RedirectResponse;
/**
 * Class BRUserFormCrudForm.
 *
 * @package Drupal\br_user_form_crud\Form
 */
class BRUserFormCrudForm extends FormBase {
/**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'br_user_form_crud_form';
  }
  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $conn = Database::getConnection();
     $record = array();
    if (isset($_GET['num'])) {
        $query = $conn->select('br_user_form_crud', 'm')
            ->condition('id', $_GET['num'])
            ->fields('m');
        $record = $query->execute()->fetchAssoc();
    }
    $form['nombre_usuario'] = array(
      '#type' => 'textfield',
      '#title' => t('Nombre del Usuario:'),
      '#required' => TRUE,
       //'#default_values' => array(array('id')),
      '#default_value' => (isset($record['nombre']) && $_GET['num']) ? $record['nombre']:'',
      );
    $form['numero_telefonico'] = array(
      '#type' => 'textfield',
      '#title' => t('Número Telefónico:'),
      '#default_value' => (isset($record['telefono']) && $_GET['num']) ? $record['telefono']:'',
      );
    $form['correo_electronico'] = array(
      '#type' => 'email',
      '#title' => t('Correo Electrónico:'),
      '#required' => TRUE,
      '#default_value' => (isset($record['correo']) && $_GET['num']) ? $record['correo']:'',
      );
    $form['edad_usuario'] = array (
      '#type' => 'textfield',
      '#title' => t('EDAD'),
      '#required' => TRUE,
      '#default_value' => (isset($record['edad']) && $_GET['num']) ? $record['edad']:'',
       );
    $form['genero_usuario'] = array (
      '#type' => 'select',
      '#title' => ('Género'),
      '#options' => array(
        'femenino' => t('Femenino'),
        'masculino' => t('Masculino'),
        '#default_value' => (isset($record['genero']) && $_GET['num']) ? $record['genero']:'',
        ),
      );
    $form['submit'] = [
        '#type' => 'submit',
        '#value' => 'guardar',
        //'#value' => t('Submit'),
    ];
    return $form;
  }
  /**
    * {@inheritdoc}
    */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    $name = $form_state->getValue('nombre_usuario');
    $email = $form_state->getValue('correo_electronico');
    
    if(!preg_match("/^[a-zA-Z ]*$/",$name)) {
      $form_state->setErrorByName('nombre_usuario', $this->t('El nombre debe ser sólo letras o espacios en blanco'));
    }
    
    if (strlen($form_state->getValue('numero_telefonico')) < 10 ) {
      $form_state->setErrorByName('numero_telefonico', $this->t('Su número telefónico debe ser mayor a 10 dígitos'));
    }

    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $form_state->setErrorByName('correo_electronico', $this->t('Formato de correo electrónico incorrecto'));
    }

    if (!intval($form_state->getValue('edad_usuario'))) {
      $form_state->setErrorByName('edad_usuario', $this->t('La edad debe ser un número'));
    }

          
    parent::validateForm($form, $form_state);
  }
  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $field=$form_state->getValues();
    $name=$field['nombre_usuario'];
    $number=$field['numero_telefonico'];
    $email=$field['correo_electronico'];
    $age=$field['edad_usuario'];
    $gender=$field['genero_usuario'];
    if (isset($_GET['num'])) {
          $field  = array(
              'nombre'   => $name,
              'telefono' =>  $number,
              'correo' =>  $email,
              'edad' => $age,
              'genero' => $gender,
          );
          $query = \Drupal::database();
          $query->update('br_user_form_crud')
              ->fields($field)
              ->condition('id', $_GET['num'])
              ->execute();
          drupal_set_message("actualización realizada");
          $form_state->setRedirect('br_user_form_crud.display');
      }
       else
       {
           $field  = array(
              'nombre'   =>  $name,
              'telefono' =>  $number,
              'correo' =>  $email,
              'edad' => $age,
              'genero' => $gender,
          );
           $query = \Drupal::database();
           $query ->insert('br_user_form_crud')
               ->fields($field)
               ->execute();
           drupal_set_message("guardado correctamente");
           $response = new RedirectResponse("/br-user-form-crud");
           $response->send();
       }
     }
}