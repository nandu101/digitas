<?php

/**
 * @file
 * Contains \Drupal\digitas\Controller\TestAPIController.
 */

namespace Drupal\digitas\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Controller routines for digitas_api routes.
 */

class RestApiController extends ControllerBase {

    /**
     * Callback for `my-api/get.json` API method.
     */
    public function get_data(Request $request) {
        
        $query = \Drupal::database()->select('digitas', 'd');
        $query->fields('d', ['id', 'fname', 'lname', 'email', 'pincode', 'employee_role']);
        $results = $query->execute()->fetchAll();
        $rows = array();
        foreach ($results as $data) {
            //get data
            $rows[] = array(
                'id' => $data->id,
                'first_name' => $data->fname,
                'last_name' => $data->lname,
                'email' => $data->email,
                'pincode' => $data->pincode,
                'employee_role' => $data->employee_role,
            );
        }
        return new JsonResponse($rows);
    }

}
?>