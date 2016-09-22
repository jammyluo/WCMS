<?php

class ProvinceService
{

    private $_type = array(
        1 => "省份",
        2 => "地级市",
        3 => "区或县级市"
    );

    public function getType ($type, $id)
    {
        switch ($type) {
            case 1:
                $rs = ProvinceModel::instance()->getAllProvince();
                break;
            case 2:
                $rs = ProvinceModel::instance()->getCityByProvinceId($id);
                break;
            case 3:
                $rs = ProvinceModel::instance()->getAreasByCityId($id);
                break;
        }
        return json_encode($rs);
    }

    public function getAllProvince ()
    {
        return ProvinceModel::instance()->getAllProvince();
    }

    public function getAreasByCityId ($cityId)
    {
        if (empty($cityId)) {
            return;
        }
        return ProvinceModel::instance()->getAreasByCityId($cityId);
    }

    public function getCityByProvinceId ($provinceid)
    {
        if (empty($provinceid)) {
            return;
        }
        return ProvinceModel::instance()->getCityByProvinceId($provinceid);
    }

    public function getProvinceById ($provinceid)
    {
        if (empty($provinceid)) {
            return;
        }
        return ProvinceModel::instance()->getProvinceById($provinceid);
    }

    public function getAreasById ($areaid)
    {
        if (empty($areaid)) {
            return;
        }
        return ProvinceModel::instance()->getAreasById($areaid);
    }

    public function getCityById ($cityid)
    {
        if (empty($cityid)) {
            return;
        }
        return ProvinceModel::instance()->getCityById($cityid);
    }
}

class ProvinceModel extends Db
{

    private $_province = 'e_region'; // 省份
    public function getAllProvince ()
    {
        return $this->getAll($this->_province, array(
            'fid' => 1
        ), null, 'id ASC');
    }

    public function getProvinceById ($provinceid)
    {
        return $this->getOne($this->_province, array(
            'id' => $provinceid
        ));
    }

    public function getAreasByCityId ($cityid)
    {
        $sql = "SELECT * FROM $this->_province WHERE fid=$cityid AND name!=\"市辖区\" ORDER BY id ASC";
        return $this->fetchAll($sql);
    }

    public function getAreasById ($areaid)
    {
        $sql = "SELECT * FROM $this->_province WHERE id=$areaid AND name!=\"市辖区\"";
        return $this->fetch($sql);
    }

    public function getCityByProvinceId ($provinceid)
    {
        return $this->getAll($this->_province, array(
            'fid' => $provinceid
        ), null, 'id ASC');
    }

    public function getCityById ($cityid)
    {
        return $this->getOne($this->_province, array(
            'id' => $cityid
        ));
    }

    /**
     *
     * @return ProvinceModel
     */
    public static function instance ()
    {
        return parent::_instance(__CLASS__);
    }
}