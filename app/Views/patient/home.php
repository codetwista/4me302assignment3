<?php
/**
 * Created by PhpStorm
 * User: codetwista
 * Date: 10/8/2022
 * Time: 1:28 PM
 */
?>
<?= $this->extend('templates/base')?>
<?= $this->section('content') ?>
            <section class="section">
                <h1>Parkinson's Disease Exercise Videos for <?= session()->username ?></h1>
                <div class="box">
                    <div class="columns">
                        <div class="column is-one-quarter is-3">
                            <iframe width="100%" height="148" src="https://www.youtube-nocookie.com/embed/pWqext64kxM"
                                    title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                        </div>
                        <div class="column is-one-quarter">
                            <iframe width="100%" height="148" src="https://www.youtube-nocookie.com/embed/WRyPQO_u_qE"
                                    title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                        </div>
                        <div class="column is-one-quarter">
                            <iframe width="100%" height="148" src="https://www.youtube-nocookie.com/embed/Gh8cZ_W2vR4"
                                    title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                        </div>
                        <div class="column is-one-quarter">
                            <iframe width="100%" height="148" src="https://www.youtube-nocookie.com/embed/_iomTrSv_N0"
                                    title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                        </div>
                    </div>
                </div>
                <div class="box mt-6">
                    <h2>Exercise session</h2>
                    <img src="<?= base_url('uploads/data/datetime-barchart-patient.png') ?>" alt="">
                </div>
            </section>
<?= $this->endSection() ?>
