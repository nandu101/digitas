<?php

namespace Drupal\digitas\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;

/**
 * Create a one-step user details form.
 */
class DigitasUserForm extends FormBase {

    /**
     * {@inheritdoc}
     */
    public function getFormId() {
        return 'digitas_form';
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(array $form, FormStateInterface $form_state) {

        $form['first_name'] = array(
            '#type' => 'textfield',
            '#title' => t('First Name:'),
            '#required' => TRUE,
        );
        $form['last_name'] = array(
            '#type' => 'textfield',
            '#title' => t('Last Name'),
            '#required' => TRUE,
        );
        $form['email'] = array(
            '#type' => 'email',
            '#title' => t('Email ID:'),
            '#required' => TRUE,
        );
        $form['pincode'] = array(
            '#type' => 'number',
            '#title' => t('Pincode'),
            '#required' => TRUE,
        );

        $form['employee_role'] = array(
            '#type' => 'select',
            '#title' => ('Employee Role'),
            '#options' => array(
                'trainee' => t('Trainee'),
                'software engineer' => t('Sofware Engineer'),
                'senior software engineer' => t('Senior Software Engineer'),
                'manager' => t('Manager'),
            ),
        );


        $form['actions']['#type'] = 'actions';
        $form['actions']['submit'] = array(
            '#type' => 'submit',
            '#value' => $this->t('Submit'),
            '#button_type' => 'primary',
        );
        return $form;
    }

    /**
     * {@inheritdoc}
     */
    public function validateForm(array &$form, FormStateInterface $form_state) {
        
        $fname = $form_state->getValue('first_name');
        $lname = $form_state->getValue('last_name');
        $email = $form_state->getValue('email');
        $pincode = $form_state->getValue('pincode');
        $employee_role = $form_state->getValue('employee_role');
        
        if (!preg_match('/^[A-Za-z]+$/', $fname)) { 
            
            $form_state->setErrorByName('first_name', $this->t('Only characters are allowed!'));
        }
        if (!preg_match('/^[A-Za-z]+$/', $lname)) {
            $form_state->setErrorByName('last_name', $this->t('Only characters are allowed!'));
        }

        if (strlen($fname) < 3) {
            // Set an error for the form element with a key of "title".
            $form_state->setErrorByName('first_name', $this->t('The first name must be at least 3 characters long.'));
        }
        if (strlen($lname) < 3) {
            // Set an error for the form element with a key of "title".
            $form_state->setErrorByName('last_name', $this->t('The last name must be at least 3 characters long.'));
        }
        if (strlen($pincode) < 6 || strlen($pincode) > 6) {
            // Set an error for the form element with a key of "title".
            $form_state->setErrorByName('pincode', $this->t('The last name must be at least 6 number'));
        }
    }

    /**
     * {@inheritdoc}
     */
    public function submitForm(array &$form, FormStateInterface $form_state) {

        $fname = $form_state->getValue('first_name');
        $lname = $form_state->getValue('last_name');
        $email = $form_state->getValue('email');
        $pincode = $form_state->getValue('pincode');
        $employee_role = $form_state->getValue('employee_role');

        $query = \Drupal::database();
        $query->insert('digitas')
                ->fields([
                    'fname' => $fname,
                    'lname' => $lname,
                    'email' => $email,
                    'pincode' => $pincode,
                    'employee_role' => $employee_role,
                ])->execute();
        drupal_set_message($this->t("Record added successful"));
        $response = Url::fromUserInput('/thank-you');
        $form_state->setRedirectUrl($response);
    }

}
