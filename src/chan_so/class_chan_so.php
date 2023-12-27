<?php
$document_root = $document_root?? $_SERVER['DOCUMENT_ROOT'];


class chanso{

    public static function doc_db(string $sql, sql_connector $sql_connector = null): array
    {
        $tins = array();
        if($sql_connector === null)
            $sql_connector = new sql_connector();
        if ($result = $sql_connector->get_query_result($sql)) {
            while ($row = $result->fetch_assoc()) {
                $tin = new tin();
                $tin->lay_du_lieu($row);
                $tins[] = $tin;
            }

        }
        return $tins;
    }

}


>