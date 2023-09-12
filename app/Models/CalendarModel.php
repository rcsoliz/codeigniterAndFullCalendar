<?php namespace App\Models;
use CodeIgniter\Model;

class CalendarModel extends Model{
    public function getAll(){
         $Nombres = $this->db->query("SELECT id, title, description, start_date as 'start', end_date as 'end' FROM calendar");
         //$Nombres = $this->db->query("SELECT * FROM calendar");
        return $Nombres->getResult();
    }

    public function insertar($datos) {
        $Nombres = $this->db->table('calendar');
        $Nombres->insert($datos);

        return $this->db->insertID(); 
    }

    public function getCalendar($data){
        $Nombres = $this->db->table('calendar');
        $Nombres-> where($data);

        return $Nombres->get()->getResultArray();
    }

    public function actualizar($data, $idNombre){
        $Nombres = $this->db->table('calendar');
        $Nombres->set($data);
        $Nombres->where('id', $idNombre);

        return $Nombres->update();

    }

    public function eliminar($data){
        $Nombres = $this->db->table('calendar');
        $Nombres->where($data);

        return $Nombres->delete();
    }

    public function drop($data, $id){
        $Nombres = $this->db->table('calendar');
        $Nombres->set($data);
        $Nombres->where('id', $id);

        return $Nombres->update();
     
    }
}