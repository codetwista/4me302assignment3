<?php
/**
 * Created by PhpStorm
 * User: codetwista
 * Date: 10/31/2022
 * Time: 8:33 AM
 */
?>
<?= $this->extend('templates/base')?>
<?= $this->section('content') ?>
            <section class="section">
                <?php if (! empty($session)): ?>
                
                <h1>Patient test session <?= $session->test_SessionID ?> notes</h1>
                <div class="box">
                    <h2>Test session</h2>
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
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
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
                                <td>
                                    <button class="js-modal-trigger button is-success is-light" data-target="<?= $session->test_SessionID ?>">
                                        <i class="las la-edit mr-2"></i>Add note
                                    </button>
                                    <div id="<?= $session->test_SessionID ?>" class="modal">
                                        <div class="modal-background"></div>
                                        <div class="modal-card">
                                            <?= form_open('researcher/note', 'class="mt-3"') ?>
                                            <?= form_hidden('test_SessionID',  $session->test_SessionID ) ?>
                                            <?= form_hidden('userID',  session()->userID ) ?>
                                            <header class="modal-card-head">
                                                <p class="modal-card-title is-size-5">Add note to <?= ucwords
                                                    ($session->username) ?>'s test session</p>
                                                <button class="delete" aria-label="close"></button>
                                            </header>
                                            <section class="modal-card-body">
                                                <div class="field">
                                                    <textarea id="note" class="textarea" name="note"
                                                              placeholder="Enter note" autofocus></textarea>
                                                </div>
                                            </section>
                                            <footer class="modal-card-foot">
                                                <button class="button is-success">Save note</button>
                                                <button class="button">Cancel</button>
                                            </footer>
                                            <?= form_close() ?>
                                            
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="box my-6">
                    <h2>Notes</h2>
                    <?php if (! empty($validation)): ?>
                    <div class="notification is-danger is-light my-3">
                        <h2 class="mb-2">Please review your submission!</h2>
                        <?= $validation->listErrors() ?>
                    </div>
                    <?php endif ?>
                    
                    <?php if (session()->getFlashdata('status')): ?>
                    
                    <?= session()->getFlashdata('status') ?>
                    <?php endif ?>
                    
                    <?php if (! empty($notes)): ?>
                    <div class="is-flex is-flex-wrap-wrap is-justify-content-flex-start">
                        <?php foreach ($notes as $note): ?>
                        
                        <div class="has-border mr-5 mb-4">
                            <article class="message is-info">
                                <div class="message-body">
                                    <p class="mb-3"><?= $note->note ?></p>
                                    <p class="is-small">Posted by: <?= ucwords($note->username) ?>
                                        <br>
                                        <?= date('D jS, F Y', strtotime($note->created_at)) ?> </p>
                                </div>
                            </article>
                        </div>
                    <?php endforeach ?>

                    </div>
                    <?php else: ?>
                    
                    <div class="notification is-info is-light">
                        <p>There are no notes available for this patient's session!</p>
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

