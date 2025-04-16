document.addEventListener("DOMContentLoaded", async function () {
    const { isFormVisible: initialFormVisible, originalSubtotal, couponApplyUrl, addressStoreUrl, csrfToken } = window.checkoutConfig;
    const toggleAddressFormBtn = document.getElementById("toggle-address-form");
    const newAddressForm = document.getElementById("new-address-form");
    const addressIdInput = document.getElementById("address_id");
    let isFormVisible = initialFormVisible;

    const GHN_TOKEN = "c0da72a0-0ea6-11f0-9f28-eacfdef119b3"; // Thay bằng token thực tế của bạn
    const SHOP_ID = "196271"; // Thay bằng ShopId thực tế của bạn

    async function fetchData(url, method = "GET", body = null) {
        try {
            const headers = {
                "Content-Type": "application/json",
                "Token": GHN_TOKEN
            };
            if (method === "POST") headers["ShopId"] = SHOP_ID;

            const response = await fetch(url, {
                method,
                headers,
                body: body ? JSON.stringify(body) : null
            });
            return await response.json();
        } catch (error) {
            console.error("Lỗi khi gọi API:", error);
            return null;
        }
    }

    async function loadProvinces() {
        const data = await fetchData(
            "https://dev-online-gateway.ghn.vn/shiip/public-api/master-data/province");
        if (data && data.code === 200) {
            const provinceSelect = document.getElementById("province");
            provinceSelect.innerHTML = '<option value="">Chọn tỉnh/thành</option>';
            data.data.forEach(province => {
                const option = document.createElement("option");
                option.value = province.ProvinceID;
                option.text = province.ProvinceName;
                option.dataset.name = province.ProvinceName;
                provinceSelect.appendChild(option);
            });
        }
    }

    async function loadDistricts(provinceId) {
        const districtSelect = document.getElementById("district");
        const wardSelect = document.getElementById("ward");

        districtSelect.innerHTML = '<option value="">Chọn quận/huyện</option>';
        wardSelect.innerHTML = '<option value="">Chọn xã/phường</option>';

        if (!provinceId) return;

        const data = await fetchData(
            "https://dev-online-gateway.ghn.vn/shiip/public-api/master-data/district");
        if (data && data.code === 200) {
            const districts = data.data.filter(d => d.ProvinceID == provinceId);
            districts.forEach(district => {
                const option = document.createElement("option");
                option.value = district.DistrictID;
                option.text = district.DistrictName;
                option.dataset.name = district.DistrictName;
                districtSelect.appendChild(option);
            });
        }
    }

    async function loadWards(districtId) {
        const wardSelect = document.getElementById("ward");
        wardSelect.innerHTML = '<option value="">Chọn xã/phường</option>';

        if (!districtId) return;

        const data = await fetchData(
            `https://dev-online-gateway.ghn.vn/shiip/public-api/master-data/ward?district_id=${districtId}`
        );
        if (data && data.code === 200) {
            data.data.forEach(ward => {
                const option = document.createElement("option");
                option.value = ward.WardCode;
                option.text = ward.WardName;
                option.dataset.name = ward.WardName;
                wardSelect.appendChild(option);
            });
        }
    }

    async function calculateShippingFee(fromDistrictId, toDistrictId, toWardCode) {
        const shippingFeeDisplay = document.getElementById("shipping_fee_display");
        const shippingFeeInput = document.getElementById("shipping_fee");
        const totalAmountDisplay = document.getElementById("total_amount_display");
        const totalAmountInput = document.getElementById("total_amount");

        const payload = {
            "from_district_id": parseInt(fromDistrictId),
            "to_district_id": parseInt(toDistrictId),
            "to_ward_code": toWardCode,
            "service_type_id": 2,
            "weight": 1000,
            "length": 20,
            "width": 20,
            "height": 20,
            "insurance_value": 0,
            "coupon": null
        };

        const data = await fetchData(
            "https://dev-online-gateway.ghn.vn/shiip/public-api/v2/shipping-order/fee", "POST",
            payload);
        if (data && data.code === 200) {
            const shippingFee = data.data.total;
            shippingFeeInput.value = shippingFee;
            shippingFeeDisplay.textContent = shippingFee.toLocaleString() + "₫";

            let subtotal = originalSubtotal;
            let discount = parseInt(document.getElementById("discount").value) || 0;
            let newTotal = subtotal + shippingFee - discount;
            totalAmountInput.value = newTotal;
            totalAmountDisplay.textContent = newTotal.toLocaleString() + "₫";
        } else {
            shippingFeeDisplay.textContent = "Không tính được phí ship!";
        }
    }

    const applyCouponBtn = document.getElementById("apply_coupon");
    const couponCodeInput = document.getElementById("coupon_code");
    const couponMessage = document.getElementById("coupon_message");
    const totalAmountDisplay = document.getElementById("total_amount_display");
    const shippingFeeDisplay = document.getElementById("shipping_fee_display");
    const shippingFeeInput = document.getElementById("shipping_fee");
    const totalAmountInput = document.getElementById("total_amount");
    const discountInput = document.getElementById("discount");

    let shippingFee = parseInt(shippingFeeInput.value);
    let totalAmount = parseInt(totalAmountInput.value);

    applyCouponBtn.addEventListener("click", async function () {
        const couponCode = couponCodeInput.value.trim();
        if (!couponCode) {
            couponMessage.textContent = "Vui lòng nhập mã giảm giá!";
            return;
        }

        try {
            const response = await fetch(couponApplyUrl, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": csrfToken
                },
                body: JSON.stringify({
                    coupon_code: couponCode,
                    total_amount: originalSubtotal + shippingFee
                })
            });

            const result = await response.json();

            if (result.success) {
                couponMessage.classList.remove("tw-text-red-500");
                couponMessage.classList.add("tw-text-green-500");
                couponMessage.textContent = result.message;

                const newTotal = result.new_total;
                totalAmountDisplay.textContent = newTotal.toLocaleString() + "₫";
                totalAmountInput.value = newTotal;
                discountInput.value = result.discount;

                shippingFee = parseInt(shippingFeeInput.value);
                totalAmountInput.value = newTotal + shippingFee;
                totalAmountDisplay.textContent = (newTotal + shippingFee).toLocaleString() + "₫";
            } else {
                couponMessage.classList.remove("tw-text-green-500");
                couponMessage.classList.add("tw-text-red-500");
                couponMessage.textContent = result.message;
            }
        } catch (error) {
            couponMessage.textContent = "Đã xảy ra lỗi, vui lòng thử lại!";
            console.error(error);
        }
    });

    if (toggleAddressFormBtn) {
        toggleAddressFormBtn.addEventListener("click", function () {
            if (isFormVisible) {
                newAddressForm.style.display = "none";
                toggleAddressFormBtn.textContent = "Thêm địa chỉ khác";
            } else {
                newAddressForm.style.display = "block";
                toggleAddressFormBtn.textContent = "Ẩn form thêm địa chỉ";
                document.querySelectorAll('input[name="address_id_temp"]').forEach(input =>
                    input.checked = false);
                addressIdInput.value = "";
            }
            isFormVisible = !isFormVisible;
        });
    }

    document.querySelectorAll('input[name="address_id_temp"]').forEach(radio => {
        radio.addEventListener("change", function () {
            addressIdInput.value = this.value;
        });
    });

    const checkedRadio = document.querySelector('input[name="address_id_temp"]:checked');
    if (checkedRadio) {
        addressIdInput.value = checkedRadio.value;
    }

    document.getElementById("province").addEventListener("change", async function () {
        await loadDistricts(this.value);
    });

    document.getElementById("district").addEventListener("change", async function () {
        await loadWards(this.value);
    });

    document.getElementById("ward").addEventListener("change", async function () {
        const districtId = document.getElementById("district").value;
        const wardCode = this.value;
        if (districtId && wardCode) {
            await calculateShippingFee("3695", districtId, wardCode);
        }
    });

    await loadProvinces();

    document.getElementById("new-address-form").addEventListener("submit", async function (e) {
        e.preventDefault();

        const provinceSelect = document.getElementById("province");
        const districtSelect = document.getElementById("district");
        const wardSelect = document.getElementById("ward");

        const provinceName = provinceSelect.options[provinceSelect.selectedIndex]?.dataset.name || "";
        const districtName = districtSelect.options[districtSelect.selectedIndex]?.dataset.name || "";
        const wardName = wardSelect.options[wardSelect.selectedIndex]?.dataset.name || "";
        const street = document.getElementById("street").value;

        document.getElementById("province_name").value = provinceName;
        document.getElementById("district_name").value = districtName;
        document.getElementById("ward_name").value = wardName;
        document.getElementById("full_address").value =
            `${street}, ${wardName}, ${districtName}, ${provinceName}`;

        try {
            const formData = new FormData(this);
            const response = await fetch(addressStoreUrl, {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": csrfToken,
                    "Accept": "application/json"
                },
                body: formData
            });

            const data = await response.json();

            if (!response.ok) {
                throw new Error(data.message || "Có lỗi xảy ra");
            }

            iziToast.success({
                title: 'Thành công',
                message: 'Thêm địa chỉ thành công!',
                position: 'topRight'
            });
            setTimeout(() => {
                location.reload();
            }, 2000);
        } catch (error) {
            console.error("Lỗi khi gửi form:", error);
            alert("Đã xảy ra lỗi: " + error.message);
        }
    });
});