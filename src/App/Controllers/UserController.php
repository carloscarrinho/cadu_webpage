<?php
/**
* Copyright © CarlosCarrinho, Inc. All rights reserved.
* See COPYING.txt for license details.
*/
namespace Cadu\App\Controllers;

use Cadu\App\Services\Encryptor;
use Cadu\Main\UserFactory;
use Cadu\Models\User\UserRepository;
use Exception;

class UserController implements ControllerInterface
{
    private $user;

    private $encryptor;

    public function __construct()
    {
        $this->user = new UserFactory();
        $this->encryptor = new Encryptor();
    }

    public function execute()
    {
        # code...
    }

    public function login($credentials)
    {
        $user = $this->user->create();

        $data = $user->getRepo()->getByEmail($credentials[$user->getRepo()::FIELD_EMAIL]);
        if(!$data) return false;

        $user = $user->setData($data[0]);
        $authenticated = $this->auth->authenticate($user, $credentials);

        return $authenticated;
    }

    public function addUser($data)
    {
        $newUser = $this->user->create();
        $isValid = $newUser->validateRequiredFields($data);
        if(!$isValid) throw new Exception("Error Processing Request", 1);

        $data[UserRepository::FIELD_PASSWORD] = $this->encryptor->encryptPassword(
            $data[UserRepository::FIELD_PASSWORD]
        );

        $newUser->setData($data);
        $result = $newUser->save();

        $result = $result === 1 ? "User saved successfully" : $result;
        return $result;
    }
}
