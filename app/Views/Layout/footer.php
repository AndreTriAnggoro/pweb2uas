<style>
    footer {
        background: 303841;
        padding: 50px 60px;
        display: grid;
        grid-template-columns: 1.6fr 1fr 1fr 1fr;
        gap: 50px;
        
    }

    footer h3 {
        margin-bottom: 15px;
        font-size: 16px;
    }

    footer ul {
        list-style: none;
        line-height: 30px;
        font-size: 14px;
        color: #C8C8C8;
    }

    footer .brand {
        display: flex;
        align-items: flex-start;
        gap: 15px;
    }

    footer .brand img {
        width: 50px;
    }

    footer .brand .brand-text {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }
    footer .brand .brand-text .info{
        margin-left: -60px;
        margin-top: 10px;
    }


    footer .brand p {
        margin: 5px 0;
        color: #C8C8C8;
        font-size: 14px;
    }

    footer .brand .icon {
        display: flex;
        align-items: center;
        gap: 10px;
        margin: 6px 0;
    }

    .footer-end {
        display: flex;
        justify-content: space-between; 
        align-items: center;
        padding: 10px 20px;   
        width: 100%;         
        grid-column: 1 / -1;
        border-top: 1px solid #4A535C;
    }

    .footer-end .social {
        gap: 40px;
    }

    .footer-bottom {
        font-size: 14px;
        color: #C8C8C8;
        text-align: right;   
    }

</style>
<footer>
    <div class="brand">
    <img src="<?= base_url('assets/img/logo.svg'); ?>" alt="Logo" class="logo" />

    <div class="brand-text">
        <h2 style="font-size:18px; padding-top: 12px; padding-bottom: 12px;">Bangun Bangsa</h2>

        <div class="info">
            <p>Jl. Pembangunan No. 123 Jakarta Selatan 12345 Indonesia</p>
    
            <div class="icon"><i class="fa fa-envelope"></i> info@bangunbangsa.com</div>
            <div class="icon"><i class="fa fa-phone"></i> +62 21 1234 5678</div>
        </div>
    </div>
    </div>

    <div>
        <h3>Company</h3>
        <ul>
            <li>About</li>
            <li>Career</li>
            <li>Contact</li>
            <li>Services</li>
        </ul>
    </div>

    <div>
        <h3>Layanan</h3>
        <ul>
            <li>Home Construction</li>
            <li>Tools Rental</li>
            <li>Safety Gear</li>
            <li>Architecture</li>
            <li>Consultant</li>
        </ul>
    </div>

    <div>
        <h3>Support & Store</h3>
        <ul>
            <li>Jakarta Pusat</li>
            <li>Jakarta Selatan</li>
            <li>Bandung</li>
            <li>Surabaya</li>
            <li>Konsultasi</li>
        </ul>
    </div>

    <div class="footer-end">
        <div class="social" >
            <i class="fab fa-facebook"></i>
            <i class="fab fa-instagram"></i>
            <i class="fab fa-linkedin"></i>
        </div>

        <div class="footer-bottom">
            © 2024 Bangun Bangsa. All rights reserved.
        </div>
    </div>
</footer>
