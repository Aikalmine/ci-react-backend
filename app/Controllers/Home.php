<?php

namespace App\Controllers;
use App\Models\ProductModel;
class Home extends BaseController
{
	public function index()
	{
		return view('welcome_message');
	}
}
