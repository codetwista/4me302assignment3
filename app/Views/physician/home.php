<?php
/**
 * Created by PhpStorm
 * User: codetwista
 * Date: 10/8/2022
 * Time: 2:30 PM
 */
?>
<?= $this->extend('templates/base')?>
<?= $this->section('content') ?>
            <?php if (! empty($userData)): ?>
            
            <section class="section">
                <h1>Patients list</h1>
                <div class="table-container">
                    <table class="table is-striped is-narrow is-hoverable is-fullwidth">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $counter = 1; ?>
                        <?php foreach ($patients as $patient): ?>
                            <tr>
                                <td><?= $counter++ ?>.</td>
                                <td>
                                    <a href="<?= base_url(session()->profile . '/patient/' . $patient->userID) ?>">
                                        <?= ucwords($patient->username) ?>
                                    </a>
                                </td>
                                <td><?= strtolower($patient->email) ?></td>
                                </td>
                            </tr>
                        <?php endforeach ?>
        
                        </tbody>
                    </table>
                </div>
            </section>
            
            <?php endif ?>

<?= $this->endSection() ?>
