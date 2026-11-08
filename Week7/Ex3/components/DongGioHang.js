const DongGioHang = {
    props: {
        id: {
            type: Number,
            required: true
        },
        ten: {
            type: String,
            required: true
        },
        donGia: {
            type: Number,
            required: true
        },
        soLuong: {
            type: Number,
            required: true
        }
    },

    emits: ["doi-so-luong", "yeu-cau-xoa"],

    computed: {
        thanhTien() {
            return this.donGia * this.soLuong;
        }
    },

    methods: {
        dinhDangTien(giaTri) {
            return giaTri.toLocaleString("vi-VN") + " đồng";
        },

        tangSoLuong() {
            this.$emit("doi-so-luong", this.id, this.soLuong + 1);
        },

        giamSoLuong() {
            this.$emit("doi-so-luong", this.id, this.soLuong - 1);
        },

        yeuCauXoa() {
            this.$emit("yeu-cau-xoa", this.id);
        }
    },

    template: `
        <article class="cart-item">
            <div class="product-info">
                <h2>{{ ten }}</h2>
                <p>Đơn giá: {{ dinhDangTien(donGia) }}</p>
            </div>

            <div class="quantity-controls">
                <button
                    type="button"
                    @click="giamSoLuong"
                    :disabled="soLuong <= 1"
                    aria-label="Giảm số lượng"
                >
                    −
                </button>

                <span class="quantity">{{ soLuong }}</span>

                <button
                    type="button"
                    @click="tangSoLuong"
                    :disabled="soLuong >= 99"
                    aria-label="Tăng số lượng"
                >
                    +
                </button>
            </div>

            <strong class="item-total">
                {{ dinhDangTien(thanhTien) }}
            </strong>

            <button
                type="button"
                class="delete-button"
                @click="yeuCauXoa"
            >
                Xóa
            </button>
        </article>
    `
};