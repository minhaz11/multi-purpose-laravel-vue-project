<style  scoped>
    .widget-user-header{
        background-position: center center;
        background-size: cover;
        background: url('./img/photo1.png')

    }
    .widget-user-image img{
        height: 170px;
        width: 170px;
    }
</style>
<template>
    <div class="container">

        <div class="row justify-content-center">
           <div class="col-md-12">
            <!-- Widget: user widget style 1 -->
            <div class="card card-widget widget-user">
              <!-- Add the bg color to the header using any of the bg-* classes -->
              <div class="widget-user-header text-white" style="height:300px">
                <h3 class="widget-user-username text-right">Elizabeth Pierce</h3>
                <h5 class="widget-user-desc text-right">Web Designer</h5>
              </div>
              <div class="widget-user-image">
                <img class="img-circle" :src="userPhoto()" alt="User Avatar" >
              </div>
              <div class="card-footer">
                <div class="row">
                  <div class="col-sm-4 border-right">
                    <div class="description-block">
                      <h5 class="description-header">3,200</h5>
                      <span class="description-text">SALES</span>
                    </div>
                    <!-- /.description-block -->
                  </div>
                  <!-- /.col -->
                  <div class="col-sm-4 border-right">
                    <div class="description-block">
                      <h5 class="description-header">13,000</h5>
                      <span class="description-text">FOLLOWERS</span>
                    </div>
                    <!-- /.description-block -->
                  </div>
                  <!-- /.col -->
                  <div class="col-sm-4">
                    <div class="description-block">
                      <h5 class="description-header">35</h5>
                      <span class="description-text">PRODUCTS</span>
                    </div>
                    <!-- /.description-block -->
                  </div>
                  <!-- /.col -->
                </div>
                <!-- /.row -->
              </div>
            </div>
            <!-- /.widget-user -->
          </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-12">
            <div class="card">
              <div class="card-header p-2">
                <ul class="nav nav-pills">
                  <li class="nav-item"><a class="nav-link" href="#activity" data-toggle="tab">Activity</a></li>

                  <li class="nav-item"><a class="nav-link active" href="#settings" data-toggle="tab">Settings</a></li>
                </ul>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content">
                  <div class="tab-pane" id="activity">
                    <!-- Post -->

                    <!-- /.post -->
                  </div>

                  <div class="tab-pane active" id="settings">
                    <form class="form-horizontal">
                      <div class="form-group row">
                        <label for="inputName" class="col-sm-2 col-form-label" >Name</label>
                        <div class="col-sm-10">
                          <input v-model="form.name" type="email" class="form-control" id="inputName" placeholder="Name" name="name">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-10">
                          <input v-model="form.email" type="email" class="form-control" id="inputEmail" placeholder="Email" name="email">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputName2" class="col-sm-2 col-form-label">Password</label>
                        <div class="col-sm-10">
                          <input type="password" v-model="form.password" class="form-control" id="inputName2" placeholder="Change password" name="password">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputExperience" class="col-sm-2 col-form-label">Biography</label>
                        <div class="col-sm-10">
                          <textarea v-model="form.bio" class="form-control" id="inputExperience" placeholder="Experience" name="bio"></textarea>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputSkills" class="col-sm-2 col-form-label">Photo</label>
                        <div class="col-sm-10">
                          <input @change="uploadFile" type="file" class="form-control-file" id="inputSkills" name="photo">
                        </div>
                      </div>
                      <div class="form-group row">
                        <div class="offset-sm-2 col-sm-10">
                          <div class="checkbox">
                            <label>
                              <input type="checkbox"> I agree to the <a href="#">terms and conditions</a>
                            </label>
                          </div>
                        </div>
                      </div>
                      <div class="form-group row">
                        <div class="offset-sm-2 col-sm-10">
                          <button type="submit" class="btn btn-success" @click.prevent="updateInfo">Update</button>
                        </div>
                      </div>
                    </form>
                  </div>
                  <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
              </div><!-- /.card-body -->
            </div>
            <!-- /.nav-tabs-custom -->
          </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
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
        methods:{
            userPhoto(){
                return "uploads/profile/"+this.form.photo
            },
            updateInfo(){
                this.$Progress.start()
                this.form.put('api/profile').then(()=>{
                     Fire.$emit('refresh')
                     this.$Progress.finish()
                     Toast.fire({
                    icon: 'success',
                    title: 'Updated successfully'
                    })
                }).catch(()=>{
                    this.$Progress.fail()
                })
            },
            uploadFile(e){
                //converting base64 of image
                let file = e.target.files[0]
                let reader = new FileReader();
               if(file['size']<=2111775){
                    reader.onloadend =(file)=>{
                    this.form.photo = reader.result
                }
                  reader.readAsDataURL(file)
               } else{
                   Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'File size is more than 2 megabytes',
                        })
               }
            }
        },
        mounted() {
         axios.get('api/profile').then(({data})=>{
               this.form.fill(data)
           })

        },
        created(){
             Fire.$on('refresh', ()=>{
                axios.get('api/profile').then(({data})=>{
                this.form.fill(data)
           })
           })
        }
    }
</script>
