<?php

namespace App\Controllers;

require_once APPPATH . 'Libraries/vendor/autoload.php';

use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;

class PhysicianController extends BaseController
{
    public function index()
    {
        // If user is not logged in, redirect to log in view
        if (! $this->session->has('username')) return redirect()->to(base_url('login'));
        
        // Render default physician view
        return view('physician/home', [
            'title' => 'Physician Dashboard',
            'patients' => $this->db->table('user, role')
                ->where('user.Role_IDrole = role.type')
                ->where('user.Role_IDrole', 1)
                ->get()
                ->getResult()
        ]);
    }
    
    public function getPatient($userId = null)
    {
        // If user is not logged in, redirect to log in view
        if (! $this->session->has('profile')) return redirect()->to(base_url('login'));
        
        if (empty($userId)) return redirect()->to(base_url($this->session->profile));
        //
        $patient = $this->db->table('user, role, organization')
            ->where('user.Role_IDrole = role.type')
            ->where('user.Organization = organization.organizationID')
            ->where('user.Role_IDrole', 1)
            ->where('userID', $userId)->get()->getRow();
        
        /*$xAxis = $yAxis = [];
    
        $data = $this->db->table('data6')->get()->getResultArray();
        foreach ($data as $row) {
            array_push($xAxis, $row['X']);
            array_push($yAxis, $row['Y']);
        }
    
        $__width  = 640;
        $__height = 480;
        $graph    = new Graph\Graph($__width, $__height);
        $graph->SetScale('linlin');
    
        $graph->img->SetMargin(60, 60, 60, 60);
        $graph->SetShadow();
    
        $graph->title->Set('Tapping exercise visualization for ' . ucwords($patient->username));
        $graph->title->SetFont(FF_FONT2, FS_BOLD);
        
        $sp1 = new Plot\ScatterPlot($yAxis, $xAxis);
    
        $graph->Add($sp1);
        $graph->Stroke(FCPATH . 'uploads/data/data6.png');*/
        
        return view('researcher/patient_info', [
            'title' => 'Patient information',
            'uri' => $this->uri->setSilent(),
            'patient' => $patient,
            'sessions' => $this->db->table('user, test, test_session, therapy')
                ->where('test.testID = test_session.Test_IDtest')
                ->where('test.Therapy_IDtherapy = therapy.therapyID')
                ->where('user.userID = therapy.User_IDpatient')
                ->where('user.Role_IDrole', 1)
                ->where('user.userID', $userId)
                ->get()->getResult(),
            'therapies' => $this->db->table('user, test, therapy, therapy_list, medicine')
                ->where('therapy.TherapyList_IDtherapylist = therapy_list.therapy_listID')
                ->where('therapy.User_IDmed = medicine.medicineID')
                ->where('user.userID = therapy.User_IDpatient')
                ->where('test.Therapy_IDtherapy = therapy.therapyID')
                ->where('user.Role_IDrole', 1)
                ->where('user.userID', $userId)
                ->get()->getResult(),
        ]);
    }
    
    
}
