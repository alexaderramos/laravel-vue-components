<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Todos los usuarios</div>

                    <div class="card-body">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(user,index) in currentUsers" :key="user.id">
                                <td scope="row">{{user.id}}</td>
                                <td>{{user.name}}</td>
                                <td>{{user.email}}</td>
                            </tr>
                            </tbody>
                        </table>
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
        data(){
            return{
                users:[],
                pagination:{
                    perPage:5,
                    total:0,
                    currentPage:1,
                    from:0,
                    to:0,
                },
                currentUsers:[]
            }
        },
        created() {
            this.getAllUsers();
        },
        computed:{

        },
        methods:{
            getAllUsers(){
                let url ='api/allUsers'
                axios.get(url).then(response =>{
                    this.users= response.data;
                    this.total= this.users.length;
                });
            },
           /* getCurrentUsers(){
                offset= (offset-1)*this.pagination.perPage;
                let limit = this.pagination.perPage+offset;
                this.currentUsers = this.users.slice(offset,limit);
            }*/
        }
    }
</script>
