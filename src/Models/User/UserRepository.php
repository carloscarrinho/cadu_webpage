<?php
/**
* Copyright © CarlosCarrinho, Inc. All rights reserved.
* See COPYING.txt for license details.
*/
namespace Cadu\Models\User;

use Cadu\Infrastructure\DAOInterface;

class UserRepository implements UserRepositoryInterface
{
    private $dao;

    public function __construct(DAOInterface $dao)
    {
        $this->dao = $dao;
    }

    /**
     * Get an user by his/her Id.
     *
     * @param  int|string $id
     * @return void
     */
    public function getById($id)
    {
        $params = [ self::PRIMARY_KEY => (int)$id ];
        $data = $this->dao->read(
            self::TABLE,
            "*",
            $params,
            1
        );
        return $data;
    }

    /**
     * Get an user by his/her E-mail.
     *
     * @param  string $email
     * @return array
     */
    public function getByEmail($email)
    {
        $data = $this->dao->read(
            self::TABLE,
            "*",
            [ self::FIELD_EMAIL => $email ],
            1
        );
        return $data;
    }

    /**
     * Get all items from an user.
     *
     * @return array
     */
    public function getAll()
    {
        return $this->dao->read(self::TABLE);
    }

    /**
     * Save an user.
     * @param UserInterface $user
     * @return void
     */
    public function save(UserInterface $user)
    {
        $data = $user->getData();
        return $this->dao->create(self::TABLE, $data);
    }

    /**
     * Delete an user by its id.
     *
     * @param  string|int $id
     * @return void
     */
    public function delete($id)
    {
        return $this->dao->delete(self::TABLE, [self::PRIMARY_KEY => $id]);
    }
}
