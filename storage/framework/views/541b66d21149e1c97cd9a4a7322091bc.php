<footer class="sigera-footer">
    <div class="sigera-footer__wrap">
        
        <div class="sigera-footer__brand">
            <div class="sigera-footer__logos">
                <img src="<?php echo e(asset('assets/logo-dpmptsp.png')); ?>" alt="DPMPTSP" class="sigera-footer__logo">
                <img src="<?php echo e(asset('assets/logo-sigera.png')); ?>" alt="SIGERA" class="sigera-footer__logo">
            </div>

            <div class="sigera-footer__brandtext">
                <div class="sigera-footer__title">SIGERAIMPP</div>
                <div class="sigera-footer__subtitle">Sistem Informasi Gerai Mal Pelayanan Publik</div>
                <div class="sigera-footer__desc">
                    untuk memudahkan pengelolaan dan monitoring layanan secara terpusat.
                </div>
            </div>
        </div>

        
        <div class="sigera-footer__col sigera-footer__links-col">
            <div class="sigera-footer__coltitle">Tautan Cepat</div>
            <div class="sigera-footer__list">
                <div>Dashboard</div>
                <div>Laporan</div>
                <div>Ranking</div>
                <div>Arsip</div>
            </div>
        </div>

        
        <div class="sigera-footer__col sigera-footer__col--wide">
            <div class="sigera-footer__coltitle">Alamat | Kontak</div>
            <div class="sigera-footer__text">
                <div>Jalan Dr. Susilo Nomor 2, Sumur Batu,</div>
                <div>Teluk Betung Utara, Bandar Lampung 35241</div>
                <div class="sigera-footer__spacer"></div>
                <div>Telepon (0721) 476362</div>
                <div>Faksimile (0721) 476362</div>
            </div>
        </div>

        
        <div class="sigera-footer__col sigera-footer__social-col">
            <div class="sigera-footer__coltitle">Sosial Media</div>
            <div class="sigera-footer__social">
                <div class="sigera-footer__socialitem sigera-footer__socialitem--nowrap">
                    <span class="sigera-footer__icon">🌐</span>
                    <span>www.dpmptsp.bandarlampungkota.go.id</span>
                </div>
                <div class="sigera-footer__socialitem">
                    <span class="sigera-footer__icon">📷</span>
                    <span>mppbandarlampung</span>
                </div>
                <div class="sigera-footer__socialitem">
                    <span class="sigera-footer__icon">📷</span>
                    <span>ptsp.bandarlampung</span>
                </div>
            </div>
        </div>
    </div>

    <style>
        .sigera-footer{
            /* ✅ transparan agar ikut background hero */
            background: linear-gradient(
                90deg,
                rgba(241, 36, 36, 0.78) 0%,
                rgba(121, 27, 145, 0.78) 50%,
                rgba(0, 17, 255, 0.78) 100%
            );
            position: relative;
            overflow: hidden;
            color:#fff;
            font-family: Arial, sans-serif;
            padding: 26px 34px;
            box-sizing: border-box;

            /* biar halus menyatu */
            backdrop-filter: blur(2px);
        }

        .sigera-footer__wrap{
            position: relative;
            display:flex;
            align-items:flex-start;
            justify-content:space-between;
            gap: 34px;
            flex-wrap: wrap;
        }

        .sigera-footer__brand{
            display:flex;
            align-items:center;
            gap: 14px;
            flex: 1 1 340px;
            min-width: 300px;
        }

        .sigera-footer__logos{
            display:flex;
            align-items:center;
            gap: 10px;
        }

        .sigera-footer__logo{
            height:48px;
            width:auto;
            object-fit:contain;
        }

        .sigera-footer__brandtext{
            display:flex;
            flex-direction:column;
            gap: 8px;
            max-width: 380px;
        }

        .sigera-footer__title{
            font-weight:800;
            font-size:30px;
            line-height:1;
        }

        .sigera-footer__subtitle,
        .sigera-footer__desc{
            font-size:14px;
            line-height:1.5;
        }

        .sigera-footer__col{
            flex: 1 1 170px;
            min-width: 170px;
        }

        .sigera-footer__col--wide{
            flex: 1 1 320px;
            min-width: 280px;
        }

        .sigera-footer__coltitle{
            font-weight:700;
            font-size:16px;
            margin-bottom:10px;
        }

        .sigera-footer__list,
        .sigera-footer__text,
        .sigera-footer__social{
            font-size:14px;
            line-height:1.6;
            opacity:0.95;
        }

        .sigera-footer__spacer{ height: 12px; }

        .sigera-footer__social{
            display:flex;
            flex-direction:column;
            gap:10px;
        }

        .sigera-footer__socialitem{
            display:flex;
            align-items:center;
            gap:8px;
            word-break: break-word;
        }

        .sigera-footer__icon{ font-size:16px; }

        .sigera-footer__social-col{
            margin-left: -110px;
            min-width: 280px;
        }

        .sigera-footer__socialitem--nowrap{
            white-space: nowrap;
        }

        .sigera-footer__links-col{
            margin-left: 30px;
        }

        @media (max-width: 900px){
            .sigera-footer{ padding: 22px 18px; }
            .sigera-footer__wrap{ gap: 22px; }
            .sigera-footer__title{ font-size:28px; }

            .sigera-footer__socialitem--nowrap{ white-space: normal; }
            .sigera-footer__links-col{ margin-left: 0; }
            .sigera-footer__social-col{ margin-left: 0; }
        }

        @media (max-width: 520px){
            .sigera-footer__logo{ height:44px; }
            .sigera-footer__title{ font-size:20px; }
            .sigera-footer__subtitle,
            .sigera-footer__desc,
            .sigera-footer__list,
            .sigera-footer__text,
            .sigera-footer__social{ font-size:13px; }
        }
    </style>
</footer>
<?php /**PATH C:\laragon\www\KP_SIGERAI\resources\views/partials/footer.blade.php ENDPATH**/ ?>