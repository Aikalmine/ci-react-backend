<?php
namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\HTTP\RequestInterface;
use UserModel;

class User extends ResourceController 
{
	
    protected $modelName = 'App\Models\UserModel';
    protected $format    = 'json';

	// fetch all products
    public function index() 
    {
        return $this->respond($this->model->findAll());
    }

    // save new product info
    public function create() 
    {
		// get posted JSON
		//$json = json_decode(file_get_contents("php://input", true));
		$json = $this->request->getJSON();
		
		$name = $json->name;
		$email = $json->email;
		$password = $json->password;
	
		
		$data = array(
			'name' => $name,
			'email' => $email,
			'password' => $password
		);
		
        $this->model->insert($data);
		
        $response = array(
			'status'   => 201,
			'messages' => array(
				'success' => 'User created successfully'
			)
		);
		
		return $this->respondCreated($response);
    }

    // fetch single product
    public function show($id = null) 
    {
        $data = $this->model->where('id', $id)->first();
		
        if($data)
        {
            return $this->respond($data);
        }
        else
        {
            return $this->failNotFound('No user found');
        }
    }

    // update product by id
    public function update($id = NULL)
    {		
		//$json = json_decode(file_get_contents("php://input", true));
		$json = $this->request->getJSON();
		
		$name = $json->name;
		$email = $json->email;
		$password = $json->password;
		
		$data = array(
			'id' => $id,
			'name' => $name,
			'email' => $email,
			'password' => $password
		);
		
        $this->model->update($id, $data);
        
		$response = array(
			'status'   => 200,
			'messages' => array(
				'success' => 'User updated successfully'
			)
		);
	  
		return $this->respond($response);
    }

    // delete user by id
    public function delete($id = NULL){
        $data = $this->model->find($id);
		
        if($data) {
            $this->model->delete($id);
			
            $response = array(
                'status'   => 200,
                'messages' => array(
                    'success' => 'User successfully deleted'
                )
            );
			
            return $this->respondDeleted($response);
        } else {
            return $this->failNotFound('No user found');
        }
    }
}