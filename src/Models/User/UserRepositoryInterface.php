<?php
/**
* Copyright © CarlosCarrinho, Inc. All rights reserved.
* See COPYING.txt for license details.
*/
namespace Cadu\Models\User;

interface UserRepositoryInterface
{
    const TABLE = 'tb_users';

    const PRIMARY_KEY = 'n_id_user';

    const FIELD_USERNAME = 'c_username_user';

    const FIELD_FIRSTNAME = "c_firstname_user";

    const FIELD_LASTNAME = "c_lastname_user";

    const FIELD_EMAIL = "c_email_user";

    const FIELD_PASSWORD = "c_passwd_user";

    const FIELD_ISADMIN = "n_isadmin_user";

    const FIELD_DESCRIPTION = "c_desc_user";

    /**
     * Get an user by his/her Id.
     *
     * @param  int|string $id
     * @return void
     */
    public function getById($id);

    /**
     * Get an user by his/her E-mail.
     *
     * @param  string $email
     * @return array
     */
    public function getByEmail($email);

    /**
     * Get all items from an user.
     *
     * @return array
     */
    public function getAll();

    /**
     * Save an user.
     * @param UserInterface $user
     * @return void
     */
    public function save(UserInterface $user);

    /**
     * Delete an user.
     *
     * @param int|string $id
     * @return void
     */
    public function delete($id);
}
