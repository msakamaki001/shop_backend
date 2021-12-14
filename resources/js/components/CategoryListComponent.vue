<template>
    <div class="container-fluid">
    <div class="">
        <div class="mx-auto" style="max-width:1200px">
            <h1 style="color:#555555; text-align:center; font-size:1.2em; padding:24px 0px; font-weight:bold;">カテゴリ一覧</h1>
            <div class="">
                <div class="d-flex flex-row flex-wrap">
                    <div style="display: flex;flex-direction: column;">
                    <p v-if="error_msg.length">
                        <font style="color:red;">
                            <ul>
                               <li>{{ error_msg }}</li>
                            </ul>
                        </font>
                    </p>
                    <div style="display: flex">
                        <router-link to="/">商品一覧</router-link>
                        <router-link to="/createcategory">カテゴリ登録</router-link>
                    </div>
                    </div>
                    <table class="table">
                        <thead>
                            <tr>
                                <th width="5%" scope="col">ID</th>
                                <th scope="col">カテゴリ名</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody> 
                            <tr v-for="category in categories" :key="category.id">
                                <td scope="row">
                                    {{category.id}}
                                </td>
                                <td :class="{expand: is_click_category_name}" scope="row">
                                    <div v-if="clicked_id == category.id && is_click_category_name">
                                        <div>
                                            <input placeholder="カテゴリ名" v-model="category_name" v-init:category_name="category.name">
                                            <button @click="change_category_name(category.id)">変更</button>
                                            <button @click="click_cancel()">キャンセル</button>
                                        </div>
                                    </div>
                                    <div v-else>
                                        <a href="#" @click="click_category_name(category.id)">
                                            {{category.name}}
                                        </a>
                                    </div>
                                </td>
                                <td scope="row">
                                    <button @click="remove_category(category.id)">削除</button>
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
                is_click_category_name: false,
                category_name: '',
                error_msg: '',
                categories: [],
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
                this.is_click_category_name = false;
                this.error_msg = '';
            },
            clear_flg() {
                this.is_click_category_name = false;
            },
            click_category_name(id) {
                this.clear_flg();
                this.clicked_id = id;
                this.is_click_category_name = true;
            },
            validate_category_name() {
                this.error_msg = '';
                if (!this.category_name) {
                    this.error_msg = "カテゴリ名を入力して下さい";
                    return false;
                }
                if (this.category_name.length > 100) {
                    this.error_msg = "カテゴリ名は100文字以内で入力して下さい"
                    return false;
                }
                return true;
            },
            async load(page) {
                axios.get('/api/category_list_paginate?page=' + page).then((res) => {
                    this.categories = res.data.data;
                    this.current_page = res.data.current_page
                    this.last_page = res.data.last_page
                    this.total = res.data.total
                    this.from = res.data.from
                    this.to = res.data.to
                });
            },
            async change(page) {
                if (page >= 1 && page <= this.last_page) this.load(page)
            },
            async change_category_name(id) {
                if (!this.validate_category_name()) {
                    return;
                }
                axios.post('/api/change_category_name',{id: id, category_name: this.category_name}).then((res) => {
                    this.is_click_category_name = false;
                    this.clicked_id = 0;
                    this.load(this.current_page);
                });
            },
            async remove_category(id) {
                if (confirm("削除しますか？")) {
                    axios.post('/api/remove_category',{id: id}).then((res) => {
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
        }
    }
</script>

<style scoped>
    .expand {
        width: 350px;
    }
</style>