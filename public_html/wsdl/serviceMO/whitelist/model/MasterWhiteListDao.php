<?php
require_once '/home/smsmkt/public/wsdl/skysms/whitelist/model/Conexion.php';

class MasterWhiteListDao{

private $_mysqli;

    function __construct(){
        $this->_mysqli = Conexion::getInstance();
    }

    protected function getListDao($limit){

        $query = <<<sql
SELECT * FROM white_list
WHERE (estatus = 0 OR (estatus = 2 AND operationId = -2))
ORDER BY estatus ASC
LIMIT $limit
sql;
        return $this->_mysqli->queryAll($query);
    }

    protected function updateEstatusDao($id, $estatus){

        $query = <<<sql
UPDATE white_list SET estatus = $estatus
WHERE id IN ($id)
sql;
        return $this->_mysqli->update($query);
    }

    protected function updateEstatusIdDao($id, $estatus, $operationId){
        $query = <<<sql
UPDATE white_list SET estatus = $estatus , operationId = $operationId
WHERE id IN ($id)
sql;
        return $this->_mysqli->update($query);
    }
}
?>
