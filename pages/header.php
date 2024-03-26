<div class="header">
    <div class="p-2" style="background-color: black; font-size:15px;">
        <div class="container d-flex justify-content-between">
            <div class="">
                <p class="text-light m-0">abc@gmail.com <span>|</span> 0123 456 789</p>
            </div>
            <div class="d-flex">
                <?php
                if (isset($_SESSION['dangky'])) {
                ?>
                    <li class="ml-3" style="color:#fff;"><u><?php echo $_SESSION["dangky"] ?></u></li>
                    <li class="ml-3" style="color:#fff;">|</li>
                    <li class="ml-3"><a class="text-light" href="index.php?dangxuat=1">Đăng xuất </a></li> 

                <?php
                } else {
                ?>
                   <li class="ml-3"><a class="text-light" href="index.php?page=dangnhap">Đăng nhập</a></li>
                    <li class="ml-3" style="color:#fff;">|</li>
                    <li class="ml-3"><a class="text-light" href="index.php?page=dangky">Đăng ký</a></li> 

                <?php
                }
                ?>
            </div>
        </div>
    </div>
    <div class="container d-flex justify-content-between align-items-center">
        <div class="py-3">
            <a class="a321" href="index.php">
            <span class="rainbow-text">Gobike</span></a>
                </div>
        <div style="flex-grow: 0.5;">
            <div class="form-group has-search mb-0">
                <div style="border:2px solid black;overflow:hidden" class="rounded">
                    <form action="index.php?page=timkiem" method="POST" class="d-flex">
                        <input style="outline: none;border:none; flex-grow:1;" class="px-2 py-2 " type="text" placeholder="Tìm kiếm sản phẩm..." name="tukhoa">
                        <button class="px-3" style="outline:none;border:none;cursor:pointer; border-radius:30px 0 0 30px;background:black; color:white;" name="timkiem" type="submit">Tìm kiếm</button>
                    </form>
                </div>
            </div>
        </div>
        <div>
  <button type="button" class="btn btn-dark bg-white text-dark p-0" style="border: 2px solid black; border-radius:30px;">
    <a class="text-dark d-block py-2 px-3" href="index.php?page=giohang">
        <i class='bx bxs-cart'></i> Giỏ hàng 
        (<?php echo isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0; ?>)
    </a>
</button>

        </div>
    </div>
</div>