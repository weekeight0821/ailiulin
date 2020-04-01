<?php
namespace app\admin\model;

use think\Model;

class User extends Model
{
    public function getList($query, $pagenum, $pagesize)
    {
        $count = $this->count();
        $pageCount = ceil($count / $pagesize);

        $offset = ($pagenum - 1) * $pagesize;

        if ($offset >= $count) {
            $count = $offset;
        }

        $limit = $pagesize;

        

    }
}