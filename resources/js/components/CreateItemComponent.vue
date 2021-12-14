<template>
    <div class="container-fluid">
    <div class="">
        <div class="mx-auto" style="max-width:1200px">
            <h1 style="color:#555555; text-align:center; font-size:1.2em; padding:24px 0px; font-weight:bold;">商品登録</h1>
            <div class="">
                <div class="d-flex flex-row flex-wrap">
                    <form id="create_item_form" @submit="submit" action="" enctype="multipart/form-data" method="post">
                    <p v-if="errors.length">
                        <font style="color:red;">
                            <ul>
                                <li v-for="(error,index) in errors" :key="index">{{ error }}</li>
                            </ul>
                        </font>
                    </p>
                    <div class="container-create">
                        <div class="field">
                            <div class="label">商品名</div>
                            <div><input placeholder="商品名" v-model="item_name"></div>
                        </div>
                        <div class="field">
                            <div class="label">画像</div>
                            <div>
                                <img :src="item_image" width="100" height="100">
                                <div style="display:flex;flex-direction: column;">
                                    <input ref="input_image" type="file" @change="change_item_image($event)" accept="image/jpeg, image/png"/>
                                </div>
                            </div>
                        </div>
                        <div class="field">
                            <div class="label">値段</div>
                            <div><input placeholder="値段" type="number" v-model="item_price">円</div>
                        </div>
                        <div class="field">
                            <div class="label">数量</div>
                            <div><input placeholder="数量" type="number" v-model="item_num">個</div>
                        </div>
                        <div class="field">
                            <div class="label">カテゴリ名</div>
                            <div>
                                <select v-model="item_category" v-init:item_category="item_category">
                                    <option value="0">カテゴリ名</option>
                                    <option v-for="category in category_list" :key="category.id" :value="category.id">{{category.name}}</option>
                                </select>
                            </div>
                        </div>
                        <div>
                            <input type="submit" value="登録">
                            <button @click="click_cancel()">キャンセル</button>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
</template>

<script>
    export default {
        data: function() {
            return {
                item_name: null,
                item_price: null,
                item_num: null,
                item_category: 0,
                item_image: "http://localhost/storage/images/noimage.png",
                item_file: null,
                category_list: [],
                errors: [],
            }
        },
        methods: {
            async change_item_image(event) {
                const files = event.target.files || event.dataTransfer.files
                const file = files[0];
                if (this.checkFile(file)) {
                    this.item_file = file;
                    this.item_image = URL.createObjectURL(file);
                }
            },
            checkFile(file) {
                let result = true
                const SIZE_LIMIT = 5000000 // 5MB
                // キャンセルしたら処理中断
                if (!file) {
                    result = false
                }
                // jpeg か png 関連ファイル以外は受付けない
                if (file.type !== 'image/jpeg' && file.type !== 'image/png') {
                    result = false
                }
                // 上限サイズより大きければ受付けない
                if (file.size > SIZE_LIMIT) {
                    result = false
                }
                return result
            },
            async load_category() {
                axios.get('/api/category_list').then((res) => {
                    this.category_list = res.data;
                });
            },
            async submit(e) {
                e.preventDefault();
                if (!this.checkForm()) {
                    return;
                }
                const formData = new FormData()
                formData.append('item_name', this.item_name);
                formData.append('item_price', this.item_price);
                formData.append('item_num', this.item_num);
                formData.append('item_category', this.item_category);
                formData.append('file', this.item_file);
                axios.post('/api/create_item',formData).then((res) => {
                    if (confirm('商品を登録しました！')) {
                        this.$router.push("/");
                    }
                });
            },
            click_cancel() {
                this.$router.push("/");
            },
            checkForm() {
                if (this.item_name && this.item_file && this.item_price && this.item_num && this.item_category > 0) {
                    return true;
                }

                this.errors = [];

                if (!this.item_name) {
                    this.errors.push('商品名を入力して下さい');
                }
                if (!this.item_file) {
                    this.errors.push("画像を設定して下さい");
                }
                if (!this.item_price) {
                    this.errors.push('値段を入力して下さい');
                }
                if (!this.item_num) {
                    this.errors.push('数量を入力して下さい');
                }
                if (this.item_category == 0) {
                    this.errors.push('カテゴリ名を入力して下さい');
                }

                return false;
            }
        },
        directives: {
            init: {
                bind(el, binding, vnode) {
                    vnode.context[binding.arg] = binding.value
                }
            }
        },
        created() {
            this.load_category();
        }
    }
</script>

<style>
    .container-create {
        display: flex;
        flex-direction: column;
        justify-content: center;
    }
    .field {
        display: flex;
        margin: 10px;
    }
    .label {
        width: 100px;
        margin-right: 10px;
    }
</style>