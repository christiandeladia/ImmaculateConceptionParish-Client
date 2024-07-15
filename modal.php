<?php
// Assuming $coupon contains the coupon value
$coupon = 20; // For example, set it to 20 for demonstration
?>

<script>
    function applyCoupon() {
        var couponInput = document.getElementById('couponInput').value;
        var discountValue = 0;
        if (couponInput === 'ICP0FF20') {
            discountValue = <?php echo $coupon; ?>;
        }
        document.getElementById('discountDisplay').innerHTML = 'Discount: ' + discountValue;
    }
</script>

<!-- Your HTML code with the coupon input and display -->
<div class="address-card">
    <div style="display: flex; justify-content: space-between;">
        <span class="title"><i class='fa fa-ticket'></i> Apply coupons</span>
    </div>
    <hr>
    <div class="form">
        <input type="text" placeholder="Apply your coupons here" class="input_field" id="couponInput">
        <button class="change" onclick="applyCoupon()">
            <i class='fa fa-plus'></i> Apply
        </button>
    </div>
</div>

<!-- Display the discount value here -->
<div id="discountDisplay"></div>
