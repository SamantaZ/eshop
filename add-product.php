<?php
include('layout/header.php');

$ProductsController = new ProductsController();
$product_types = $ProductsController->getProductTypes();

if (isset($_POST['product'])) {
	$response = $ProductsController->add($_POST['product']);
}
?>
<main class="main">
	<div class="content">
		<form class="mb-9" id="product_form" action="" method="post" enctype="multipart/form-data">
			<div class="row g-3 justify-content-between align-items-center mb-5">
				<div class="col-auto">
					<h2 class="mb-2">Add a product</h2>
					<h5 class="text-700">All fields are mandatory</h5>
				</div>
				<div class="col-auto">
					<a href="index.php" class="btn btn-outline-secondary mb-2 mb-sm-0">Cancel</a>
					<button class="btn btn-primary btn-submit mb-2 mb-sm-0" type="submit">Save</button>
				</div>
			</div>
			<div class="row">
				<div class="col-12 col-xl-12">
					<div class="mb-5">
						<h4 class="mb-3">SKU</h4>
						<input class="form-control" type="text" placeholder="Write SKU here..." id="sku" name="product[sku]" minlength="8" required>
						<div id="skuHelp" class="form-text">Please provide at least 8 characters.</div>
						<small class="mb-5" id="skuError"></small>
					</div>
					<div class="mb-5">
						<h4 class="mb-3">Name</h4>
						<input class="form-control" type="text" placeholder="Write name here..." id="name" name="product[name]" required>
						<small class=" mb-5" id="nameError"></small>
					</div>
					<div class="mb-5">
						<h4 class="mb-3">Price</h4>
						<input class="form-control" type="number" step="any" placeholder="Write price here..." id="price" name="product[price]" required>
						<small class=" mb-5" id="priceError"></small>
					</div>
					<div class="card mb-3">
						<div class="card-body">
							<div class="row g-3">
								<div class="col-12 col-xl-12">
									<div class="mb-4">
										<h4 class="card-title mb-4">Product type</h4>
										<select class="form-select mb-3" id="productType" name="product[type_id]" required>
											<option value="">Select product type</option>
											<?php foreach ($product_types as $product_type) : ?>
												<option value="<?= $product_type['producttype_id']; ?>" id="<?= $product_type['producttype_name']; ?>"><?= $product_type['producttype_name'] == 'Dvd' ? strtoupper($product_type['producttype_name']): $product_type['producttype_name']; ?></option>
											<?php endforeach; ?>
										</select>
										<small class=" mb-5" id="productTypeError"></small>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="card mb-3 d-none" id="attributes">
						<div class="card-body">
							<h4 class="card-title mb-4">Attributes</h4>
							<div class="row g-3" id="displayAttributes"></div>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
</main>
<?php include('layout/footer.php'); ?>
<script>
	$(document).ready(function() {
		$("#productType").change(function() {
			const id = $("#productType").val();
			if (id !== '') {
				var typeName = $('#productType').find(':selected').text();
				$.ajax({
					type: "POST",
					url: 'fetch-attributes.php',
					data: {
						productType: {
							id: id,
							name: typeName
						}
					},
					success: function(response) {
						$("#displayAttributes").html(response);
						$('#attributes').removeClass('d-none');
						$('#attributes').addClass('d-block');
					}
				});
			} else {
				$('#attributes').addClass('d-none');
			}
		});

		const skuElement = document.querySelector('#sku');
		const nameElement = document.querySelector('#name');
		const priceElement = document.querySelector('#price');
		const productTypeElement = document.querySelector('#productType');


		const form = document.querySelector('#product_form');
		const isRequired = value => value === '' ? false : true;

		const showError = (input, message) => {
			const formField = input.parentElement;
			formField.classList.remove('success');
			formField.classList.add('invalid');

			const error = formField.querySelector('small');
			error.textContent = message;
		};

		const showSuccess = (input) => {
			const formField = input.parentElement;

			formField.classList.remove('error');
			formField.classList.add('success');

			const error = formField.querySelector('small');
			error.textContent = '';
		}

		const checkSku = () => {
			let valid = false;
			const min = 8;
			const sku = skuElement.value.trim();

			if (!isRequired(sku)) {
				showError(skuElement, "SKU is required.");
			} else if (sku.length < min) {
				showError(skuElement, "SKU must have at least 8 characters.");
			} else {
				showSuccess(skuElement);
				valid = true;
			}
			return valid;
		}

		const checkName = () => {
			let valid = false;
			const name = nameElement.value.trim();

			if (!isRequired(name)) {
				showError(nameElement, "Name is required.");
			} else {
				showSuccess(nameElement);
				valid = true;
			}
			return valid;
		}


		const checkPrice = () => {
			let valid = false;
			const price = priceElement.value.trim();

			if (!isRequired(price)) {
				showError(priceElement, "Price is required.");
			} else if (!$.isNumeric(price) || price == 0) {
				showError(priceElement, "Price must be a number greater then 0.");
			} else {
				showSuccess(priceElement);
				valid = true;
			}
			return valid;
		}

		const checkProductType = () => {
			let valid = false;
			const productType = productTypeElement.value.trim();

			if (!isRequired(productType)) {
				showError(productTypeElement, "You must select product type.");
			} else {
				showSuccess(productTypeElement);
				valid = true;
			}
			return valid;
		}

		const checkSize = () => {
			let valid = false;
			const sizeElement = document.querySelector('#size');
			const size = sizeElement.value.trim();

			if (!isRequired(size)) {
				showError(sizeElement, "Size is required.");
			} else if (!$.isNumeric(size) || size == 0) {
				showError(sizeElement, "Size must be a number greater then 0.");
			} else {
				showSuccess(sizeElement);
				valid = true;
			}
			return valid;
		}

		const checkWeight = () => {
			let valid = false;
			const weightElement = document.querySelector('#weight');
			const weight = weightElement.value.trim();

			if (!isRequired(weight)) {
				showError(weightElement, "Weight is required.");
			} else if (!$.isNumeric(weight) || weight == 0) {
				showError(weightElement, "Weight must be a number greater then 0.");
			} else {
				showSuccess(weightElement);
				valid = true;
			}
			return valid;
		}
		const checkWidth = () => {
			let valid = false;
			const widthElement = document.querySelector('#width');
			const width = widthElement.value.trim();

			if (!isRequired(width)) {
				showError(widthElement, "Width is required.");
			} else if (!$.isNumeric(width) || width == 0) {
				showError(widthElement, "Width must be a number greater then 0.");
			} else {
				showSuccess(widthElement);
				valid = true;
			}
			return valid;
		}

		const checkHeight = () => {
			let valid = false;
			const heightElement = document.querySelector('#height');
			const height = heightElement.value.trim();

			if (!isRequired(height)) {
				showError(heightElement, "Height is required.");
			} else if (!$.isNumeric(height) || height == 0) {
				showError(heightElement, "Height must be a number greater then 0.");
			} else {
				showSuccess(heightElement);
				valid = true;
			}
			return valid;
		}

		const checkLength = () => {
			let valid = false;
			const lengthElement = document.querySelector('#length');
			const length = lengthElement.value.trim();

			if (!isRequired(length)) {
				showError(lengthElement, "Length is required.");
			} else if (!$.isNumeric(length) || length == 0) {
				showError(lengthElement, "Length must be a number greater then 0.");
			} else {
				showSuccess(lengthElement);
				valid = true;
			}
			return valid;
		}

		form.addEventListener('input', function(e) {
			switch (e.target.id) {
				case 'sku':
					checkSku();
					break;
				case 'name':
					checkName();
					break;
				case 'price':
					checkPrice();
					break;
				case 'productType':
					checkProductType();
					break;
				case 'size':
					checkSize();
					break;
				case 'weight':
					checkWeight();
					break;
				case 'width':
					checkWidth();
					break;
				case 'height':
					checkHeight();
					break;
				case 'length':
					checkLength();
					break;
				default:
					break;
			}
		});
	});
</script>