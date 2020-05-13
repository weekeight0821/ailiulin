<?php
namespace app\common\model;

use think\Model;

class BaseModel extends Model
{   
    protected $resultSetType = 'collection';
    /**
     * 插入一条数据
     */
    public function insert($data) {
        $result = $this->insert($data);

        if ($result === false) {
            return false;
        } else {
            return $result;
        }
    }

    /**
     * 插入多条数据
     */
    public function insert_batch($data) {
        $result = $this->insertAll($data);

        if ($result === false) {
            return false;
        } else {
            return $result;
        }
    }

    public function update_by_condition($condition, $new_data) {
        if (empty($condition)) {
            return;
        }
        $this->build_where($condition);
        $result = $this->update($new_data);
        
        if(!$result) {
            return false;
        } else {
            return $result;
        }
    }

    public function update_by_id($id, $new_data) {
        if ($id !== false) {
            return $this->update_by_condition(array($this->pk => $id), $new_data);
        } else {
            return false;
        }
    }

    public function del_by_condition($condition) {
        if (!empty($condition)) {
            $this->build_where($condition);
            $result = $this->delete();
            if (!$result) {
                return false;
            } else {
                return $result;
            }
        }
        return false;
    }

    public function del_by_id($id) {
        return $this->del_by_condition(array($this->pk => $id));
    }
    /**
     * 查询多条数据
     */
    public function query($condition, $fields = false, $orders = array(), $pages = false) {
        if($fields != false) {
            $this->field($fields);
        }
        $this->build_where();
        $this->build_orders();
        if ($pages != false) {
            $this->build_limit($pages);
        }

        $result = $this->select();
        if ($result === false) {
            return false;
        } else {
            return $result->toArray();
        }
    }
    /**
     * 查询单条记录
     */
    public function query_one($condition, $fields = false) {
        if ($fields != false) {
            $this->field($fields);
        }
        $this->build_where($condition);
        $result = $this->find();
        if ($result === false) {
            return false;
        } else {
            return $result->toArray();
        }

    }
    /**
     * 获取某个字段排序方式的一条
     */
    public function query_order_one($condition, $fields = false, $order = false) {
        if ($fields != false) {
            $this->_db->select($fields);
        }
        $this->build_where($condition);
        if (!empty($orders)) {
            $this->build_order($orders);
        }

        $result = $this->find();
        if ($result === false) {
            return false;
        } else {
            return $result->toArray();
        }
    }

    /**
     * 根据主键查询
     */
    public function query_by_id($id) {
        return $this->query_one(array($this->pk => $id));
    }

    /**
     * 根据条件获取对应的记录数量
     */
    public function query_count($condition) {
        $this->build_where($condition);
        return $this->count();
    }
    /**
     * 是否存在
     */
    public function is_exist($condition) {
        $this->field('id');
        $this->build_where($condition);
        return $this->select() > 0;
    }

    public function build_where($conds = array()) {
        if (empty($conds)) {
            return;   
        }
        
        foreach ($conds as $key => $value) {
            if (is_array($value)) {
                $this->whereIN($key, $value);
            } else {
                $this->where($key, $value);
            }
        }
    }
    
    /**
     * $orders = [['id' => 'desc'],['name] => 'desc'];
     */
    public function build_order($orders = array()) {
        if (empty($orders)) {
            return;
        }
        
        $this->order($orders);
    }

    /**
     * $pages['pn']:第几页
     * $pages['rn']:每页多少
     */
    public function build_limit($pages = array()) {
        if (empty($pages)) {
            return;
        }

        $this->page($pages['pn'], $pages['rn']);
    }
}