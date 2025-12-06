<style>
    .hero {
        position: relative;
        width: 100%;
        height: 500px;
        background: url('<?= base_url('assets/img/construction.jpg'); ?>') center/cover no-repeat;
        display: flex;
        justify-content: center;
        align-items: center;
        text-align: center;
        color: #fff;
    }

    .hero::after {
        content: "";
        position: absolute;
        inset: 0;
        background: rgba(0, 0, 0, 0.75);
    }

    .hero-content {
        position: relative;
        z-index: 2;
    }

    .hero-content h1 {
        font-size: 2.8rem;
        font-weight: 700;
        color: #eab308;
        line-height: 1.3;
    }

    .hero-content p {
        margin-top: 12px;
        font-size: 1rem;
        max-width: 620px;
        margin-left: auto;
        margin-right: auto;
    }

    .hero-content .btn-hero {
        margin-top: 20px;
        padding: 10px 28px;
        background: #eab308;
        border-radius: 6px;
        font-weight: 600;
        display: inline-block;
        color: #000;
        text-decoration: none;
    }

    .services-section {
        background: #1f2937;
        padding: 60px 0;
    }

    .services-wrapper {
        width: 90%;
        margin: auto;
        display: flex;
        gap: 25px;
        justify-content: center;
        flex-wrap: wrap;
    }

    .service-card {
        width: 420px;
        background: #fff;
        padding: 25px;
        border-radius: 10px;
        min-height: 220px;
        border: 4px solid transparent;
    }

    .service-card.yellow-border {
        border-top-color: #eab308;
    }

    .service-card h3 {
        font-size: 1.2rem;
        margin-top: 8px;
        color: #303841;
    }

    .service-card p {
        margin-top: 10px;
        color: #444;
    }

    .learn-more {
        margin-top: 18px;
        font-weight: bold;
        display: inline-block;
        color: #000;
        text-decoration: none;
    }

    .card-icon {
        width: 43px;
        height: 43px;
        border-radius: 8px;
        background: #ffffffff;
        display: flex;
        justify-content: center;
        align-items: center;
        color: #000;
        font-size: 1.3rem;
    }

    .about-section {
        background: #374151;
        padding: 70px 0;
        text-align: center;
        color: #e5e7eb;
    }

    .about-section h2 {
        font-size: 1.8rem;
        font-weight: 700;
        color: #fff;
    }

    .about-underline {
        width: 60px;
        height: 4px;
        background: #eab308;
        margin: 10px auto 25px;
    }

    .about-section p {
        width: 70%;
        margin: auto;
        line-height: 1.7;
        margin-bottom: 20px;
    }

    
    .hero-buttons {
        margin-top: 30px;
        display: flex;
        justify-content: center;
        gap: 20px;
    }

    .circle-btn {
        width: 45px;
        height: 45px;
        background: none;
        border-radius: 50%;
        border: 1px solid #ccc;
        display: flex;
        justify-content: center;
        align-items: center;
        cursor: pointer;
        color: #ffffffff;
        font-size: 1.2rem;
        transition: 0.2s ease;
    }

    .circle-btn:hover {
        background: #eab308;
        color: #000;
    }


</style>
</head>

<body>

<?= $this->include('Layout/header');?>

<section class="hero">
    <div class="hero-content">
        <h1>Bangun Masa Depan<br>Bersama Kami</h1>
        <p>
            Solusi lengkap untuk kebutuhan konstruksi, renovasi, dan bahan bangunan
            berkualitas tinggi dengan layanan profesional terpercaya.
        </p>
        <a href="#" class="btn-hero">Mulai Sekarang</a>
        <div class="hero-buttons">
            <div class="circle-btn" id="prevBtn">
                <i class="fa fa-angle-left"></i>
            </div>
            <div class="circle-btn" id="nextBtn">
                <i class="fa fa-angle-right"></i>
            </div>
        </div>

    </div>
</section>

<section class="services-section">
    <div class="services-wrapper">

        <div class="service-card">
            <div class="card-icon">
                <i class="fa-solid fa-hard-hat"></i>
            </div>
            <h3>Build</h3>
            <p>
                Layanan konstruksi dan pembangunan profesional dengan standar kualitas tinggi.
                Dari rumah tinggal hingga proyek komersial besar.
            </p>
            <a href="#" class="learn-more">Learn More →</a>
        </div>

        <div class="service-card yellow-border">
            <div class="card-icon">
                <i class="fa-solid fa-palette"></i>
            </div>
            <h3>Style</h3>
            <p>
                Desain interior dan eksterior yang memadukan estetika modern dan fungsionalitas
                optimal untuk menciptakan ruang impian Anda.
            </p>
            <a href="#" class="learn-more">Learn More →</a>
        </div>

    </div>
</section>

<section class="about-section">
    <h2>About</h2>
    <div class="about-underline"></div>

    <p>
        Bangun Bangsa adalah perusahaan konstruksi dan toko bahan bangunan terpercaya yang telah
        melayani ribuan proyek dengan komitmen pada kualitas, ketepatan waktu, dan kepuasan
        pelanggan. Kami menyediakan solusi lengkap mulai dari bahan bangunan berkualitas,
        jasa renovasi profesional, hingga perlengkapan kerja dan safety gear untuk memastikan proyek
        berjalan aman dan sukses.
    </p>

    <p>
        Dengan pengalaman bertahun-tahun dan tim profesional kompeten, kami siap mewujudkan
        visi konstruksi Anda dengan standar internasional dan harga kompetitif.
    </p>
</section>

<?= $this->include('Layout/footer'); ?>

<script>
    const heroImages = [
        "<?= base_url('assets/img/construction2.jpg'); ?>",
        "<?= base_url('assets/img/construction3.jpg'); ?>",
        "<?= base_url('assets/img/construction4.jpg'); ?>",
        "<?= base_url('assets/img/construction5.jpg'); ?>",
    ];

    let currentIndex = 0;

    const heroSection = document.querySelector(".hero");
    const prevBtn = document.getElementById("prevBtn");
    const nextBtn = document.getElementById("nextBtn");

    function updateHeroBackground() {
        heroSection.style.background = `url('${heroImages[currentIndex]}') center/cover no-repeat`;
    }

    prevBtn.addEventListener("click", () => {
        currentIndex = (currentIndex - 1 + heroImages.length) % heroImages.length;
        updateHeroBackground();
    });

    nextBtn.addEventListener("click", () => {
        currentIndex = (currentIndex + 1) % heroImages.length;
        updateHeroBackground();
    });
</script>

</body>
</html>
