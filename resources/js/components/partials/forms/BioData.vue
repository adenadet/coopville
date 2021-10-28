<template>
<div class="row clearfix">
    <div class="col-md-12">
        <div class="card">
            <div class="body">
<form @submit.prevent="editMode ? updateProfile() : (outside ? createContactOpen() : createContact()) ">
    <div class="row">
        <div class="col-sm-4">
            <div class="form-group">
                <label>First Name *</label>
                <input type="text" class="form-control" id="first_name" name="first_name" placeholder="First Name *" v-model="bio.first_name" required>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                <label>Middle Name</label>
                <input type="text" class="form-control" id="middle_name" name="middle_name" placeholder="Other Name " v-model="bio.middle_name">
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                <label>Last Name*</label>
                <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Last Name *" v-model="bio.last_name" required>
            </div>
        </div>
    </div>
    <div class="row">
        <!-- Get Address -->
        <div class="col-md-6 col-sm-12">
            <div class="form-group">
                <label>Address*</label>
                <input type="text" class="form-control" id="street" name="street" placeholder="Enter Address *" v-model="bio.street" required>
            </div>
        </div>
        <div class="col-md-6 col-sm-12">
            <div class="form-group">
                <label>Address2</label>
                <input type="text" class="form-control" id="street2" name="street2" placeholder="Enter Street Desc" v-model="bio.street2">
            </div>
        </div>
        <div class="col-md-6 col-sm-12">
            <div class="form-group">
                <label>City*</label>
                <input type="text" class="form-control" id="city" name="city" placeholder="Enter City *" v-model="bio.city" required>
            </div>
        </div>
        <div class="col-md-6 col-sm-12">
            <div class="form-group">
                <label>State</label>
                <select class="form-control" id="state_id" name="state_id" placeholder="Enter State / County *" required v-model="bio.state_id">
                    <option value="">Select State</option>
                    <option v-for="state in states" :key="state.id" :value="state.id">{{state.name}}</option>
                </select>
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="form-group">
                <label>Phone Number</label>
                <input type="number" class="form-control" id="phone" name="phone" placeholder="Enter Phone Number *" v-model="bio.phone" required>
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="form-group">
                <label>Branch</label>
                <select class="form-control" id="branch_id" name="branch_id" required v-model="bio.branch_id">
                    <option value="">---Select Branch</option>
                    <option v-for="branch in branches" :key="branch.id" :value="branch.id">{{branch.name}}</option>
                </select>
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="form-group">
                <label>Unique ID</label>
                <input type="text" class="form-control" id="unique_id" name="unique_id" placeholder="If you already have an ID please enter it here" v-model="bio.unique_id" disabled>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4 col-sm-12">
            <div class="form-group">
                <label>Email Address</label>
                <input type="text" class="form-control" id="email" name="email" placeholder="Enter Email Address *" v-model="bio.email">
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="form-group">
                <label>Sex</label>
                <select class="form-control" id="sex" name="sex" v-model="bio.sex" required>
                    <option value="">---Select Sex---</option>
                    <option value="Female">Female</option>
                    <option value="Male">Male</option>
                </select>
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <label>Date of Birth</label>
            <div class="form-group">
                <input required type="date" data-provide="datepicker" data-date-autoclose="true" class="form-control" placeholder="Birth Date" name="dob" id="dob" v-model="bio.dob" >
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <label>Profile Image</label>
            <div class="form-group">
                <input type="file" class="form-control" name="picture" id="picture" @change="updateProfilePic">
            </div>
        </div>
    </div>
    <input type="submit" name="submit" class="submit btn btn-success" value="Submit" />
</form>
            </div>
        </div>
    </div>
</div>
</template>
<script>
    export default {
        data(){
            return {
                bio: new Form({
                    id: '',
                    first_name: '', 
                    middle_name:'', 
                    last_name:'', 
                    email:'', 
                    unique_id:'', 
                    street:'', 
                    street2:'', 
                    city:'', 
                    state_id:'', 
                    phone:'', 
                    branch_id:'', 
                    dob:'',
                    sex:'', 
                    image:'', 
                }),
            }
        },
        methods:{
            createContactOpen(){
                this.bio.post('/api/member').then(response=>{
                    console.log(response.data.user.unique_id);
                    Swal.fire({
                        icon: 'success',
                        title: 'You have been successfully created. <br/>Your Unique ID is :'+response.data.user.unique_id
                        +' and Password is '+ response.data.password+',<br/> A SMS has been sent with User ID and Password also!',
                    });
                    this.bio.reset();
                })
                .catch(()=>{
                    this.$Progress.fail();
                    Swal.fire({
                        icon: 'error',
                        title: 'Your form was not sent try again later!',
                    });
                });
            },
            createContact(){
                this.bio.post('/api/member').then(response=>{
                    console.log(response);
                    Swal.fire({
                        icon: 'success',
                        title: 'You have been successfully created. <br/>Your Unique ID is :'+
                        +' and Password is '+ +',<br/> A SMS has been sent with User ID and Password!',
                    });
                    this.bio.reset();
                })
                .catch(()=>{
                    this.$Progress.fail();
                    Swal.fire({
                        icon: 'error',
                        title: 'Your form was not sent try again later!',
                    });
                });
            },
            updateProfile(){
                this.$Progress.start();
                this.bio.put('/api/coop/users/'+this.bio.id).
                then(response =>{
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Your work has been saved',
                        showConfirmButton: false,
                        timer: 1500
                        });
                    Fire.$emit('Refresh')
                })
                .catch(()=>{
                    this.$Progress.fail();
                    toast.fire({
                        icon: 'error',
                        title: 'Profile update was not unsuccessful, try again later!',
                    })
                });
            },
            updateProfilePic(e){
                let file = e.target.files[0];
                let reader = new FileReader();
                reader.onloadend - function(){this.bio.image = reader.result;}
                reader.readAsDataURL(file);
            },
            setValue(user){
                this.bio.fill(user);
            },
        },
        mounted() {
            Fire.$on('editUser', user =>{
                console.log(this.states);
                this.setValue(user);
            });   
        },
        props: {
            'branches': Array,
            'states': Array,
            'user': Object,
            'outside': Boolean,
            'editMode': Boolean,
        },
    }
</script>