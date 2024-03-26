<?php
	$sql_sua_slide = "SELECT * FROM tbl_slide WHERE id_slide='$_GET[idslide]' LIMIT 1";
	$query_sua_slide = mysqli_query($mysqli, $sql_sua_slide);
?>
<div class="row" style="margin-top: 20px;">
	<div class="col-md-12 table-responsive">
		<h2 class="the_h">Sửa bài viết</h2>
		<div class="panel panel-primary">
			<div class="panel-body">
				<?php
				while ($row = mysqli_fetch_array($query_sua_slide)) {
				?>
					<form method="POST" action="./modules/quanlyslide/xuly.php?idslide=<?php echo $row['id_slide'] ?>" enctype="multipart/form-data">
						<div class="row">
							<div class="form-group">
								<label for="thumbnail">Hình ảnh</label>
                <input type="file" class="form-control" id="thumbnail" name="hinhanh" accept="image/*">

								<img id="thumbnail_img" src="modules/quanlyslide/uploads/<?php echo $row['hinhanh'] ?>" width="150px">
							</div>
							<div class="form-group">
								<button class="btn btn-success" name="suaslide">Sửa slide</button>
							</div>
						</div>
					</form>
				<?php
				}
				?>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	// Cập nhật hình ảnh xem trước khi upload
	$('#thumbnail').change(function () {
		updateThumbnail();
	});

	function updateThumbnail() {
		var input = $('#thumbnail')[0];
		if (input.files && input.files[0]) {
			var reader = new FileReader();

			reader.onload = function (e) {
				$('#thumbnail_img').attr('src', e.target.result);
			};

			reader.readAsDataURL(input.files[0]);
		}
	}
</script>
