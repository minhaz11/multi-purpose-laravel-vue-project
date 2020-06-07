<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
              <div class="card-header">
                <h3 class="card-title">Users Table</h3>
                <button class="btn btn-success float-right" data-toggle="modal" data-target="#exampleModal">Add new <i class="fas fa-user-plus"></i></button>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4"><div class="row"><div class="col-sm-12 col-md-6"></div><div class="col-sm-12 col-md-6"></div></div><div class="row"><div class="col-sm-12"><table id="example1" class="table table-bordered table-striped dataTable dtr-inline" role="grid" aria-describedby="example1_info">
                  <thead>
                  <tr role="row"><th class="sorting_asc" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending">ID</th><th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending">Name</th><th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending">Email</th><th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Engine version: activate to sort column ascending">Type</th><th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending">Registered at</th><th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending">Modify</th></tr>
                  </thead>
                  <tbody>
                  <tr v-for="(user,i) in users" :key="i" role="row" class="odd">
                    <td tabindex="0" class="sorting_1">{{user.id}}</td>
                    <td tabindex="0" class="sorting_1">{{user.name}}</td>
                    <td>{{user.email}}</td>
                    <td>{{user.type}}</td>
                    <!-- <td>{{user.bio}}</td> -->
                    <td>{{user.created_at | date}}</td>
                    <td>
                        <!-- <div class="btn-group"> -->
                            <a href="#" @click="editUser(user)">
                                <i class="fa fa-edit blue"></i>
                            </a>||
                            <a href="#" @click="deleteUser(user.id)">
                                <i class="fa fa-trash red"></i>
                            </a>
                        <!-- </div> -->
                    </td>
                  </tr></tbody>

                </table></div></div><div class="row"><div class="col-sm-12 col-md-5"><div class="dataTables_info" id="example1_info" role="status" aria-live="polite">Showing 1 to 10 of 57 entries</div></div><div class="col-sm-12 col-md-7"><div class="dataTables_paginate paging_simple_numbers" id="example1_paginate"><ul class="pagination"><li class="paginate_button page-item previous disabled" id="example1_previous"><a href="#" aria-controls="example1" data-dt-idx="0" tabindex="0" class="page-link">Previous</a></li><li class="paginate_button page-item active"><a href="#" aria-controls="example1" data-dt-idx="1" tabindex="0" class="page-link">1</a></li><li class="paginate_button page-item "><a href="#" aria-controls="example1" data-dt-idx="2" tabindex="0" class="page-link">2</a></li><li class="paginate_button page-item "><a href="#" aria-controls="example1" data-dt-idx="3" tabindex="0" class="page-link">3</a></li><li class="paginate_button page-item "><a href="#" aria-controls="example1" data-dt-idx="4" tabindex="0" class="page-link">4</a></li><li class="paginate_button page-item "><a href="#" aria-controls="example1" data-dt-idx="5" tabindex="0" class="page-link">5</a></li><li class="paginate_button page-item "><a href="#" aria-controls="example1" data-dt-idx="6" tabindex="0" class="page-link">6</a></li><li class="paginate_button page-item next" id="example1_next"><a href="#" aria-controls="example1" data-dt-idx="7" tabindex="0" class="page-link">Next</a></li></ul></div></div></div></div>
              </div>
              <!-- /.card-body -->
            </div>
            </div>
        </div>
        <!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">{{mode==true?'Edit User':'Create new user'}}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="" @submit.prevent="mode==true ? updateUser(): createUser()">
      <div class="modal-body">
            <div class="form-group">
            <input v-model="form.name" type="text" name="name" placeholder="name"
                class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
            <has-error :form="form" field="name"></has-error>
            </div>
            <div class="form-group">
            <input v-model="form.email" type="text" name="email" placeholder="email"
                class="form-control" :class="{ 'is-invalid': form.errors.has('email') }">
            <has-error :form="form" field="email"></has-error>
            </div>

            <div class="form-group">
            <input v-model="form.password" type="password" name="password" placeholder="password"
                class="form-control" :class="{ 'is-invalid': form.errors.has('password') }" >
            <has-error :form="form" field="password"></has-error>
            </div>
             <div class="form-group">
            <select v-model="form.type"  name="type" placeholder="type"
                class="form-control" :class="{ 'is-invalid': form.errors.has('type') }">
                    <option value="">Select User Role</option>
                    <option value="admin">Admin</option>
                    <option value="user">User</option>
                    <option value="author">Author</option>
                </select>
            <has-error :form="form" field="type"></has-error>
            </div>
             <div class="form-group">
            <textarea v-model="form.bio" type="text" name="bio" placeholder="bio"
                class="form-control" :class="{ 'is-invalid': form.errors.has('bio') }" rows="5"></textarea>
            <has-error :form="form" field="bio"></has-error>
            </div>
            </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary red" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary green">{{mode==true?'Update':'Create'}}</button>
      </div>
      </form>
    </div>
  </div>
</div>
    </div>
</template>

<script>
    export default {

        data() {
            return {
                mode:false,
                users:{},
                form: new Form({
                    id:'',
                    name: '',
                    email:'',
                    password:'',
                    type:'',
                    bio:'',
                    photo:''
                }),
            }
        },
        methods: {
            editUser(data){
                this.mode = true
                 $("#exampleModal").modal("show")
                 this.form.fill(data)
            },
            updateUser(){
                this.$Progress.start()
                this.form.patch('api/user/'+this.form.id).then(()=>{
                    $("#exampleModal").modal("hide")
                    this.$Progress.finish()
                    Fire.$emit('refresh')
                    Toast.fire({
                    icon: 'success',
                    title: 'Updated successfully'
                    })
                    this.form.reset()
                    this.mode = false
                }).catch(()=>{
                     this.$Progress.fail()
                })
            },
            deleteUser(id){
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                         if(result.value){
                        this.form.delete('api/user/'+id).then(()=>{

                                Swal.fire(
                                'Deleted!',
                                'Your file has been deleted.',
                                'success'
                            )

                            Fire.$emit('refresh')
                        }).catch(()=>{
                            Swal.fire({
                                title: 'Error!',
                                text: 'Do you want to continue',
                                icon: 'error',
                                confirmButtonText: 'Cool'
                                })
                        })}

                    })
            },
            loaduser(){
                axios.get("api/user").then(({data})=>{
                    this.users=data.data
                    console.log(this.users);

                })
            },
            createUser() {
                this.$Progress.start()
               this.form.post('api/user').then(data=>{
                   Fire.$emit('refresh')
                    $("#exampleModal").modal("hide")
                    this.$Progress.finish()
                   Toast.fire({
                    icon: 'success',
                    title: 'Created successfully'
                    })
                    this.form.reset()
                }).catch((err)=>{
                    this.$Progress.fail()

                })
            }
        },
        created() {
           this.loaduser()
           Fire.$on('refresh', ()=>{
               this.loaduser()
           })
        }
    }
</script>
