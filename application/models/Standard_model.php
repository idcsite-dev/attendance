<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Standard_model extends CI_Model
{

    public function getLastestData($source, $orderField, $orderValue)
    {
        $this->db->order_by($orderField, $orderValue);
        $this->db->limit(1);
        return $this->db->get($source)->result_array();
    }

    public function getLastestDataWithCondition($source, $condition, $conditionValue, $orderField, $orderValue)
    {
        $this->db->where($condition, $conditionValue);
        $this->db->order_by($orderField, $orderValue);
        $this->db->limit(1);
        return $this->db->get($source)->result_array();
    }

    public function readData($source)
    {
        $result = $this->db->get($source);
        return $result->result_array();
    }

    public function readDataDelDate($source)
    {
        $this->db->where('tgl_hapus', '1970-01-01 00:00:00');
        $result = $this->db->get($source);
        return $result->result_array();
    }

    public function readDataOrder($source, $field, $orderValue)
    {
        $this->db->order_by($field, $orderValue);
        $result = $this->db->get($source);
        return $result->result_array();
    }

    public function readDataOrderDelDate($source, $field, $orderValue)
    {
        $this->db->where('tgl_hapus', '1970-01-01 00:00:00');
        $this->db->order_by($field, $orderValue);
        $result = $this->db->get($source);
        return $result->result_array();
    }

    public function readSpecificData($source, $field, $value)
    {
        $this->db->where($field, $value);
        $result = $this->db->get($source);
        return $result->result_array();
    }

    public function readSpecificData2($source, $field, $value, $field2, $value2)
    {
        $this->db->where($field, $value);
        $this->db->where($field2, $value2);
        $result = $this->db->get($source);
        return $result->result_array();
    }

    public function readSpecificData3($source, $field, $value, $field2, $value2, $field3, $value3)
    {
        $this->db->where($field, $value);
        $this->db->where($field2, $value2);
        $this->db->where($field3, $value3);
        $result = $this->db->get($source);
        return $result->result_array();
    }

    public function readSpecificData4($source, $field, $value, $field2, $value2, $field3, $value3, $field4, $value4)
    {
        $this->db->where($field, $value);
        $this->db->where($field2, $value2);
        $this->db->where($field3, $value3);
        $this->db->where($field4, $value4);
        $result = $this->db->get($source);
        return $result->result_array();
    }

    public function createData($source, $data)
    {
        $this->db->insert($source, $data);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function createBatchData($source, $data)
    {
        $this->db->insert_batch($source, $data);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function updateData($field, $value, $source, $data)
    {
        $this->db->where($field, $value);
        $this->db->update($source, $data);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function deleteData($source, $field, $value)
    {
        $this->db->where($field, $value);
        $this->db->delete($source);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function deleteDataSoft($source, $field, $value, $data)
    {
        $this->db->where($field, $value);
        $this->db->update($source, $data);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function deleteAll($source)
    {
        $this->db->empty_table($source);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function searchData($source, $field, $field2, $value)
    {
        $this->db->group_start();
        $this->db->like($field, $value);
        $this->db->or_like($field2, $value);
        $this->db->group_end();
        $result = $this->db->get($source);
        return $result->result_array();
    }
}