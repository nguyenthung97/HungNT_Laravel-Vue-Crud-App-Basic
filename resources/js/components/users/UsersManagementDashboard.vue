
<template>
<!-- eslint-disable -->
    <div>
        <div class="card mt-3" v-if="active.dashboard">
            <div class="card-body">
                <h3>Manage Users 
                    <button class="btn btn-outline-success btn-sm float-right" @click="setActive('createUser')">
                        <i class="fas fa-plus"></i> New User
                    </button>
                </h3>

                <div class="alert-success alert" role="alert" v-if="success_message!==null">
                    {{success_message}}
                </div> 

                <div class="alert alert-danger" role="alert" v-if="danger_message!==null">
                    {{danger_message}}
                </div>

                <Paginator v-bind:results="results" v-on:get-page="getPage"></Paginator>
                
                <PaginatorDetail v-bind:results="results"></PaginatorDetail>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>User since</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="user in results.data">  
                            <td>{{user.name}}   </td> 
                            <td>{{user.email}}</td> 
                            <td>{{user.user_since}}</td> 
                            <td>
                                <div class="btn-group">
                                    <button class="btn btn-sm btn-warning" title="Edit User" @click="editUser(user)">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-sm btn-danger" @click.prevent="deleteUser(user)">
                                        <i class="fas fa-user-times"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <Paginator v-bind:results="results" v-on:get-page="getPage"></Paginator>
            </div>
        </div>

        <CreateUser v-if="active.createUser" 
        v-on:view-dashboard="setActive('dashboard')"
        v-on:created-user="flashSuccessAndReload()"> 
        </CreateUser>

        <EditUser v-if="active.editUser"
                  v-bind:user="user"
                  v-on:view-dashboard="setActive('dashboard')"
                  v-on:user-updated="flashSuccessAndReload()"
        >
        </EditUser>
        
    </div>
</template>
<script>
    import Paginator from '../utilities/pagination/Paginator.vue'
    import PaginatorDetail from '../utilities/pagination/PaginatorDetail.vue'
    import CreateUser from '../users/CreateUser.vue'
    import EditUser from '../users/EditUser.vue'
    export default{
        components: {Paginator, 
        PaginatorDetail,
        EditUser,
        CreateUser },

        mounted() {
            this.getUsers()
        },
        data(){
            return{
                results: {},
                active: {
                    createUser : false,
                    dashboard: true,
                    editUser: false,
                },
                params: {
                    page: 1,
                },
                success_message: null,
                danger_message: null,
            }
        },
        methods: {
            getUsers: function(){
                axios.get('/data/users', { params: this.params})
                .then(response => {
                    this.results = response.data.results
                })
            },
            deleteUser: function(user){
                let r = confirm('Are you sure want to delete user ' +user.name + ' from the system?')
                if(r){
                    axios.post('/data/users/' +user.id,{_method: 'DELETE'})
                    .then(response => {
                        this.flashSuccessAndReload('Successfully deleted user')
                    })
                    .catch(errors=> {
                        if(errors.response.status == 403){
                            this.flashDanger('Unauthorized to delete user');
                        }
                    })
                } 
            },
            editUser: function(user){
                this.user = user
                this.setActive('editUser')
                
            },
            getPage: function(event){
                this.params.page = event
                this.getUsers()
            },
            setActive: function(component){
                Object.keys(this.active).forEach(key=>this.active[key] = false)
                this.active[component] = true
            },
            flashSuccessAndReload: function(event){
                this.setActive('dashboard')
                this.flashSuccess(event)
                this.getUsers()
            },
            flashDanger: function(message){
                this.danger_message = message
                setTimeout(()=> {this.danger_message = null},5000)
            },
             flashSuccess: function(message){
                this.success_message = message
                setTimeout(()=> {this.success_message = null},5000)
            }
        }
       
    }
</script>