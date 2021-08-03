<?php

namespace Drupal\digitas\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Class DisplayDataController
 * @package Drupal\digitas\Controller
 */
class DisplayDataController extends ControllerBase {

    public function display() {
        //create table header
        $header_table = array(
            'id' => t('ID'),
            'first_name' => t('First Name'),
            'last_name' => t('Last Name'),
            'email' => t('Email'),
            'pincode' => t('Pincode'),
            'employee_role' => t('Employee Role'),
        );


        // get data from database
        $query = \Drupal::database()->select('digitas', 'd');
        $query->fields('d', ['id', 'fname', 'lname', 'email', 'pincode', 'employee_role']);
        $pager = $query->extend('Drupal\Core\Database\Query\PagerSelectExtender')->limit(5);
        $results = $pager->execute()->fetchAll();
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
        // render table
        $render['table'] = [
            '#type' => 'table',
            '#header' => $header_table,
            '#rows' => $rows,
            '#empty' => t('No data found'),
        ];
        $render['pager'] = [
            '#type' => 'pager'
        ];

        return $render;
    }

}
