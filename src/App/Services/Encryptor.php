<?php
/**
* Copyright © CarlosCarrinho, Inc. All rights reserved.
* See COPYING.txt for license details.
*/
namespace Cadu\App\Services;

class Encryptor
{
    public function encryptPassword($password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }
}
