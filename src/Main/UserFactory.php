<?php
/**
* Copyright © CarlosCarrinho, Inc. All rights reserved.
* See COPYING.txt for license details.
*/
namespace Cadu\Main;

use Cadu\Models\User\User;
use Cadu\Infrastructure\MySQLAdapter;
use Cadu\Models\User\UserRepository;

class UserFactory
{
    public function create()
    {
        $mySql = new MySQLAdapter();
        $userRepo = new UserRepository($mySql);
        return new User($userRepo);
    }
}
