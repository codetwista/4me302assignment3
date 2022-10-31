<?php
/**
 * Created by PhpStorm
 * User: codetwista
 * Date: 10/8/2022
 * Time: 2:36 PM
 */
?>
<?= $this->extend('templates/base')?>
<?= $this->section('content') ?>
            <?php if (! empty($userData)): ?>
            
            <section class="section">
                <h1>Patients list</h1>
                <table class="table is-striped is-narrow is-hoverable is-fullwidth">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>
                            <div class="is-flex is-justify-content-flex-end">
                                Geographic overview
                            </div>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $counter = 1; ?>
                    <?php foreach ($patients as $patient): ?>
                        <tr>
                            <td><?= $counter++ ?>.</td>
                            <td>
                                <a href="<?= base_url('researcher/patient/' . $patient->userID) ?>">
                                    <?= ucwords($patient->username) ?>
                                </a>
                            </td>
                            <td><?= strtolower($patient->email) ?></td>
                            <td>
                                <div class="is-flex is-justify-content-flex-end">
                                    <a class="button is-info is-light" href="<?= base_url('researcher/map')
                                    ?>">View map</a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach ?>
        
                    </tbody>
                </table>
            </section>
            <?php endif ?>

<?= $this->endSection() ?>
