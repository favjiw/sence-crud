<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Firebase\Contract\Database;
use Illuminate\Routing\Redirector;
use App\Models\Student;

class FirebaseController extends Controller
{
    protected $database;

    public function __construct(Database $database)
    {
        $this->database = $database;
    }

    private function singularSelection($path, $child, $value) {
        return $this->database
            ->getReference("/".$path)
            ->orderByChild($child)
            ->equalTo($value)
            ->getSnapshot()->getValue();
    }

    public function retrieve() 
    {
        $today = date("Y-m-d");
        // $today = "2022-11-30";

        $path = "/presence";
        $reference =  $this->database->getReference($path);
        $snapshot = $reference->getSnapshot();
        $value = $snapshot->getValue();

        $keys = array_keys($value);
        $result = [];

        for($i = 0; $i < count($keys); $i ++) {
            $val = $value[$keys[$i]];
            if( str_contains($val["time_in"], $today) ) {
                $result[$keys[$i]] = $val;
            }
        }

        return view("dashboard", [
            "value" => $result,
            "today" => $today
        ]);
    }

    public function studentHandler()
    {
        $path = "/users";
        $reference =  $this->database->getReference($path);
        $snapshot = $reference->getSnapshot();
        $value = $snapshot->getValue();

        $class = $this->database->getReference("/class")->getSnapshot()->getValue();
        $classes = array();

        foreach($class as $c) {
            $classes[$c["id"]] = $c["name"];
        }

        return view("student.index", [
            "value" => $value,
            "class" => $classes
        ]);
    }

    public function login(){
        return view("login");
    }

    public function loginHandler(Request $request) {
        $arr = $this->database
            ->getReference("/teacher")
            ->orderByChild("id")
            ->equalTo((int) $request->username)
            ->getSnapshot()->getValue();

        if(count($arr) == 1) {
            $key = array_keys($arr)[0];
            if($request->password === "12345678") {
                return redirect();
            }
        }
    }
}