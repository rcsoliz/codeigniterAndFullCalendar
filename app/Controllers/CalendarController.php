<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\CalendarModel;
use CodeIgniter\API\ResponseTrait;
class CalendarController extends Controller
{
    public function index()
    {
        $Crud = new CalendarModel();
        $datos = $Crud->getAll();

        $mensaje = session('mensaje');

        $data = [
            "datos"=> $datos,
            "mensaje" => $mensaje
        ];

       // echo json_encode($data, JSON_UNESCAPED_UNICODE);
    
        return view('calendar', $data);
    }

    public function crear(){
		$datos = [
            "title" => $_POST['title'],
            "description" => $_POST['description'],
            "color" => $_POST['color'],
            "start_date" => $_POST['start_date'],
            "end_date" => $_POST['end_date']
        ];

        $id = $_POST['id'];

        $Crud = new CalendarModel();
        if($id ==''){
            $respuesta = $Crud->insertar($datos);

            if($respuesta == 1){
                $mensaje = array('msg' => 'Cita registrada', 'estado' => true,'tipo'=> 'success'); 
              
                return redirect()->to(base_url().'/calendar')->with('mensaje',  '1');
            }
            else{
                $mensaje = array('msg' => 'Erro al registrar el evento', 'estado' => false,'tipo'=> 'error'); 
                return redirect()->to(base_url().'/')->with('mensaje', '0');
            }
        }else{
            $respuesta = $Crud->actualizar($datos,  $id);
            if($respuesta == 1){
                $mensaje = array('msg' => 'Cita actualizada', 'estado' => true,'tipo'=> 'success'); 
              
                return redirect()->to(base_url().'/calendar')->with('mensaje',  '1');
            }
            else{
                $mensaje = array('msg' => 'Erro al actualizar el evento', 'estado' => false,'tipo'=> 'error'); 
                return redirect()->to(base_url().'/')->with('mensaje', '0');
            }
        }

        
    }

    public function getevents(){
        $Crud = new CalendarModel();
        $respuesta = $Crud->getAll();

        return  $this->response->setJSON($respuesta); //view('calendar', $datos);
    }

    public function eliminar($id){
    
        $Crud = new CalendarModel();
        $data = ["id" => $id];

        $respuesta = $Crud->eliminar($data);
        
        if($respuesta){
            return redirect()->to(base_url().'/calendar')->with('mensaje', '4');
        }
        else{
            return redirect()->to(base_url().'/')->with('mensaje', '5');
        }

    }

    public function drop(){
        $datos = [
            "start_date" => $_POST['start_date'],
            "end_date" => $_POST['end_date']
        ];
        
        print_r( $datos );

        $id = $_POST['id'];
        print_r( $id );
        
        $Crud = new CalendarModel();
        $data = $Crud->drop($datos, $id);

        if($data == 1){
            $mensaje = array('msg' => 'Cita modificado', 'estado' => true,'tipo'=> 'success'); 
        }
        else{
            $mensaje = array('msg' => 'Cita al modificar el evento', 'estado' => false,'tipo'=> 'error'); 
        }

        return redirect()->to(base_url().'/calendar')->with('mensaje',  '1');
    }

    // You can add methods to fetch and manipulate calendar data here
}
