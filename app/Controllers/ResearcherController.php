<?php

namespace App\Controllers;


class ResearcherController extends BaseController
{
    public function index()
    {
        // If user is not logged in, redirect to log in view
        if (! $this->session->has('profile')) return redirect()->to(base_url('login'));
    
        if (empty($userId)) return redirect()->to(base_url($this->session->profile));
        //
        return view('researcher/home', [
            'title' => 'Researcher',
            'uri' => $this->uri->setSilent()
        ]);
    }
    
    public function getPatient($userId = null)
    {
        // If user is not logged in, redirect to log in view
        if (! $this->session->has('profile')) return redirect()->to(base_url('login'));
        
        if (empty($userId)) return redirect()->to(base_url($this->session->profile));
        //
        return view('researcher/patient_info', [
            'title' => 'Patient information',
            'uri' => $this->uri->setSilent(),
            'patient' => $this->db->table('user, role, organization')
                ->where('user.Role_IDrole = role.type')
                ->where('user.Organization = organization.organizationID')
                ->where('user.Role_IDrole', 1)
                ->where('userID', $userId)->get()->getRow(),
            'sessions' => $this->db->table('user, test, test_session, therapy')
                ->where('test.testID = test_session.Test_IDtest')
                ->where('test.Therapy_IDtherapy = therapy.therapyID')
                ->where('user.userID = therapy.User_IDpatient')
                ->where('user.Role_IDrole', 1)
                ->where('user.userID', $userId)
                ->get()->getResult(),
            'therapies' => $this->db->table('user, test, therapy, therapy_list, medicine')
                ->where('therapy.TherapyList_IDtherapylist = therapy_list.therapy_listID')
                ->where('therapy_list.Medicine_IDmedicine = medicine.medicineID')
                ->where('user.userID = therapy.User_IDpatient')
                ->where('test.Therapy_IDtherapy = therapy.therapyID')
                ->where('user.Role_IDrole', 1)
                ->where('user.userID', $userId)
                ->get()->getResult(),
        ]);
    }
    
    public function map()
    {
        //
        return view('researcher/map', [
            'title' => 'Patient\'s Geographic Overview',
            'uri' => $this->uri->setSilent()
        ]);
    }
    public function postNote($sessionId)
    {
        // If user is not logged in, redirect to log in view
        if (! $this->session->has('profile')) return redirect()->to(base_url('login'));
    
        if (empty($sessionId)) return redirect()->back();
        
        return view('researcher/notes', [
            'title' => 'Add note',
            'uri' => $this->uri->setSilent(),
            'patient' => $this->db->table('user, role, organization')
                ->where('user.Role_IDrole = role.type')
                ->where('user.Organization = organization.organizationID')
                ->where('user.Role_IDrole', 1)
                ->get()->getRow(),
            'session' => $this->db->table('user, test, test_session, therapy, note')
                ->where('test.testID = test_session.Test_IDtest')
                ->where('test.Therapy_IDtherapy = therapy.therapyID')
                ->where('user.userID = therapy.User_IDpatient')
                ->where('note.Test_Session_IDtest_session = test_session.Test_IDtest')
                ->where('note.User_IDmed = therapy.User_IDmed')
                ->where('user.Role_IDrole', 1)
                ->where('test_session.test_SessionID', $sessionId)
                ->get()->getRow(),
            'therapies' => $this->db->table('user, test, therapy, therapy_list, medicine')
                ->where('therapy.TherapyList_IDtherapylist = therapy_list.therapy_listID')
                ->where('therapy_list.Medicine_IDmedicine = medicine.medicineID')
                ->where('user.userID = therapy.User_IDpatient')
                ->where('test.Therapy_IDtherapy = therapy.therapyID')
                ->where('user.Role_IDrole', 1)
                ->get()->getResult(),
        ]);
    }
}
