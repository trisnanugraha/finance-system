<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class M_log extends CI_Model {

	public function select_all()
	{
		$sql =
			"SELECT
				log.log_id AS id,
                log.log_username AS username,
                log.log_type AS typeLog,
                log.log_desc AS descLog,
                log.log_id_act AS itemLog,
                log.log_time AS timeLog,
                log.log_ip AS ip
			FROM log_activity log
			ORDER BY timelog DESC
            LIMIT 100";
		$data = $this->db->query($sql);

		return $data->result();
	}
 
    public function save_log($param)
    {
        $sql        = $this->db->insert_string('log_activity',$param);
        $ex         = $this->db->query($sql);
        return $this->db->affected_rows($sql);
    }
}