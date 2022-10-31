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
                    <h2>Test sessions</h2>
                    <table class="table is-striped is-narrow is-hoverable is-fullwidth">
                        <thead>
                        <tr>
                            <th>Session ID</th>
                            <th>Exercise type</th>
                            <th>Raw data</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Visualization</th>
                            <th>Notes</th>
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
                                <a class="button is-info is-light" href="<?= base_url('researcher/notes/' . $session->test_SessionID) ?>">
                                    <i class="las la-notes-medical mr-2"></i>View notes
                                </a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="box my-6">
                    <?= $session->note ?>
                
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

