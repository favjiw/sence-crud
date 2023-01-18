<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Firebase\Contract\Database;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
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

    private function uidSelection($path, $uid) {
        return $this->database
            ->getReference("/".$path."/".$uid)
            ->getValue();
    } 

    public function retrieve() 
    {
        $today = date("Y-m-d");
        $today = "2022";

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
        $user = $this->singularSelection("teacher", "id", (int) $request->username);

        if(count($user) == 1) {
            $key = array_keys($user)[0];
            if(hash('sha256', $request->password) === $user[$key]["password"]) {
                $request->session()->put('authenticated', true);
                return redirect("/");
            }
        }
    }

    public function out() {
        session()->flush();
        return redirect("/login");
    } 

    public function presenceCreate() {
        return view("presence.create");
    }

    public function presenceDetail($uid) {
        $record = $this->uidSelection("presence", $uid);
        $record["uid"] = $uid;
        return view("presence.detail", [
            "record" => $record
        ]);
    }

    public function presenceUpdate(Request $request, $uid) {
        $columns = ["student_id", "status", "time_in", "time_out"];
        $temp = [];

        foreach($columns as $col) {$temp[$col] = $request[$col];}

        $this->database->getReference("/presence/".$uid)->set([
            "status" => $request->status,
            "time_in" => $request->time_in,
            "time_out" => $request->time_out,
            "student_id" => $request->student_id,
        ]);

        return redirect("/")->with("message", $uid." updated");
    }
}