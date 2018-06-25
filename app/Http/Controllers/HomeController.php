<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Interfaces\IUtilizadorRepository;

class HomeController extends Controller
{

    public function index()
    {
        return view('home');

    }
    //
}
