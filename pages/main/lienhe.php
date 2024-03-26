<?php
$sql_lh = "SELECT * FROM tbl_lienhe WHERE id=1";
$query_lh = mysqli_query($mysqli, $sql_lh);
?>

<div class="containerss" style="min-height: 100vh;">
    <div class="content">
        <h3>Liên hệ</h3>
        <?php
        while ($dong = mysqli_fetch_array($query_lh)) {
        ?>
            <p><?php echo $dong['thongtinlienhe'] ?></p>
        <?php
        }
        ?>
    </div>
    <div class="map">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3725.615241618266!2d105.7461898154139!3d21.030348993938874!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3135addc91a4b93f%3A0xf35812813fd70246!2zVG_DoGkgVOG7lSB0csOqdeG6r25n!5e0!3m2!1svi!2s!4v1647123456789!5m2!1svi!2s" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
    </div>
</div>

<style>
    .containerss {
		width: 80%;
        display: flex;
        flex-direction: row;
		margin: auto;
    }

    .content {
        width: 30%;
        padding: 20px;
    }

    .map {
        width: 70%;
        height: 70vh; /* Cho bản đồ chiếm toàn bộ chiều cao của container */
    }

    @media screen and (max-width: 768px) {
        /* Điều chỉnh layout cho màn hình nhỏ hơn 768px */
        .container {
            flex-direction: column; /* Chuyển sang layout dạng cột */
        }
        .content,
        .map {
            width: 100%;
        }
    }
</style>
