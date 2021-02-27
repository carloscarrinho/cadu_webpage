<?php
/**
* Copyright © CarlosCarrinho, Inc. All rights reserved.
* See COPYING.txt for license details.
*/
namespace Cadu\Models\User;

interface UserInterface
{
    /**
     * @return int
     */
    public function getUserId();

    /**
     * @param $id
     * @return void
     */
    public function setUserId($id);

    /**
     * @return string
     */
    public function getUserName();

    /**
     * @param  string $username
     * @return void
     */
    public function setUserName($username);

    /**
     * @return string
     */
    public function getUserEmail();

    /**
     * @param  string $email
     * @return void
     */
    public function setUserEmail($email);

    /**
     * @return string
     */
    public function getUserFirstName();

    /**
     * @param  string $firstName
     * @return void
     */
    public function setUserFirstName($firstName);

    /**
     * @return string
     */
    public function getUserLastName();

    /**
     * @param  string $lastName
     * @return void
     */
    public function setUserLastName($lastName);

    /**
     * @return string
     */
    public function getPasswordHash();

    /**
     * @param  string $hash
     * @return void
     */
    public function setPasswordHash($hash);

    /**
     * @return bool
     */
    public function isAdmin();

    /**
     * @param  bool $isAdmin
     * @return void
     */
    public function setIsAdmin($isAdmin);

    /**
     * @return string
     */
    public function getDescription();

    /**
     * @param  string $description
     * @return void
     */
    public function setDescription($description);
}
