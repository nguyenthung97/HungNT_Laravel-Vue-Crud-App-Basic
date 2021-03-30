<template>
<!-- eslint-disable-->
    <div>
        <div class="card mt-3">
            <div class="card-body">
                <h3>
                   <button class="btn btn-sm btn-outline-primary mr-3" @click="$emit('view-dashboard')">
                    <i class="fas fa-chevron-left"></i> Back
                   </button>
                    Edit User <small class="text-muted">{{user.name}}</small>
                </h3>

                <div class="alert alert-warning" role="alert" v-if="errors.length>0">
                    <ul>
                        <li v-for="error in errors">{{error}}</li>
                    </ul>
                </div>

                <hr>

                <div class="form-group row">
                    <label for="" class="col-3">Name</label>
                    <div class="col-9">
                        <input type="text" class="form-control" v-model="data.name">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="" class="col-3">Email</label>
                    <div class="col-9">
                        <input type="email" class="form-control" v-model="data.email"> 
                    </div>
                </div>

                <div class="form-group row">
                    <label for="" class="col-3">Role</label>
                    <div class="col-9">
                        <select class="form-control" v-model="data.role">
                            <option :value="'user'">User</option>
                            <option :value="'admin'">Admin</option>
                        </select>
                    </div>
                </div>

                <button class="btn-primary btn" @click="updateUser()">Update User</button>
            </div>
        </div>
    </div>
</template>
<script>
    export default{
        mounted(){
            this.assignUserToData()
        },
        props:['user'],
        data() {
            return{
                data: {
                    name:'',
                    email:'',
                    role:''
                },
                errors : [],
            }
        },
        methods: {
            updateUser: function(){
                this.errors =[]
                
                axios.post('/data/users/' +this.user.id, {
                    _method: 'PUT',
                    name: this.data.name,
                    email: this.data.email,
                    role: this.data.role
                })
                .then(response => {
                    this.$emit('user-updated', response.data.user.name+ "'s profile has been updated")
                })
                .catch(errors=>{
                    if(errors.response.status === 500){
                        this.errors.push["This email address may already be taken. Please try again."]
                    }
                })
                
            },
            assignUserToData: function(){
               Object.keys(this.data).forEach(key=> this.data[key] = this.user[key])
               this.data = this.user
            }
        },
        watch: {
            user: function(){
                this.assignUserToData()
            }
        }
    }
</script>