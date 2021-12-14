<template>
    <div class="container-fluid">
    <div class="">
        <div class="mx-auto" style="max-width:1200px">
            <h1 style="color:#555555; text-align:center; font-size:1.2em; padding:24px 0px; font-weight:bold;">カテゴリ登録</h1>
            <div class="">
                <div class="d-flex flex-row flex-wrap">
                    <form id="create_category_form" @submit="submit" action="" method="post">
                    <p v-if="errors.length">
                        <font style="color:red;">
                            <ul>
                                <li v-for="(error,index) in errors" :key="index">{{ error }}</li>
                            </ul>
                        </font>
                    </p>
                    <div class="container-create">
                        <div class="field">
                            <div class="label">カテゴリ名</div>
                            <div><input placeholder="カテゴリ名" v-model="category_name"></div>
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
                category_name: null,
                errors: [],
            }
        },
        methods: {
            async submit(e) {
                e.preventDefault();
                if (!this.checkForm()) {
                    return;
                }
                axios.post('/api/create_category',{category_name: this.category_name}).then((res) => {
                    if (confirm('カテゴリを登録しました！')) {
                        this.$router.push("/categorylist");
                    }
                });
            },
            click_cancel() {
                this.$router.push("/categorylist");
            },
            checkForm() {
                if (this.category_name) {
                    return true;
                }
                this.errors = [];
                if (!this.category_name) {
                    this.errors.push('商品名を入力して下さい');
                }
                return false;
            }
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