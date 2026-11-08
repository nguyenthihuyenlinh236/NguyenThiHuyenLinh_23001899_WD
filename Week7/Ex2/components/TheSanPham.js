const TheSanPham = {
    props: {
        ten: {
            type: String,
            required: true
        },

        gia: {
            type: Number,
            required: true
        },

        anh: {
            type: String,
            required: true
        },

        moTa: {
            type: String,
            default: "Sản phẩm chưa có mô tả."
        },

        soLuongTon: {
            type: Number,
            default: 0
        }
    },

    // Mỗi thẻ sản phẩm có trạng thái riêng.
    data() {
        return {
            hienMoTa: false
        };
    },

    methods: {
        dinhDangTien(gia) {
            return gia.toLocaleString("vi-VN") + " đồng";
        },

        muaHang() {
            if (this.soLuongTon <= 0) {
                return;
            }

            window.alert(`Bạn đã chọn mua: ${this.ten}`);
        }
    },

    template: `
        <article class="product-card">
            <img
                class="product-image"
                :src="anh"
                :alt="ten"
            >

            <div class="product-content">
                <span
                    class="badge"
                    :class="soLuongTon > 0 ? 'available' : 'sold-out'"
                >
                    {{ soLuongTon > 0 ? 'Còn hàng' : 'Hết hàng' }}
                </span>

                <h2>{{ ten }}</h2>

                <p class="price">{{ dinhDangTien(gia) }}</p>

                <p class="stock">Số lượng tồn: {{ soLuongTon }}</p>

                <button
                    type="button"
                    class="description-button"
                    @click="hienMoTa = !hienMoTa"
                    :aria-expanded="hienMoTa"
                >
                    {{ hienMoTa ? 'Ẩn mô tả' : 'Xem mô tả' }}
                </button>

                <p class="description" v-show="hienMoTa">
                    {{ moTa }}
                </p>

                <button
                    type="button"
                    class="buy-button"
                    :disabled="soLuongTon <= 0"
                    @click="muaHang"
                >
                    {{ soLuongTon > 0 ? 'Mua' : 'Tạm hết hàng' }}
                </button>
            </div>
        </article>
    `
};