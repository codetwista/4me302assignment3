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
//        return redirect()->to(base_url('researcher/home'));
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
    public function note($sessionId)
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
            'session' => $this->db->table('user, test, test_session, therapy')
                ->where('test.testID = test_session.Test_IDtest')
                ->where('test.Therapy_IDtherapy = therapy.therapyID')
                ->where('user.userID = therapy.User_IDpatient')
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
            'notes' => $this->db->table('user, test_session, note')
                ->where('note.Test_Session_IDtest_session = test_session.Test_SessionID')
                ->where('note.User_IDmed = user.userID')
                ->where('test_session.test_SessionID', $sessionId)
                ->orderBy('note.noteID', 'ASC')
                ->get()->getResult()
        ]);
    }
    
    public function postNote()
    {
        if ($this->request->getMethod() === 'post') {
            $note = $this->request->getPost('note');
            
            if ($this->validate([
                'note' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Note entry is required!'
                    ]
                ]
            ])) {
                $data = [
                    'Test_Session_IDtest_session' => $this->request->getPost('test_SessionID'),
                    'note' => $note,
                    'User_IDmed' => $this->request->getPost('userID'),
                    'created_at' => date('Y-m-d H:i:s')
                ];
                
                if ($this->db->table('note')->insert($data) === true) {
                    $this->session->setFlashdata('status', '
                    <div class="notification is-success is-light">
                      <h3>Session note saved successfully!</h3>
                    </div>');
                } else {
                    $this->session->setFlashdata('status', '
                <div class="notification is-danger is-light">
                  <h3>Session note not saved!</h3>
                </div>');
                }
                
                return redirect()->to(base_url('researcher/notes/' . $this->request->getPost('test_SessionID')));
            }
            
            return redirect()->back();
        }
        
        return false;
    }
}
