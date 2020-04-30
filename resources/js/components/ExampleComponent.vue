<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Todos los usuarios <b>{{this.pagination.total}}</b>
                        <div class="row">
                            <div class="col-md-3">
                                <select v-model="selectPerPage" class="form-control" @change="changePage(1)">
                                    <option value="5">5</option>
                                    <option  value="10">10</option>
                                    <option value="50">50</option>
                                </select>
                            </div>
                            <div class="col-md-5 offset-md-4">
                                <input type="text" placeholder="Buscar..." class="form-control" v-model.trim="search" @keyup="onKeySearch">
                            </div>
                        </div>
                    </div>
                    <div class="card-body table-responsive p-0"  style="height: 400px;">
                            <table class="table table-head-fixed text-nowrap">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Name</th>
                                        <th scope="col" >Email</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(user,index) in searchInUsers" :key="user.id">
                                        <td scope="row">{{user.id}}</td>
                                        <td>{{user.name}}</td>
                                        <td>{{user.email}}</td>
                                    </tr>
                                </tbody>
                            </table>
                    </div>
                    <div class="card-footer">
                        <nav aria-label="Page navigation">
                            <ul class="pagination">
                                <li v-if="pagination.currentPage == 1" class="page-item disabled">
                                    <a class="page-link" href="#" aria-label="Previous">
                                        <span aria-hidden="true">&laquo;</span>
                                        <span class="sr-only">Previous</span>
                                    </a>
                                </li>
                                <li v-else class="page-item">
                                    <a class="page-link" href="#" aria-label="Previous" @click.prevent="changePage(pagination.currentPage - 1)">
                                        <span aria-hidden="true">&laquo;</span>
                                        <span class="sr-only">Previous</span>
                                    </a>
                                </li>
                                <li v-for="(page,index) in getLinksPages" class="page-item" :class="[page === isCurrentPage ? 'active':'' ]">
                                    <span v-if="page === isCurrentPage" class="page-link">{{ page }}</span>
                                    <a v-else class="page-link" href="#" @click.prevent="changePage(page)" >{{page}}</a>
                                </li>
                                <li v-if="pagination.currentPage == pagination.lastPage" class="page-item disabled">
                                    <a class="page-link" href="#" aria-label="Previous">
                                        <span aria-hidden="true">&raquo;</span>
                                        <span class="sr-only">Next</span>
                                    </a>
                                </li>
                                <li v-else class="page-item">
                                    <a class="page-link" href="#" aria-label="Next" @click.prevent="changePage(pagination.currentPage + 1)">
                                        <span aria-hidden="true">&raquo;</span>
                                        <span class="sr-only">Next</span>
                                    </a>
                                </li>
                            </ul>
                        </nav>
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
                selectPerPage:10,
                search:'',
                pagination:{
                    perPage:10,
                    total:0,
                    currentPage:1,
                    from:0,
                    to:0,
                    lastPage:0,
                    currentUsers:[],
                    links:[]
                },

            }
        },
        created() {
            this.getAllUsers();
        },
        computed:{
            getCurrentUsers(){
                this.pagination.from = (this.pagination.currentPage-1)*this.pagination.perPage;
                this.pagination.to = Number(this.pagination.from) + Number(this.pagination.perPage);
                return this.users.slice(this.pagination.from,this.pagination.to);
            },
            getLinksPages(){
                let cant = this.pagination.total / Number(this.pagination.perPage);
                let i = 0;
                this.pagination.links=[]
                for ( i ; i <  cant; i++) {
                    this.pagination.links[i]=i+1;
                }
                this.pagination.lastPage = this.pagination.links.length;
                return this.pagination.links;
            },
            isCurrentPage(){
                return this.pagination.currentPage;
            },
            searchInUsers(){

                if (this.search.length > 0){
                    this.pagination.from = (this.pagination.currentPage-1)*this.pagination.perPage;
                    this.pagination.to = Number(this.pagination.from) + Number(this.pagination.perPage);
                    this.pagination.total = this.users.filter((user) => user.name.toLowerCase().includes(this.search.toLowerCase())).length;
                }else{
                    this.pagination.from = (this.pagination.currentPage-1)*this.pagination.perPage;
                    this.pagination.to = Number(this.pagination.from) + Number(this.pagination.perPage);
                    this.pagination.total = this.users.length;
                }
                return this.users.filter((user) => user.name.toLowerCase().includes(this.search.toLowerCase())).slice(this.pagination.from,this.pagination.to);
            }
        },
        methods:{
            getAllUsers(){
                let url ='api/allUsers'
                axios.get(url).then(response =>{
                    this.users= response.data;
                    this.total= this.users.length;
                });
            },
            changePage(page){
                this.pagination.perPage=this.selectPerPage;
                this.pagination.currentPage = Number(page);
            },
            onKeySearch(){
                this.changePage(1);
            }
        }
    }
</script>

<style>
    .table:not(.table-dark) {
        color: inherit;
    }
    .card-body > .table {
        margin-bottom: 0;
    }
    .text-nowrap {
        white-space: nowrap !important;
    }
    .table {
        width: 100%;
        margin-bottom: 1rem;
        color: #212529;
        background-color: transparent;
    }
    table {
        border-collapse: collapse;
    }
    *, ::after, ::before {
        box-sizing: border-box;
    }
</style>
