<?php
/**
* Copyright © CarlosCarrinho, Inc. All rights reserved.
* See COPYING.txt for license details.
*/
namespace Cadu\Infrastructure;

interface DAOInterface
{
    public function create($table, $data);

    public function read($table, $columns = '*', $params = null, $limit = null);

    public function update($table, $param, $data);

    public function delete($table, $param);
}
