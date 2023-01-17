<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Firebase\Contract\Database;
use App\Models\Student;

class FirebaseController extends Controller
{
    protected $database;

    public function __construct(Database $database)
    {
        $this->database = $database;
    }

    public function retrieve() 
    {
        $path = "/users";
        $reference =  $this->database->getReference($path);
        $snapshot = $reference->getSnapshot();
        $value = $snapshot->getValue();

        return view("dashboard", [
            "value" => $value
        ]);
    }

    public function studentHandler()
    {
        $path = "/users";
        $reference =  $this->database->getReference($path);
        $snapshot = $reference->getSnapshot();
        $value = $snapshot->getValue();

        return view("student.index", [
            "value" => $value
        ]);
    }
}