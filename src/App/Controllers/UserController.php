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

    /**
     * Create an user on database.
     *
     * @param  mixed $data
     * @return void
     */
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

    public function getUser($id)
    {
        $repository = $this->user->create()->getRepo();
        $user = $repository->getById($id)[0];

        if(!$user) {
            throw new Exception("User not found");
        }

        unset($user['c_passwd_user']);
        return $user;
    }
}
