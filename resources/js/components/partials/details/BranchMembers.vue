<template>
<div class="table-responsive">
    <table class="table table-hover text-wrap js-basic-example dataTable table-custom table-striped m-b-0 c_list">
        <thead class="thead-dark">
            <tr>
                <th>Full Name</th>
                <th>Code</th>
                <th>Address</th>
                <th>Contact</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="user in branch.users" :key="user.id">
                <td>{{user.first_name}} {{user.middle_name}} {{user.last_name}}</td>
                <td>{{user.unique_id}}</td>
                <td>{{user.street}}, {{(user.street2) ? user.street2+', ': ''}} <br />{{user.city}}</td>
                <td>{{user.email}} <br /> {{user.phone}}</td>
                <td>
                    <div class="btn-group">
                        <button class="btn btn-sm btn-success" @click="seeUser(user.id)"><i class="fa fa-eye" title="View"></i></button>
                        <button class="btn btn-sm btn-primary" @click="editUser(user)"><i class="fa fa-edit" title="Edit"></i></button>
                        <button class="btn btn-sm btn-default" @click="passwordChange(user)"><i class="fa fa-lock" title="Password"></i></button>
                        <button class="btn btn-sm btn-danger" @click="deleteUser(user.id)"><i class="fa fa-trash" title="Deactivate"></i></button>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</div>

</template>

<script>
export default {
    data(){
        return {
            accounts:{},
            loans:{},
            form: new Form({
                user_id: 0,
                password: '',
                password_confirm: '', 
            }),
        }
    },
    methods:{
        deleteRayment(id){},
        editUser(user){Fire.$emit('editUser', user);},
        getAllInitials(){},
        passwordChange(user){
            Fire.$emit('passwordChange', user);
        },
        seeUser(id){
            this.$router.push('/admin_area/member/details/'+ id)
            //Fire.$emit('viewUser', user);
            },
    },
    mounted() {   
        },
    props: {
        'branch': Object,
    },
}
</script>
