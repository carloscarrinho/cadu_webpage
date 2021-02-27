<?php
/**
* Copyright © CarlosCarrinho, Inc. All rights reserved.
* See COPYING.txt for license details.
*/
namespace Cadu\Models\User;

class User implements UserInterface
{
    private $id;

    private $username;

    private $firstName;

    private $lastName;

    private $email;

    private $passwordHash;

    private $isAdmin;

    private $description;

    protected $repository;

    protected $data;

    public function __construct(UserRepositoryInterface $repository, $data = []) {
        $this->repository = $repository;
        $this->data = $data;
    }

    /**
     * @return int
     */
    public function getUserId()
    {
        return $this->id;
    }

    /**
     * @param $id
     * @return void
     */
    public function setUserId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getUserName()
    {
        return $this->username;
    }

    /**
     * @param  string $username
     * @return void
     */
    public function setUserName($username)
    {
        $this->username = $username;
    }

    /**
     * @return string
     */
    public function getUserEmail()
    {
        return $this->email;
    }

    /**
     * @param  string $email
     * @return void
     */
    public function setUserEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getUserFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param  string $firstName
     * @return void
     */
    public function setUserFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * @return string
     */
    public function getUserLastName()
    {
        return $this->lastName;
    }

    /**
     * @param  string $lastName
     * @return void
     */
    public function setUserLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    /**
     * @return string
     */
    public function getPasswordHash()
    {
        $hash = $this->passwordHash;
        return $hash;
    }

    /**
     * @param  string $password
     * @return void
     */
    public function setPasswordHash($hash)
    {
        $this->passwordHash = $hash;
    }

    /**
     * @return bool
     */
    public function isAdmin()
    {
        return $this->isAdmin;
    }

    /**
     * @param  bool $isAdmin
     * @return void
     */
    public function setIsAdmin($isAdmin)
    {
        $this->isAdmin = $isAdmin;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        $this->description;
    }

    /**
     * @param  string $description
     * @return void
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @param  array $userData
     * @return UserInterface
     */
    public function setData($userData)
    {
        $this->data = $userData;

        if(isset($userData[UserRepositoryInterface::PRIMARY_KEY])) {
            $this->setUserId($userData[UserRepositoryInterface::PRIMARY_KEY]);
        }

        $this->setUserName($userData[UserRepositoryInterface::FIELD_USERNAME]);
        $this->setUserFirstName($userData[UserRepositoryInterface::FIELD_FIRSTNAME]);
        $this->setUserLastName($userData[UserRepositoryInterface::FIELD_LASTNAME]);
        $this->setUserEmail($userData[UserRepositoryInterface::FIELD_EMAIL]);
        $this->setPasswordHash($userData[UserRepositoryInterface::FIELD_PASSWORD]);
        $this->setIsAdmin($userData[UserRepositoryInterface::FIELD_ISADMIN]);

        if(isset($userData[UserRepositoryInterface::FIELD_DESCRIPTION])) {
            $this->setDescription($userData[UserRepositoryInterface::FIELD_DESCRIPTION]);
        }

        return $this;
    }

    /**
     * Save an user.
     *
     * @return void
     */
    public function save()
    {
        $result = $this->repository->save($this);
        return $result;
    }

    /**
     * Validate required fields.
     *
     * @param  array $data
     * @return bool
     */
    public function validateRequiredFields($data)
    {
        $hasUsername = isset($data[UserRepository::FIELD_USERNAME]);
        $hasFirstName = isset($data[UserRepository::FIELD_FIRSTNAME]);
        $hasLastName = isset($data[UserRepository::FIELD_LASTNAME]);
        $hasEmail = isset($data[UserRepository::FIELD_EMAIL]);
        $hasPassword = isset($data[UserRepository::FIELD_PASSWORD]);
        $hasIsAdmin = isset($data[UserRepository::FIELD_ISADMIN]);

        if(!$hasUsername || !$hasFirstName || !$hasLastName || !$hasEmail || !$hasPassword || !$hasIsAdmin) {
            return false;
        }

        return true;
    }

    /**
     * Get all user data or some specific attribute.
     *
     * @param string $attribute
     * @return int|string|bool|array
     */
    public function getData($attribute = null)
    {
        if(!$attribute) {
            return $this->data;
        }
        $lowercase = strtolower($attribute);

        switch ($lowercase) {
            case 'username':
                return $this->getUserName();
                break;
            case 'firstname':
                return $this->getUserFirstName();
                break;

            default:
                return "Couldn't find the info.";
                break;
        }
    }

    public function getRepo()
    {
        return $this->repository;
    }
}
