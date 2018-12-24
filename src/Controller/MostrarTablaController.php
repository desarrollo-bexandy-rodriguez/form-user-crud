<?php
namespace Drupal\br_user_form_crud\Controller;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Database\Database;
use Drupal\Core\Url;
/**
 * Class MostrarTablaController.
 *
 * @package Drupal\br_user_form_crud\Controller
 */
class MostrarTablaController extends ControllerBase {

  public function content() {
    return [
      '#type' => 'markup',
      '#markup' => $this->t('Formulario de Evaluación para Bandit! (realizado por Bexandy Rodríguez)'),
    ];
  }

  public function display() {

    $header_table = array(
      'id'=>    t('No'),
      'nombre' => t('Nombre'),
      'telefono' => t('Teléfono'),
      'correo'=>t('Correo'),
      'edad' => t('Edad'),
      'genero' => t('Genero'),
      'opt' => t('operación'),
      'opt1' => t('operación'),
    );

    $query = \Drupal::database()->select('br_user_form_crud', 'm');
    $query->fields('m', ['id','nombre','telefono','correo','edad','genero','website']);
    $results = $query->execute()->fetchAll();
    $rows=array();
      foreach($results as $data){
        $delete = Url::fromUserInput('/br-user-form-crud/form/delete/'.$data->id);
        $edit   = Url::fromUserInput('/br-user-form-crud/form/datos?num='.$data->id);
        $rows[] = array(
          'id' =>$data->id,
          'nombre' => $data->nombre,
          'telefono' => $data->telefono,
          'correo' => $data->correo,
          'edad' => $data->edad,
          'genero' => $data->genero,
          \Drupal::l('Borrar', $delete),
          \Drupal::l('Editar', $edit),
        );
      }

    //display data in site
    $form['table'] = [
      '#type' => 'table',
      '#header' => $header_table,
      '#rows' => $rows,
      '#empty' => t('No se encontraron usuarios'),
    ];
    return $form;
  }
}