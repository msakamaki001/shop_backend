<template>
    <div class="container-fluid">
    <div class="">
        <div class="mx-auto" style="max-width:1200px">
            <h1 style="color:#555555; text-align:center; font-size:1.2em; padding:24px 0px; font-weight:bold;">商品一覧</h1>
            <div class="">
                <div class="d-flex flex-row flex-wrap">
                    <div style="display: flex; flex-direction: column;">
                    <p v-if="error_msg.length">
                        <font style="color:red;">
                            <ul>
                               <li>{{ error_msg }}</li>
                            </ul>
                        </font>
                    </p>
                    <div style="display: flex">
                        <router-link to="/categorylist">カテゴリ一覧</router-link>
                        <router-link to="/createitem">商品登録</router-link>
                    </div>
                    </div>
                    <table class="table">
                        <thead>
                            <tr>
                                <th width="5%" scope="col">ID</th>
                                <th scope="col">商品名</th>
                                <th scope="col">画像</th>
                                <th scope="col">値段</th>
                                <th scope="col">数量</th>
                                <th scope="col">カテゴリ名</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody> 
                            <tr v-for="item in items" :key="item.id">
                                <td scope="row">
                                    {{item.id}}
                                </td>
                                <td :class="{expand: is_click_item_name}" scope="row">
                                    <div v-if="clicked_id == item.id && is_click_item_name">
                                        <div>
                                            <input placeholder="商品名" v-model="item_name" v-init:item_name="item.item_name">
                                            <button @click="change_item_name(item.id)">変更</button>
                                            <button @click="click_cancel()">キャンセル</button>
                                        </div>
                                    </div>
                                    <div v-else>
                                        <a href="#" @click="click_item_name(item.id)">
                                            {{item.item_name}}
                                        </a>
                                    </div>
                                </td>
                                <td :class="{expand_image: is_click_item_image}" scope="row">
                                    <div style="display:flex;" v-if="clicked_id == item.id && is_click_item_image">
                                        <img :src="item.image_path" width="100" height="100">
                                        <div style="display:flex;flex-direction: column;">
                                            <input ref="input_image" type="file" @change="change_item_image(item.id, $event)" accept="image/jpeg, image/png"/>
                                            <button style="width:100px;" @click="click_cancel()">キャンセル</button>
                                        </div>
                                    </div>
                                    <div v-else>
                                        <a href="#" @click="click_item_image(item.id)">
                                            <img :src="item.image_path" width="100" height="100">
                                        </a>
                                    </div>
                                </td>
                                <td :class="{expand: is_click_item_price}" scope="row">
                                    <div v-if="clicked_id == item.id && is_click_item_price">
                                        <input placeholder="値段" type="number" v-model="item_price" v-init:item_price="item.price">円
                                        <button @click="change_item_price(item.id)">変更</button>
                                        <button @click="click_cancel()">キャンセル</button>
                                    </div>
                                    <div v-else>
                                        <a href="#" @click="click_item_price(item.id)">
                                            {{item.price}}円
                                        </a>
                                    </div>
                                </td>
                                <td :class="{expand: is_click_item_num}" scope="row">
                                    <div v-if="clicked_id == item.id && is_click_item_num">
                                        <input placeholder="数量" type="number" v-model="item_num" v-init:item_num="item.num">個
                                        <button @click="change_item_num(item.id)">変更</button>
                                        <button @click="click_cancel()">キャンセル</button>
                                    </div>
                                    <div v-else>
                                        <a href="#" @click="click_item_num(item.id)">
                                            {{item.num}}個
                                        </a>
                                    </div>
                                </td>
                                <td :class="{expand: is_click_item_category}" scope="row">
                                    <div v-if="clicked_id == item.id && is_click_item_category">
                                        <select v-model="item_category" v-init:item_category="item.category_id">
                                            <option v-for="category in category_list" :key="category.id" :value="category.id">{{category.name}}</option>
                                        </select>
                                        <button @click="change_item_category(item.id)">変更</button>
                                        <button @click="click_cancel()">キャンセル</button>
                                    </div>
                                    <div v-else>
                                        <a href="#" @click="click_item_category(item.id)">
                                            {{item.category_name}}
                                        </a>
                                    </div>
                                </td>
                                <td scope="row">
                                    <button @click="remove_item(item.id)">削除</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <ul class="pagination">
                        <li :class="{disabled: current_page <= 1}"><a href="#" @click="change(1)">&laquo;</a></li>
                        <li :class="{disabled: current_page <= 1}"><a href="#" @click="change(current_page - 1)">&lt;</a></li>
                        <li v-for="page in pages" :key="page" :class="{active: page === current_page}">
                            <a href="#" @click="change(page)">{{page}}</a>
                        </li>
                        <li :class="{disabled: current_page >= last_page}"><a href="#" @click="change(current_page + 1)">&gt;</a></li>
                        <li :class="{disabled: current_page >= last_page}"><a href="#" @click="change(last_page)">&raquo;</a></li>
                    </ul>
                    <div style="margin-top: 40px" class="col-sm-6 text-right">全 {{total}} 件中 {{from}} 〜 {{to}} 件表示</div>
            </div>
        </div>
    </div>
    </div>
</template>

<script>
    export default {
        data: function() {
            return {
                clicked_id: 0,
                is_click_item_name: false,
                is_click_item_price: false,
                is_click_item_num: false,
                is_click_item_category: false,
                is_click_item_image: false,
                item_name: '',
                item_price: 0,
                item_num: 0,
                item_category: 0,
                item_image: null,
                error_msg: '',
                category_list: [],
                items: [],
                current_page: 1,
                last_page: 1,
                total: 1,
                from: 0,
                to: 0
            }
        },
        methods: {
            click_cancel() {
                this.clicked_id = 0;
                this.is_click_item_name = false;
                this.is_click_item_price = false;
                this.is_click_item_num = false;
                this.is_click_item_category = false;
                this.is_click_item_image = false;
                this.error_msg = '';
            },
            clear_flg() {
                this.is_click_item_name = false;
                this.is_click_item_price = false;
                this.is_click_item_num = false;
                this.is_click_item_category = false;
                this.is_click_item_image = false;
            },
            click_item_name(id) {
                this.clear_flg();
                this.clicked_id = id;
                this.is_click_item_name = true;
            },
            click_item_price(id) {
                this.clear_flg();
                this.clicked_id = id;
                this.is_click_item_price = true;
            },
            click_item_num(id) {
                this.clear_flg();
                this.clicked_id = id;
                this.is_click_item_num = true;
            },
            click_item_category(id) {
                this.clear_flg();
                this.clicked_id = id;
                this.is_click_item_category = true;
            },
            click_item_image(id) {
                this.clear_flg();
                this.clicked_id = id;
                this.is_click_item_image = true;
            },
            validate_item_name() {
                this.error_msg = '';
                if (!this.item_name) {
                    this.error_msg = "商品名を入力して下さい";
                    return false;
                }
                if (this.item_name.length > 100) {
                    this.error_msg = "商品名は100文字以内で入力して下さい"
                    return false;
                }
                return true;
            },
            validate_item_price() {
                this.error_msg = '';
                if (!this.item_price) {
                    this.error_msg = "値段を入力して下さい";
                    return false;
                }
                if (isNaN(this.item_price)) {
                    this.error_msg = "値段は数字で入力して下さい"
                    return false;
                }
                return true;
            },
            validate_item_num() {
                this.error_msg = '';
                if (!this.item_num) {
                    this.error_msg = "数量を入力して下さい";
                    return false;
                }
                if (isNaN(this.item_num)) {
                    this.error_msg = "数量は数字で入力して下さい"
                    return false;
                }
                return true;
            },
            async load(page) {
                axios.get('/api/item_list?page=' + page).then((res) => {
                    this.items = res.data.data;
                    this.current_page = res.data.current_page
                    this.last_page = res.data.last_page
                    this.total = res.data.total
                    this.from = res.data.from
                    this.to = res.data.to
                });
            },
            async load_category() {
                axios.get('/api/category_list').then((res) => {
                    this.category_list = res.data;
                });
            },
            async change(page) {
                if (page >= 1 && page <= this.last_page) this.load(page)
            },
            async change_item_name(id) {
                if (!this.validate_item_name()) {
                    return;
                }
                axios.post('/api/change_item_name',{id: id, item_name: this.item_name}).then((res) => {
                    this.is_click_item_name = false;
                    this.clicked_id = 0;
                    this.load(this.current_page);
                });
            },
            async change_item_price(id) {
                if (!this.validate_item_price()) {
                    return;
                }
                axios.post('/api/change_item_price',{id: id, item_price: this.item_price}).then((res) => {
                    this.is_click_item_price = false;
                    this.clicked_id = 0;
                    this.load(this.current_page);
                });
            },
            async change_item_num(id) {
                if (!this.validate_item_num()) {
                    return;
                }
                axios.post('/api/change_item_num',{id: id, item_num: this.item_num}).then((res) => {
                    this.is_click_item_num = false;
                    this.clicked_id = 0;
                    this.load(this.current_page);
                });
            },
            async change_item_category(id) {
                axios.post('/api/change_item_category',{id: id, item_category: this.item_category}).then((res) => {
                    this.is_click_item_category = false;
                    this.clicked_id = 0;
                    this.load(this.current_page);
                });
            },
            async change_item_image(id, event) {
                const files = event.target.files || event.dataTransfer.files
                const file = files[0];
                if (confirm("変更しますか？") && this.checkFile(file)) {
                    const formData = new FormData()
                    formData.append('id', id);
                    formData.append('file',file);
                    axios.post('/api/change_item_image',formData).then((res) => {
                        this.is_click_item_image = false;
                        this.clicked_id = 0;
                        this.load(this.current_page);
                    });
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
            async remove_item(id) {
                if (confirm("削除しますか？")) {
                    axios.post('/api/remove_item',{id: id}).then((res) => {
                        this.load(this.current_page);
                    });
                }
            },
        },
        computed: {
            pages() {
                let start = _.max([this.current_page - 2, 1])
                let end = _.min([start + 5, this.last_page + 1])
                start = _.max([end - 5, 1])
                return _.range(start, end)
            },
        },
        directives: {
            init: {
                bind(el, binding, vnode) {
                    vnode.context[binding.arg] = binding.value
                }
            }
        },
        created() {
            this.load(1);
            this.load_category();
        }
    }
</script>

<style scoped>
    .expand {
        width: 350px;
    }
    .expand_image {
        width: 500px;
    }
</style>