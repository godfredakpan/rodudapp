<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">

                    <div class="card-body">
                        <ul>
                            <li v-for="data in test" :key="data.id">{{ data.title }}</li>
                        </ul>
                        <pagination :data="laravelData" @pagination-change-page="getResults"></pagination>

                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        },
        data() {
            return {
                laravelData: {},
            }
        },
        created() {
            this.getResults();
        },
        methods: {
            getResults(page) {
                if (typeof page === 'undefined') {
                    page = 1;
                }

                this.$http.get('/tests/all?page=' + page)
                    .then(response => {
                        return response.json();
                    }).then(data => {
                        this.laravelData = data;
                    });
            }
        }
    }
</script>
