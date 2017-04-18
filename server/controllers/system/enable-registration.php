<?php
use Respect\Validation\Validator as DataValidator;

/**
 * @api {post} /system/enable-registration Enable the registration.
 *
 * @apiName Enable registration 
 *
 * @apiGroup system
 *
 * @apiDescription This path enable the registration.
 *
 * @apiPermission Staff level 3
 *
 * @apiParam {string} password The password of the current staff.
 *
 * @apiError {String} message
 *
 * @apiSuccess {Object} data
 *
 */

class EnableRegistrationController extends Controller {
    const PATH = '/enable-registration';
    const METHOD = 'POST';

    public function validations() {
        return [
            'permission' => 'staff_3',
            'requestData' => []
        ];
    }

    public function handler() {
        $password = Controller::request('password');

        if(!Hashing::verifyPassword($password,Controller::getLoggedUser()->password)) {
            Response::respondError(ERRORS::INVALID_PASSWORD);
            return;
        }

        $registrationRow = Setting::getSetting('registration');

        $registrationRow->value = true;
        $registrationRow->store();

        Response::respondSuccess();
    }
}