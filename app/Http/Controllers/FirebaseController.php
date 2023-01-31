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
        $path = "/presence";
        $reference =  $this->database->getReference($path);
        $snapshot = $reference->getSnapshot();
        $value = $snapshot->getValue();

        $data = [
            "hadir" => 0,
            "izin" => 0,
            "sakit" => 0
        ];

        $onStatus = [
            "hadir" => [1,2,7,8],
            "sakit" => [5],
            "izin" => [6]
        ];

        foreach($onStatus as $key => $val) {
            if($key == "hadir") {
                foreach($val as $status) {
                    $data["hadir"] += count(array_keys($this->singularSelection("presence", "status", $status)));
                }
            }else if($key == "sakit") {
                foreach($val as $status) {
                    $data["sakit"] += count(array_keys($this->singularSelection("presence", "status", $status)));
                }
            }else if($key == "izin") {
                foreach($val as $status) {
                    $data["izin"] += count(array_keys($this->singularSelection("presence", "status", $status)));
                }
            }
        }

        return view("dashboard", [
            "value" => $value,
            "today" => $today,
            "data" => $data,
        ]);
    }

    public function studentHandler()
    {
        $path = "/users";
        $reference =  $this->database->getReference($path);
        $snapshot = $reference->getSnapshot();
        $value = $snapshot->getValue();

        $keys = array_keys($value);
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

        $this->database->getReference("/presence/".$uid)->set([
            "status" => $request->status,
            "time_in" => $request->time_in,
            "time_out" => $request->time_out,
            "student_id" => $request->student_id,
        ]);

        return redirect("/")->with("message", $uid." updated");
    }

    public function studentCreate() {
        return view("student.create");
    }

    public function studentInsert(Request $request) {
        // Validate existing class_id

        $this->database->getReference("/users")->push()->set([
            "id" => (int) $request->student_id,
            "name" => $request->name,
            "class_id" => (int) $request->class_id,
            "email" => $request->email,
            "telp" => $request->telp,
            "password" => hash('sha256', "12345678")
        ]);

        return redirect(route("student.index"))->with("message", "New data created.");
    }

    public function studentDetail($uid) {
        $record = $this->uidSelection("users", $uid);
        $record["uid"] = $uid;
        return view("student.detail", [
            "record" => $record
        ]);
    }

    public function studentUpdate(Request $request, $uid) {
        $this->database->getReference("/users/".$uid)->set([
            "id" => (int) $request->student_id,
            "name" => $request->name,
            "class_id" => (int) $request->class_id,
            "email" => $request->email,
            "telp" => $request->telp,
            "password" => hash('sha256', "12345678")
        ]);

        return redirect(route("student.index"))->with("message", "New data created.");
    }
    
    public function studentDelete($uid) {
        $this->database->getReference("/users/".$uid)->remove();

        return redirect(route("student.index"))->with("message", "Data removed");
    }

    public function teacherHandler() {
        $path = "/teacher";
        $reference =  $this->database->getReference($path);
        $snapshot = $reference->getSnapshot();
        $value = $snapshot->getValue();

        $keys = array_keys($value);
        $class = $this->database->getReference("/class")->getSnapshot()->getValue();
        $classes = array();

        foreach($class as $c) {
            $classes[$c["id"]] = $c["name"];
        }

        return view("teacher.index", [
            "value" => $value,
            "class" => $classes
        ]);
    }

    public function teacherCreate() {
        return view("teacher.create");
    }

    public function teacherInsert(Request $request) {
        // Validate existing class_id

        $this->database->getReference("/teacher")->push()->set([
            "id" => (int) $request->student_id,
            "name" => $request->name,
            "homeroom_class_id" => (int) $request->homeroom_class_id,
            "email" => $request->email,
            "telp" => $request->telp,
            "password" => hash('sha256', "12345678")
        ]);

        return redirect(route("teacher.index"))->with("message", "New data created.");
    }

    public function teacherDetail($uid) {
        $record = $this->uidSelection("teacher", $uid);
        $record["uid"] = $uid;
        return view("teacher.detail", [
            "record" => $record
        ]);
    }

    public function teacherUpdate(Request $request, $uid) {
        $this->database->getReference("/teacher/".$uid)->set([
            "id" => (int) $request->student_id,
            "name" => $request->name,
            "homeroom_class_id" => (int) $request->homeroom_class_id,
            "email" => $request->email,
            "telp" => $request->telp,
            "password" => hash('sha256', "12345678")
        ]);

        return redirect(route("teacher.index"))->with("message", "New data updated.");
    }
    
    public function teacherDelete($uid) {
        $this->database->getReference("/teacher/".$uid)->remove();

        return redirect(route("teacher.index"))->with("message", "Data removed");
    }


    public function classHandler() {
        $path = "/class";
        $reference =  $this->database->getReference($path);
        $snapshot = $reference->getSnapshot();
        $value = $snapshot->getValue();

        return view("class.index", [
            "value" => $value
        ]);
    }

    public function classCreate() {
        return view("class.create");
    }

    public function classInsert(Request $request) {
        // Validate existing class_id

        $this->database->getReference("/class")->push()->set([
            "field" => $request->field,
            "grade" => (int) $request->grade,
            "id" => (int) $request->id,
            "name" => $request->name, 
        ]);

        return redirect(route("class.index"))->with("message", "New data created.");
    }

    public function classDetail($uid) {
        $record = $this->uidSelection("class", $uid);
        $record["uid"] = $uid;
        return view("class.detail", [
            "record" => $record
        ]);
    }

    public function classUpdate(Request $request, $uid) {
        $this->database->getReference("/class/".$uid)->set([
            "field" => $request->field,
            "grade" => (int) $request->grade,
            "id" => (int) $request->id,
            "name" => $request->name, 
        ]);

        return redirect(route("class.index"))->with("message", "New data updated.");
    }
    
    public function classDelete($uid) {
        $this->database->getReference("/class/".$uid)->remove();

        return redirect(route("class.index"))->with("message", "Data removed");
    }

    public function pendingPresenceHandler() {
        $data = $this->singularSelection("presence", "status", 3);
        
        foreach($this->singularSelection("presence", "status", 4) as $key => $val) {
            $data[$key] = $val;
        }

        return $data;
    }
}