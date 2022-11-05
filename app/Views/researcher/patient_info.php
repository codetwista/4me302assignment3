<?php
/**
 * Created by PhpStorm
 * User: codetwista
 * Date: 10/30/2022
 * Time: 6:55 AM
 */
?>
<?= $this->extend('templates/base')?>
<?= $this->section('content') ?>
            <section class="section">
                <?php if (! empty($patient)): ?>
                
                <h1>Patient's details</h1>
                <div class="box">
                    <table class="table is-striped is-narrow is-hoverable is-fullwidth">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Organization</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td><?= ucwords($patient->username) ?></td>
                            <td><?= strtolower($patient->email) ?></td>
                            <td><?= ucfirst(strtolower($patient->name)) ?></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                
                <div class="box my-6">
                    <?php if (! empty($sessions)): ?>
                    
                    <h2>Test sessions</h2>
                    <div class="table-container">
                        <table class="table is-striped is-narrow is-hoverable is-fullwidth">
                            <thead>
                            <tr>
                                <th>Session ID</th>
                                <th>Exercise type</th>
                                <th>Raw data</th>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Visualization</th>
                                <?php if (session()->profile ==='researcher'): ?>
                                
                                <th>Notes</th>
                                <?php endif ?>
                                
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($sessions as $session): ?>
            
                                <tr>
                                    <td><?= $session->test_SessionID ?></td>
                                    <td>
                                        <?php if ($session->test_type == 1) echo 'Drawing a spiral' ?>
                    
                                        <?php if ($session->test_type == 2) echo 'Tapping' ?>
                
                                    </td>
                                    <td>
                                        <a class="mr-5" href="<?= base_url('uploads/data/' . $session->DataURL . '.csv') ?>">
                                            <?= ucfirst(strtolower($session->DataURL)) ?>
                                        </a>
                                    </td>
                                    <td><?= date('F j, Y', strtotime($session->dateTime)) ?></td>
                                    <td><?= date('g:ia', strtotime($session->dateTime)) ?></td>
                                    <td>
                                        <button class="js-modal-trigger button is-info is-light" data-target="<?= $session->DataURL ?>">
                                            <i class="lar la-chart-bar mr-2"></i>Visualize data
                                        </button>
                                        <div id="<?= $session->DataURL ?>" class="modal">
                                            <div class="modal-background"></div>
                                            <div class="modal-content">
                                                <p class="image is-4by3">
                                                    <img src="<?= base_url('uploads/data/' . $session->DataURL . '.png') ?>" alt="">
                                                </p>
                                            </div>
                                            <button class="modal-close is-large" aria-label="close"></button>
                                        </div>
                                    </td>
                                    <?php if (session()->profile ==='researcher'): ?>
                                    
                                    <td>
                                        <a class="button is-info is-light" href="<?= base_url('researcher/notes/' . $session->test_SessionID) ?>">
                                            <i class="las la-notes-medical mr-2"></i>Notes
                                        </a>
                                    </td>
                                    <?php endif ?>
                                    
                                </tr>
                            <?php endforeach ?>
        
                            </tbody>
                        </table>
                    </div>
                    <?php else: ?>
                    
                    <h2>No exercise data available!</h2>
                    <div class="notification is-info is-light">
                        <p>Patient does not have any exercise session yet!</p>
                    </div>
                    <?php endif ?>
                    
                </div>
                <div class="box mt-6">
                    <?php if (! empty($therapies)): ?>
                    
                    <h2>Therapy</h2>
                    <div class="table-container">
                        <table class="table is-striped is-narrow is-hoverable is-fullwidth">
                            <thead>
                            <tr>
                                <th>Therapy #</th>
                                <th>Name</th>
                                <th>Medicine</th>
                                <th>Dosage</th>
                                <th>Date</th>
                                <th>Time</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $counter = 1; foreach($therapies as $therapy): ?>
            
                                <tr>
                                    <td><?= $counter++ ?></td>
                                    <td><?= ucfirst($therapy->therapy_listName) ?></td>
                                    <td><?= ucfirst($therapy->name) ?></td>
                                    <td><?= ucfirst($therapy->Dosage) ?></td>
                                    <td><?= date('F j, Y', strtotime($therapy->dateTime)) ?></td>
                                    <td><?= date('g:i a', strtotime($therapy->dateTime)) ?></td>
                                </tr>
                            <?php endforeach ?>
        
                            </tbody>
                        </table>
                    </div>
                    <?php else: ?>
    
                    <h2>No therapy data available!</h2>
                    <div class="notification is-info is-light">
                        <p>Patient does not have any therapy records yet!</p>
                    </div>
                    <?php endif ?>

                </div>
                <?php else: ?>
                
                <h1>Resource not found!</h1>
                <div class="notification is-danger is-light">
                    <p>Sorry, the resource you have requested for is not valid!</p>
                    <button onclick="history.back()" class="button is-danger mt-3"><i class="las la-undo mr-3"></i>Go back</button>
                </div>
                <?php endif ?>
                
            </section>
<?= $this->endSection() ?>
